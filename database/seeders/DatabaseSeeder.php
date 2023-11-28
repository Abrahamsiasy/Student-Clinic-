<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        // DB::table('users')->delete();
      
        // Campus::firstOrCreate([
        //     'name' => 'Main Campus'
        // ], [
        //     'name' => 'Main Campus'
        // ]);
        // Campus::firstOrCreate([
        //     'name' => 'Agri Campus'
        // ], [
        //     'name' => 'Agri Campus'
        // ]);
        // Campus::firstOrCreate([
        //     'name' => 'JIT Campus'
        // ], [
        //     'name' => 'JIT Campus'
        // ]);
        // Campus::firstOrCreate([
        //     'name' => 'Agaro Campus'
        // ], [
        //     'name' => 'Agaro Campus'
        // ]);
        // Campus::firstOrCreate([
        //     'name' => 'Beco Campus'
        // ], [
        //     'name' => 'Beco Campus'
        // ]);
        // $this->call(CampusSeeder::class);
        $this->call(PermissionsSeeder::class);
       // $this->call(UserSeeder::class);


    }
}
