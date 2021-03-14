<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportUserList implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::OrderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone No',
            'Email',
            'Sex',
            'Is Active',
            'Created On'
        ];
    }

    public function map($user) : array {

        return [
            ucfirst($user->name),
            $user->phone_no,
            $user->email,
            ucfirst($user->sex),
            $user->isActiveUser() ? 'Active' : 'In Active',
            $user->created_at
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:Z1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(11);
            },
        ];
    }
}
