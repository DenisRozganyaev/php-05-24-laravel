<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        if (! User::role(Role::ADMIN->value)->exists()) {
            User::factory()->admin()->create();
        }

        User::factory(2)->moderator()->create();
        User::factory(10)->create();
    }
}
