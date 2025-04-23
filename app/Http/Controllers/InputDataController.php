<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use thiagoalessio\TesseractOCR\TesseractOCR;

class InputDataController extends Controller
{
    public function index()
    {
        return view('inputData.index');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tracking_number'   => 'required|string',
            'courier_service'   => 'nullable|string',
            'recipient_name'    => 'required|string',
            'tower'             => 'required|string',
            'floor'             => 'nullable|string',
            'unit'              => 'required|string',
            'recipient_phone'   => 'nullable|string',
            'notes'             => 'nullable|string',
        ]);

        $user_id = auth()->id();

        try {
            DB::statement("SELECT InsertActivity(?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $request->tracking_number,
                $request->courier_service,
                $request->recipient_name,
                $request->tower,
                $request->floor,
                $request->unit,
                $request->recipient_phone,
                $request->notes,
                $user_id
            ]);

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data', 'error' => $e->getMessage()], 500);
        }
    }

    public function inputDataOCR(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'Tidak ada file'], 400);
        }

        $file = $request->file('image');
        $path = $file->storeAs('temp', uniqid() . '.' . $file->getClientOriginalExtension());

        $fullPath = storage_path('app/' . $path);

        try {
            $text = (new TesseractOCR($fullPath))
                ->executable('X:\Apps\Tesseract-OCR\tesseract.exe')
                ->lang('eng', 'ind')
                ->run();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'OCR gagal: ' . $e->getMessage()], 500);
        }

        @unlink($fullPath);

        return response()->json(['text' => trim($text)]);
    }
}
