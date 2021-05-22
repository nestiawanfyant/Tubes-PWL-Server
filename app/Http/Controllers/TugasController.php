<?php

namespace App\Http\Controllers;

use App\Models\KomentarTugas;
use App\Models\RoleKelas;
use App\Models\Submission;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        DB::transaction(function () use ($request) {
            $tugas = Tugas::create(
                [
                    'kelas_id'  => $request->kelas_id,
                    'user_id'   => $request->id,
                    'nama'      => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'deadline'  => Carbon::createFromFormat('m-d-Y H:i', $request->deadline)->subHours(7)->format('Y-m-d H:i:s'),
                    'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
                ]
            );

            $roles = RoleKelas::where('kelas_id', $tugas->kelas_id)->where('role', 3)->get();

            if ($roles) {
                foreach ($roles as $role) {
                    Submission::create(
                        [
                            'tugas_kelas_id' => $tugas->id,
                            'user_id'        => $role->user_id
                        ]
                    );
                }
            }

            if ($request->hasFile('file')) {
                Tugas::where('id', $tugas->id)
                    ->update(
                        [
                            'file'  => $request->file('file')->storeAs($tugas->kelas_id . '/tugas' . '/' . Str::slug($tugas->nama), $request->file('file')->getClientOriginalName())
                        ]
                    );
            }
        });


        return response()->json(['error' => null]);
    }

    public function show(Request $request)
    {
        $tugas = Tugas::with('user')->where('id', $request->id)->first();

        $submission = Submission::where('tugas_kelas_id', $tugas->id)->where('user_id', $request->user)->first();

        $komentar = KomentarTugas::with('user')->where('tugas_id', $tugas->id)->get();

        $response = array(
            'tugas'     => $tugas,
            'komentar'  => $komentar,
            'submission' => $submission
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
                    'deadline'  => Carbon::createFromFormat('m-d-Y H:i', $request->deadline)->subHours(7)->format('Y-m-d H:i:s'),
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
