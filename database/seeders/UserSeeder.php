<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Creates the administrator from config/admin.php when it is missing.
     * Safe to run again: an existing account keeps its password and profile,
     * and only gains the admin flag.
     */
    public function run(): void
    {
        $email = (string) config('admin.email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->forceFill(['is_admin' => true])->save();
            $this->command?->info("Admin rights granted to {$email}.");

            return;
        }

        User::create([
            'name' => config('admin.name'),
            'email' => $email,
            'password' => Hash::make((string) config('admin.password')),
            'slug' => config('admin.slug'),
        ])->forceFill([
            'website_template' => config('admin.template'),
            'status' => 1,
            'is_admin' => true,
        ])->save();

        $this->command?->info("Administrator {$email} created - change the password after signing in.");
    }
}
