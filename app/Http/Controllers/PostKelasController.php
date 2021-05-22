<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostKelasController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'text'  => ['required']
            ],
            [
                'required'  => 'Mohon isi field :attribute',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        Post::create(
            [
                'kelas_id'  => $request->kelas_id,
                'user_id'   => $request->user,
                'text'      => $request->text,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
            ]
        );

        return response()->json(['error' => null]);
    }

    public function update(Request $request)
    {
        if (!Post::where('id', $request->id)->where('user_id', $request->user)->exist()) {
            return response()->json(['error' => 'Unauthorized']);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'text'  => ['required']
            ],
            [
                'required'  => 'Mohon isi field :attribute',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        Post::where('id', $request->id)
            ->update(
                [
                    'text'      => $request->text,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString()
                ]
            );

        return response()->json(['error' => null]);
    }

    public function destroy(Request $request)
    {
        if (!Post::where('id', $request->id)->where('user_id', $request->user)->exist()) {
            return response()->json(['error' => 'Unauthorized']);
        }

        Post::where('id', $request->id)->delete();

        return response()->json(['error' => null]);
    }
}
