<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = Str::random(60);

                User::where('id', $user->id)->update(
                    [
                        'remember_token' => $token
                    ]
                );

                $user = User::find($user->id);

                return response()->json(['error' => null, 'user' => $user]);
            }

            return response()->json(['error' => 'Password salah', 'user' => null]);
        }

        return response()->json(['error' => 'Akun tidak terdaftar', 'user' => null]);
    }


    public function logout(Request $request)
    {
        User::where('id', $request->id)->update(
            [
                'remember_token' => null
            ]
        );

        return response()->json(true);
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama'                  => ['required'],
                'email'                 => ['required', 'unique:users,email'],
                'password'              => ['required', 'confirmed'],
                'password_confirmation' => ['required'],
                'foto'                  => ['image', 'required']
            ],
            [
                'required'              => 'Mohon masukkan field :attribute',
                'email.unique'          => 'Email telah digunakan',
                'password.confirmed'    => 'Password tidak sesuai',
                'image'                 => 'Masukkan file bertipe gambar'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        DB::transaction(function () use ($request) {
            $user = User::create(
                [
                    'nama'      => $request->nama,
                    'email'     => $request->email,
                    'password'  => Hash::make($request->password),
                    'foto'      => $request->file('foto')->move(Str::slug($request->nama, '-') . '/foto', $request->file('foto')->getClientOriginalName())
                ]
            );

            User::where('id', $user->id)
                ->update(
                    [
                        'foto'  => url($user->foto)
                    ]
                );
        });


        return response()->json(['error' => null]);
    }
}
