<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => "Adrian Khor Chee Seng",

            'email' => "adrian.kcs@gmail.com",

            'password' =>  bcrypt('123456'),

            'image' => fake()->imageUrl(200, 200, 'people'),

            'dob' => "1989-03-24",

            'phone' => "+60 18-202 8986",

            'role' => "SAP Project Manager",

            'address' => "Petaling Jaya, Selangor",

            'linkedIn_url' => "https://www.linkedin.com/in/chee-seng-k-81a0197a/",

            'about' => "At EY, my focus lies in delivering innovative consulting solutions, leveraging my CPA certification and proficiency in Finance, Accounting and Product Analytics. My tenure at Alliance Bank Malaysia Berhad honed my strategic and financial acumen, particularly in group strategy and business finance. My successful transition from AmBank Group, where I specialized in forecast, budgeting, and analysis, underscores my adaptability and growth in the dynamic financial sector.
                        Collaboration and the pursuit of excellence define my professional journey. Within EY's collaborative culture, I apply SAP S/4HANA expertise to enhance our consulting services. This journey, marked by a notable achievement as EY Intra Games Volleyball Champion, exemplifies my commitment to team spirit and high performance. Fluent in English, Malay, and Mandarin (speak), I navigate diverse business landscapes to foster connections and drive progress.",

            'remember_token' => Str::random(10),

            'status' => 1
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [

        ]);
    }
}
