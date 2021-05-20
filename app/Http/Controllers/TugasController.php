<?php

namespace App\Http\Controllers;

use App\Models\KomentarTugas;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TugasController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama'          => ['required'],
                'deskripsi'     => ['required'],
                'file'          => ['mimes:pdf,doc,docx,zip,png,jpg,jpeg', 'max:2048', 'nullable'],
                'deadline'      => ['date_format:m-d-Y H:i']
            ],
            [
                'required'      => 'Mohon isi field :attribute',
                'file.mimes'    => 'Masukkan file dengan format .zip, .doc, .docx, .pdf, .png, .jpg, atau .jpeg',
                'file.max'      => 'Maksimal file berukuran 2048 KB',
                'deadline.date_format' => 'Masukkan tanggal dan waktu yang sesuai'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $tugas = Tugas::create(
            [
                'kelas_id'  => $request->kelas_id,
                'user_id'   => $request->id,
                'nama'      => $request->nama,
                'deskripsi' => $request->deskripsi,
                'deadline'  => $request->deadline,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
            ]
        );

        if ($request->hasFile('file')) {
            Tugas::where('id', $tugas->id)
                ->update(
                    [
                        'file'  => $request->file('file')->storeAs($tugas->kelas_id . '/tugas' . '/' . Str::slug($tugas->nama), $request->file('file')->getClientOriginalName())
                    ]
                );
        }

        return response()->josn(['error' => null]);
    }

    public function show(Request $request)
    {
        $tugas = Tugas::with('user')->where('id', $request->id)->first();

        $komentar = KomentarTugas::with('user')->where('tugas_id', $tugas->id)->get();

        $response = array(
            'tugas'     => $tugas,
            'komentar'  => $komentar
        );

        return response()->json($response, 201);
    }

    public function update(Request $request)
    {
        if (!Tugas::where('id', $request->id)->where('user_id', $request->user)->exist()) {
            return response()->json(['error' => 'Unauthorized']);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'nama'          => ['required'],
                'deskripsi'     => ['required'],
                'file'          => ['mimes:pdf,doc,docx,zip,png,jpg,jpeg', 'max:2048', 'nullable'],
                'deadline'      => ['date_format:m-d-Y H:i']
            ],
            [
                'required'      => 'Mohon isi field :attribute',
                'file.mimes'    => 'Masukkan file dengan format .zip, .doc, .docx, .pdf, .png, .jpg, atau .jpeg',
                'file.max'      => 'Maksimal file berukuran 2048 KB',
                'deadline.date_format' => 'Masukkan tanggal dan waktu yang sesuai'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        Tugas::where('id', $request->id)
            ->update(
                [
                    'nama'          => $request->nama,
                    'deskripsi'     => $request->deskripsi,
                    'deadline'      => $request->deadline,
                    'updated_at'    => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
                ]
            );

        $tugas = Tugas::where('id', $request->id)->first();

        if ($request->hasFile('file')) {
            Tugas::where('id', $tugas->id)
                ->update(
                    [
                        'file'  => $request->file('file')->storeAs($tugas->kelas_id . '/tugas' . '/' . Str::slug($tugas->nama), $request->file('file')->getClientOriginalName())
                    ]
                );
        }

        return response()->json(['error' => null], 201);
    }

    public function destroy(Request $request)
    {
        if (!Tugas::where('id', $request->id)->where('user_id', $request->user)->exist()) {
            return response()->json(['error' => 'Unauthorized']);
        }

        Tugas::where('id', $request->id)->delete();

        return response()->json(['error' => null], 201);
    }
}
