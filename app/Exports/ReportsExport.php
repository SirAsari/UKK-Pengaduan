<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    /**
     * Return the collection of reports.
     */
    public function collection()
    {
        return Report::select('id', 'description', 'type', 'province', 'statement', 'created_at')->get();
    }

    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Description',
            'Type',
            'Province',
            'Status',
            'Created At',
        ];
    }
}
