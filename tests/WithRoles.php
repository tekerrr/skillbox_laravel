<?php


namespace Tests;


trait WithRoles
{
    private function createUser() : \App\User
    {
        return factory(\App\User::class)->create();
    }

    private function createAdmin() : \App\User
    {
        return factory(\App\User::class)->create()->addRole('admin');
    }

    private function createSuperAdmin() : \App\User
    {
        return factory(\App\User::class)->create()->addRole('super_admin');
    }

    private function actingAsUser() : \App\User
    {
        $this->actingAs($user = $this->createUser());

        return $user;
    }

    private function actingAsAdmin() : \App\User
    {
        $this->actingAs($admin = $this->createAdmin());

        return $admin;
    }
}
