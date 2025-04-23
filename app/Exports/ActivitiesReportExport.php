<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ActivitiesReportExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting, WithTitle, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $year, $month, $timezone;

    public function __construct($year, $month, $timezone)
    {
        $this->year = $year;
        $this->month = $month;
        $this->timezone = $timezone;
    }

    public function title(): string
    {
        $monthName = Carbon::createFromDate(null, $this->month, 1)->format('M');
        return "{$monthName}-{$this->year}"; // Contoh: Apr-2025
    }

    public function query()
    {
        return DB::table(DB::raw("(SELECT * FROM ViewActivitiesReport('$this->year', '$this->month', '$this->timezone')) AS report"))
            ->orderBy('created_at');
    }

    public function headings(): array
    {
        return [
            'No. Resi',
            'Ekspedisi',
            'Nama Penerima',
            'Tower',
            'Lantai',
            'Unit',
            'No. Telepon',
            'Catatan',
            'Petugas Input',
            'Petugas Output',
            'Status',
            'Tgl Masuk',
            'Tgl Keluar',
            'Tgl Terakhir Update',
        ];
    }

    public function map($row): array
    {
        return [
            (string) $row->tracking_number,
            (string) $row->courier_service,
            (string) $row->recipient_name,
            (string) $row->tower,
            (string) $row->floor,
            (string) $row->unit,
            (string) $row->recipient_phone,
            (string) $row->notes,
            (string) $row->user_checkin,
            (string) $row->user_checkout,
            $this->mapStatus($row->status), // status mapping
            (string) $row->created_at,
            (string) $row->checkout_at,
            (string) $row->updated_at,
        ];
    }

    protected function mapStatus($value): string
    {
        return match ((int) $value) {
            1 => 'Masuk',
            2 => 'Keluar',
            default => '', // fallback
        };
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            'K' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
            'N' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Baris ke-1 = header
        ];
    }
}
