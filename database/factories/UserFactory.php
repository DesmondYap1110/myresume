<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The administrator from config/admin.php. Same account the first
     * migration creates, so seeding and migrating agree.
     */
    public function definition(): array
    {
        return [
            'name' => config('admin.name'),
            'email' => config('admin.email'),
            'password' => bcrypt((string) config('admin.password')),
            'slug' => config('admin.slug'),
            'website_template' => config('admin.template'),
            'status' => 1,
            'is_admin' => true,
        ];
    }

    /** A second, ordinary portfolio owner - not an administrator. */
    public function member(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'slug' => Str::slug($this->faker->unique()->userName()),
            'is_admin' => false,
        ]);
    }
}
