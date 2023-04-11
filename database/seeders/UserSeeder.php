<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([

            'full_name'=>'Daniel Maquera',
            'email'=>'danielsan15@gmail.com',
            'password'=>Hash::make('12345678'),

        ])->assignRole('Administrador');
        User::create([

            'full_name'=>'Oliver Maquera',
            'email'=>'oliversan15@gmail.com',
            'password'=>Hash::make('12345678'),
        ])->assignRole('Author');

        User::factory(10)->create();
    }
}
