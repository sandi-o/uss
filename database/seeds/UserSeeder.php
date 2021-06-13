<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();  
        DB::table('users')->insert([      
            [
                'name' => 'Sandi Cardinoza',
                'email' => 'sandi.cardinoza@gmail.com',
                'mobile_no' => '93766034',
                'password' => bcrypt('m1ddl300t'),
            ]
        ]);
    }
}
