<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewDataController extends Controller
{
    public function index()
    {
        return view('viewData.index');
    }

    public function viewData(Request $request)
    {
        $tower = $request->tower;
        $unit = $request->unit;
        $timezone = session('user_timezone', env('APP_TIMEZONE'));

        $activities = DB::select("SELECT * FROM ViewActivity(?, ?, ?)", [
            $tower,
            $unit,
            $timezone
        ]);

        return response()->json($activities);
    }

    public function acceptActivity(Request $request)
    {
        $activity_sf_id = $request->id;
        $timezone = session('user_timezone', env('APP_TIMEZONE'));
        $user_id = auth()->id();

        try {
            // Update status activity and get the result
            $result = DB::selectOne("SELECT * FROM AcceptActivity(?, ?, ?)", [
                $activity_sf_id,
                $user_id,
                $timezone
            ]);

            if (!$result) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            return response()->json(['message' => 'Status berhasil diubah', 'success' => true, 'result' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengubah status', 'error' => $e->getMessage()], 500);
        }
    }

    public function editActivity(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $activity_sf_id = $request->id;
        $updateChanges = $payload['c'];
        $user_id = auth()->id();

        try {
            DB::statement("SELECT EditActivity(?, ?, ?)", [
                $activity_sf_id,
                $user_id,
                json_encode($updateChanges)
            ]);

            $timezone = session('user_timezone', env('APP_TIMEZONE'));
            $result = [
                'updated_at' => (new \DateTime('now', new \DateTimeZone($timezone)))->format('Y-m-d H:i:s')
            ];

            return response()->json(['message' => 'Data berhasil diubah', 'success' => true, 'result' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengubah data', 'error' => $e->getMessage()], 500);
        }
    }
}
