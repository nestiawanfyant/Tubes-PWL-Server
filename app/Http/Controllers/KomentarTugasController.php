<?php

namespace App\Http\Controllers;

use App\Models\KomentarTugas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KomentarTugasController extends Controller
{
    public function store(Request $request)
    {
        if ($request->has('komentar')) {
            KomentarTugas::create(
                [
                    'komentar'  => $request->komentar,
                    'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
                ]
            );
        }

        return response()->json(true, 200);
    }

    public function destroy(Request $request)
    {
        if (!KomentarTugas::where('tugas_id', $request->post)->where('user_id', $request->user)->exists()) {
            return response()->json(false, 201);
        }

        KomentarTugas::where('id', $request->id)->delete();

        return response()->json(true, 201);
    }
}
