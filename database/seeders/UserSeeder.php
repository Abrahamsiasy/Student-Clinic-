<?php

namespace Database\Seeders;

use App\Constants;
use App\Models\Room;
use App\Models\User;
use App\Models\Clinic;
use App\Models\ClinicUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // DB::table('users')->delete();

        // Role::findOrCreate('super-admin');
        // Role::findOrCreate('doctor');
        // Role::findOrCreate('lab_technician');
        // Role::findOrCreate('reception');
        // Role::findOrCreate('PHARMACY_USER');
        // Role::findOrCreate('nurse');
        // Role::findOrCreate('clinic-head');
        // Role::findOrCreate('SORE_USER');

        // // Role::updateOrCreate(['name' => Constants::PHARMACY_USER]);
        // // Role::updateOrCreate(['name' => Constants::STORE_USER_ROLE]);


        // $user = User::where('username', 'admin')->first();
        // if ($user == null){
        //     if (User::count() == 0) {
        //         $user = User::updateOrCreate(
        //             [
        //                 'username' =>'admin', // Search criteria for username
        //                 'email' => 'super@hrm.com', // Search criteria for email
        //             ],
        //             [
        //                 'name' => 'Super Admin',
        //                 'password' => Hash::make('password'),
        //             ]
        //         );
        //         if ($user !== null) {
        //         $user->assignRole(Constants::USER_TYPE_SUPER_ADMIN);
            
        //           }

        //     }
        // }    

        // DB::table('clinic')->delete();

        // $clinics = [
        //     ['id' => 1, 'name' => 'Main-Clinic', 'description' => 'Main Campus'],
        //     ['id' => 2, 'name' => 'JiT-Clinic', 'description' => 'JiT'],
        //     ['id' => 3, 'name' => 'Agri-Clinic', 'description' => 'GAVM-Agri'],

        // ];

        // Clinic::insert($clinics);


    }
}







