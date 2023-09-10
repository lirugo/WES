<?php

namespace App\Exports;

use App\Team;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentMarkDisciplineExport implements FromArray, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles, WithEvents
{
  use Exportable;

  public function __construct(Team $team, User $user, string $discipline_name, Collection $activities, Collection $groupWorks, Collection $preTests)
  {
    $this->user = $user;
    $this->team = $team;
    $this->discipline_name = $discipline_name;
    $this->activities = $activities;
    $this->groupWorks = $groupWorks;
    $this->preTests = $preTests;
  }

  public function styles(Worksheet $sheet)
  {
    return [
      1 => ['font' => ['bold' => true]],
      2 => ['font' => ['bold' => true]],
    ];
  }

  public function columnWidths(): array
  {
    return [
      'A' => 60,
      'B' => 20,
      'C' => 60,
    ];
  }

  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function (AfterSheet $event) {

        $event->sheet->getDelegate()->getStyle('D')
          ->getAlignment()
          ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      },
    ];
  }

  public function headings(): array
  {
    return [
      [$this->user->getFullName()],
      ['Дисципліна', 'Тип', 'Назва', 'Оцінка']
    ];
  }

  public function array(): array
  {
    $output = [];
    foreach ($this->activities as $activity) {
      $row = [$activity->discipline->display_name, 'Активність', $activity->name];
      $mark = $activity->getMark($this->user->id) ? $activity->getMark($this->user->id)->mark : '';
      array_push($row, $mark);
      array_push($output, $row);
    }

    foreach ($this->groupWorks as $groupWork) {
      $row = [$groupWork->discipline->display_name, 'Группова робота', $groupWork->name];
      $mark = $groupWork->getMark($this->user->id) ? $groupWork->getMark($this->user->id)->mark : '';
      array_push($row, $mark);
      array_push($output, $row);
    }

    foreach ($this->preTests as $preTest) {
      $row = [$preTest->discipline->display_name, 'Претест', $preTest->name];
      $mark = $preTest->getMark($this->user->id) ? $preTest->getMark($this->user->id)->mark : '';
      array_push($row, $mark);
      array_push($output, $row);
    }

    return $output;
  }
}