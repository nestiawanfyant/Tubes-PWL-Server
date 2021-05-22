<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'nama'  => 'Muhammad Ikhbal',
                'email' => 'ikhbal@ikhbal.com',
                'password'  => Hash::make('1'),
            ]
        );

        User::create(
            [
                'nama'  => 'Fikri Halim',
                'email' => 'fikri@fikri.com',
                'password'  => Hash::make('1'),
            ]
        );

        User::create(
            [
                'nama'  => 'Nestiawan Ferdiyanto',
                'email' => 'nesti@nesti.com',
                'password'  => Hash::make('1'),
            ]
        );

        User::create(
            [
                'nama'  => 'Nazla',
                'email' => 'nazla@nazla.com',
                'password'  => Hash::make('1'),
            ]
        );
    }
}
