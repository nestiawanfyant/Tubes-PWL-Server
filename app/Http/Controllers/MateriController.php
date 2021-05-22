<?php

namespace App\Http\Controllers;

use App\Models\KomentarMateri;
use App\Models\Materi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama'          => ['required'],
                'deskripsi'     => ['required'],
                'file'          => ['mimes:pdf,doc,docx,zip,png,jpg,jpeg', 'max:2048', 'nullable']
            ],
            [
                'required'      => 'Mohon isi field :attribute',
                'file.mimes'    => 'Masukkan file dengan format .zip, .doc, .docx, .pdf, .png, .jpg, atau .jpeg',
                'file.max'      => 'Maksimal file berukuran 2048 KB'
            ]
        );

        if ($validator->fails()) {
            return response()->josn(['error' => $validator->errors()]);
        }

        $materi = Materi::create(
            [
                'kelas_id'  => $request->kelas_id,
                'user_id'   => $request->id,
                'nama'      => $request->nama,
                'deskripsi' => $request->deskripsi,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
            ]
        );

        if ($request->hasFile('file')) {
            Materi::where('id', $materi->id)
                ->update(
                    [
                        'file'  => $request->file('file')->storeAs($materi->kelas_id . '/materi' . '/' . Str::slug($materi->nama), $request->file('file')->getClientOriginalName())
                    ]
                );
        }

        return response()->josn(['error' => null]);
    }

    public function show(Request $request)
    {
        $materi = Materi::with('user')->where('id', $request->id)->first();

        $komentar = KomentarMateri::with('user')->where('materi_id', $materi->id)->get();

        $response = array(
            'materi'    => $materi,
            'komentar'  => $komentar
        );

        return response()->json($response, 201);
    }

    public function update(Request $request)
    {
        if (!Materi::where('id', $request->id)->where('user_id', $request->user)->exist()) {
            return response()->json(['error' => 'Unauthorized']);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'nama'          => ['required'],
                'deskripsi'     => ['required'],
                'file'          => ['mimes:pdf,doc,docx,zip,png,jpg,jpeg', 'max:2048', 'nullable']
            ],
            [
                'required'      => 'Mohon isi field :attribute',
                'file.mimes'    => 'Masukkan file dengan format .zip, .doc, .docx, .pdf, .png, .jpg, atau .jpeg',
                'file.max'      => 'Maksimal file berukuran 2048 KB'
            ]
        );

        if ($validator->fails()) {
            return response()->josn(['error' => $validator->errors()]);
        }

        Materi::where('id', $request->id)
            ->update(
                [
                    'nama'          => $request->nama,
                    'deskripsi'     => $request->deskripsi,
                    'updated_at'    => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
                ]
            );

        $materi = Materi::where('id', $request->id)->first();

        if ($request->hasFile('file')) {
            Materi::where('id', $request->id)
                ->update(
                    [
                        'file'  => $request->file('file')->storeAs($materi->kelas_id . '/materi' . '/' . Str::slug($materi->nama), $request->file('file')->getClientOriginalName())
                    ]
                );
        }
    }

    public function destroy(Request $request)
    {
        if (!Materi::where('id', $request->id)->where('user_id', $request->user)->exist()) {
            return response()->json(['error' => 'Unauthorized']);
        }

        Materi::where('id', $request->id)->delete();

        return response()->json(true, 201);
    }
}
