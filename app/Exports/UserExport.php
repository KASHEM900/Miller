<?php
namespace App\Exports;

use App\User;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class UserExport implements  FromArray, WithHeadings, WithEvents {
    protected $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    // set the headings
    public function headings(): array
    {
        return [
            'Name', 'User Type', 'Email'
        ];
    }

    // freeze the first row with headings
    public function registerEvents(): array
    {
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'FFFF0000'],
                ],
            ],
        ];

        return [

            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

    public function array():array
    {
        return $this->users;
    }
}
