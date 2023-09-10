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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeamMarkExport implements FromArray, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles, WithEvents
{
  use Exportable;

  public function __construct(Team $team, Collection $users, Collection $activities, Collection $groupWorks, Collection $preTests)
  {
    $this->team = $team;
    $this->users = $users;
    $this->activities = $activities;
    $this->groupWorks = $groupWorks;
    $this->preTests = $preTests;
  }

  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle("B1:ZZ1")->getAlignment()->setTextRotation(90);

    return [
      1 => ['font' => ['bold' => true]],
    ];
  }

  public function columnWidths(): array
  {
    $cols = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    $out = ['A' => 30];
    foreach ($cols as $col1) {
      $out += [$col1 => 5];
    }
    foreach ($cols as $col1) {
      foreach ($cols as $col2) {
        $out += [$col1 . $col2 => 5];
      }
    }
    return $out;
  }

  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function (AfterSheet $event) {
        $cells = $event->sheet->getDelegate()->getCellCollection();

        foreach ($cells as $cell) {
          $event->sheet->getDelegate()->getColumnDimension($cell)->setWidth(5);
        }

        $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(450);
        $event->sheet->getDelegate()->getStyle('A1:A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $event->sheet->getDelegate()->getStyle('A1:A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $event->sheet->getDelegate()->getStyle('B1:ZZ1')->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
        $event->sheet->getDelegate()->getStyle('B1:ZZ1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $event->sheet->getDelegate()->getStyle('B2:ZZ99')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); //TODO too long
      },
    ];
  }

  public function headings(): array
  {
    $output = [];
    $row = ['ПІБ|Тип|Дисципліна'];

    foreach ($this->activities as $activity) {
      array_push($row, ' Активність | ' . $activity->discipline->display_name);
    }

    foreach ($this->groupWorks as $groupWork) {
      array_push($row, ' Группова р | ' . $groupWork->name);
    }

    foreach ($this->preTests as $preTest) {
      array_push($row, ' Претест      | ' . $preTest->name);
    }

    array_push($output, $row);
    return $output;
  }

  public function array(): array
  {
    $output = [];
    foreach ($this->users as $student) {
      $row = [$student->getFullName()];
      foreach ($this->activities as $activity) {
        $mark = $activity->getMark($student->id) ? $activity->getMark($student->id)->mark : '';
        array_push($row, $mark);
      }

      foreach ($this->groupWorks as $groupWork) {
        $mark = $groupWork->getMark($student->id) ? $groupWork->getMark($student->id)->mark : '';
        array_push($row, $mark);
      }

      foreach ($this->preTests as $preTest) {
        $mark = $preTest->getMark($student->id) ? $preTest->getMark($student->id)->mark : '';
        array_push($row, $mark);
      }

      array_push($output, $row);
    }

    return $output;
  }
}