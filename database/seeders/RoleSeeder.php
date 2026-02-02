<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = ['ADMIN', 'CAISSE', 'CUISINE', 'SERVEUR'];

        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        // Assigner ADMIN au user id=1 si présent
        $admin = User::find(1);
        if ($admin) {
            $adminRole = Role::where('name', 'ADMIN')->first();
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}
