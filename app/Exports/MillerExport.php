<?php
namespace App\Exports;

use App\User;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MillerExport implements  FromArray, WithHeadings, WithEvents, WithCustomStartCell {
    protected $millers,$exportdata;

    public function __construct(array $millers, $exportdata)
    {
        $this->millers = $millers;
        $this->exportdata = $exportdata;
    }

    // set the headings
    public function headings(): array
    {
       if($this->exportdata == 1)
       {
            return
            [
                [' ', ' ', ' ', 'তথ্য অনুযায়ী চালকলের সমূহের তালিকা', ' ', ' ', ' '],
                [' ', ' ', ' ', ' ', ' ', ' ', ' '],
                ['চালকলের নাম', 'মালিকের নাম', 'মোবাইল', 'লাইসেন্স নম্বর', 'চালকলের ধরণ', 'চালের ধরন', 'পাক্ষিক ক্ষমতা', 'উপজেলা', 'জেলা','বিভাগ'],
                [' ', ' ', ' ', ' ', ' ', ' ', ' ']
            ];
        }

        if($this->exportdata == 2)
        {
            return
            [
                [' ', ' ', ' ', 'অঞ্চল অনুযায়ী চালকলের সমূহের তালিকা', ' ', ' ', ' '],
                [' ', ' ', ' ', ' ', ' ', ' ', ' '],
                ['চালকলের নাম', 'মালিকের নাম', 'মোবাইল', 'লাইসেন্স নম্বর', 'চালকলের ধরণ', 'চালের ধরন','পাক্ষিক ক্ষমতা', 'উপজেলা', 'জেলা','বিভাগ'],
                [' ', ' ', ' ', ' ', ' ', ' ', ' ']
            ];
        }

        if($this->exportdata == 3)
        {
            return
            [
                [' ', ' ', ' ', 'চালকলের ধরণ অনুযায়ী চালকলের সমূহের তালিকা', ' ', ' ', ' '],
                [' ', ' ', ' ', ' ', ' ', ' ', ' '],
                ['চালকলের নাম', 'মালিকের নাম', 'মোবাইল', 'লাইসেন্স নম্বর', 'চালকলের ধরণ', 'চালের ধরন','পাক্ষিক ক্ষমতা', 'উপজেলা', 'জেলা','বিভাগ'],
                [' ', ' ', ' ', ' ', ' ', ' ', ' ']
            ];
        }

        if($this->exportdata == 4)
        {
            return
            [
                [' ', ' ', ' ', 'পাস কোডের তালিকা', ' ', ' ', ' '],
                [' ', ' ', ' ', ' ', ' ', ' ', ' '],
                ['মোবাইল', 'পাস কোড', 'চালকলের নাম', 'মালিকের নাম', 'চালকলের ধরণ', 'চালের ধরন', 'উপজেলা', 'জেলা','বিভাগ'],
                [' ', ' ', ' ', ' ', ' ', ' ', ' ']
            ];
        }
    }

    public function startCell(): string
    {
        return 'A1';
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
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(16);

                $cellRange = 'A3:W3'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);

                $cellRange = "A1:W1";
                $event->sheet->getDelegate()->getStyle( $cellRange )->getFont()->setBold( true );

                $cellRange = "A3:W3";
                $event->sheet->getDelegate()->getStyle( $cellRange )->getFont()->setBold( true );
            },

        ];
    }

    public function array():array
    {
        return $this->millers;
    }
}
