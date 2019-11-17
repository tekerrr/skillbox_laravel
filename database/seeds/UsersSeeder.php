<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'name' => 'Alex Anufriev',
            'email' => 'tekerrr@gmail.com',
            'password' => Hash::make('asd'),
        ]);

        factory(\App\User::class, 5)->create();
    }
}
