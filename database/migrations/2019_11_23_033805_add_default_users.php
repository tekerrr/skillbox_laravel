<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\User::create([
            'name'     => 'Super Admin',
            'email'    => config('admin.super.email'),
            'password' => Hash::make(config('admin.super.password')),
        ])->addRole('super_admin');

        \App\User::create([
            'name'     => 'Admin',
            'email'    => config('admin.email'),
            'password' => Hash::make(config('admin.password')),
        ])->addRole('admin');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
