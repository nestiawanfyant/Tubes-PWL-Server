<?php

namespace App\Http\Controllers;

use App\Models\KomentarMateri;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KomentarMateriController extends Controller
{
    public function store(Request $request)
    {
        KomentarMateri::create(
            [
                'komentar'  => $request->komentar,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
            ]
        );

        return response()->json(true, 200);
    }

    public function destroy(Request $request)
    {
        if (!KomentarMateri::where('materi_id', $request->post)->where('user_id', $request->user)->exists()) {
            return response()->json(false, 201);
        }

        KomentarMateri::where('id', $request->id)->delete();

        return response()->json(true, 201);
    }
}
