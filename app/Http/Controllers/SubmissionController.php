<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $submission = Submission::where('tugas_kelas_id', $request->tugas_id)->latest()->get();

        return response()->json($submission, 201);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file'          => ['mimes:pdf,doc,docx,zip,png,jpg,jpeg', 'max:2048', 'required_without:komentar'],
                'komentar'      => ['required_without:file']
            ],
            [
                'file.mimes'           => 'Masukkan file dengan format .zip, .doc, .docx, .pdf, .png, .jpg, atau .jpeg',
                'file.max'             => 'Maksimal file berukuran 2048 KB',
                'required_without'     => 'Upload file atau komentar'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $submission = Submission::create(
            [
                'tugas_kelas_id'    => $request->tugas_id,
                'user_id'           => $request->user
            ]
        );

        if ($request->hasFile('file')) {
            Submission::where('id', $submission->id)
                ->update(
                    [
                        'file'  => $request->file('file')->storeAs($submission->tugas_kelas_id . '/' . $submission->user_id, $request->file('file')->getClientOriginalName())
                    ]
                );
        }

        if (!is_null($request->komentar)) {
            Submission::where('id', $submission->id)
                ->update(
                    [
                        'komentar'  => $request->komentar
                    ]
                );
        }

        return response()->json(['error' => null]);
    }

    public function destroy(Request $request)
    {
        Submission::where('id', $request->submission)->delete();

        return response()->json(true, 200);
    }
}
