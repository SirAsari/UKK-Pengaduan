<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SingleReportExport implements FromArray, WithHeadings
{
    protected $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Return the data for the specific report.
     */
    public function array(): array
    {
        return [
            [
                $this->report->id,
                $this->report->description,
                $this->report->type,
                $this->report->province,
                $this->report->regency,
                $this->report->subdistrict,
                $this->report->village,
                $this->report->voting,
                $this->report->viewers,
                $this->report->statement,
                $this->report->created_at,
            ],
        ];
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
            'Regency',
            'Subdistrict',
            'Village',
            'Voting',
            'Viewers',
            'Status',
            'Created At',
        ];
    }
}
