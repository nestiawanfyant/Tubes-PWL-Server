<?php

namespace App\Http\Controllers;

use App\Models\KomentarKelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KomentarKelasController extends Controller
{
    public function store(Request $request)
    {
        if ($request->has('komentar')) {
            KomentarKelas::create(
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
        if (!KomentarKelas::where('post_id', $request->post)->where('user_id', $request->user)->exists()) {
            return response()->json(false, 201);
        }

        KomentarKelas::where('id', $request->id)->delete();

        return response()->json(true, 201);
    }
}
