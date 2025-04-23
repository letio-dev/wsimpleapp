<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ActivitiesReportExport;
use Maatwebsite\Excel\Facades\Excel;

class DownloadDataController extends Controller
{
    public function index()
    {
        return view('downloadData.index');
    }

    public function download(Request $request) // POST method
    {
        $request->validate([
            'year' => 'required|string', // string length 4 - YYYY
            'month' => 'required|string', // 01 - 12
        ]);

        $year = $request->year;
        $month = $request->month;
        $timezone = session('user_timezone', env('APP_TIMEZONE'));

        $filename = "Laporan_";
        if ($month === '00') {
            $filename .= "{$year}.xlsx";
        } else {
            $monthName = \Carbon\Carbon::createFromDate(null, $month, 1)->format('M');
            $filename .= "{$year}{$monthName}.xlsx";
        }

        return Excel::download(
            new ActivitiesReportExport($year, $month, $timezone),
            $filename
        );

    }

    function streamActivities($year, $month, $timezone)
    {
        $results = DB::select("SELECT * FROM ViewActivitiesReport(?, ?, ?)", [
            $year,
            $month,
            $timezone
        ]);

        foreach ($results as $row) {
            yield $row;
        }
    }
}
