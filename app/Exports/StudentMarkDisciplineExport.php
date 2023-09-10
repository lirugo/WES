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

  public function __construct(Team $team, User $user, string $discipline_name, Collection $activities)
  {
    $this->user = $user;
    $this->team = $team;
    $this->discipline_name = $discipline_name;
    $this->activities = $activities;
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
      'B' => 60,
    ];
  }

  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function (AfterSheet $event) {

        $event->sheet->getDelegate()->getStyle('C')
          ->getAlignment()
          ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      },
    ];
  }

  public function headings(): array
  {
    return [
      [$this->user->getFullName(), '', 'Оцінка'],
      ['Дисципліна', 'Активність']
    ];
  }

  public function array(): array
  {
    $output = [];
    foreach ($this->activities as $activity) {
      $row = [$activity->discipline->display_name, $activity->name];
      $mark = $activity->getMark($this->user->id) ? $activity->getMark($this->user->id)->mark : '';
      array_push($row, $mark);
      array_push($output, $row);
    }

    return $output;
  }
}