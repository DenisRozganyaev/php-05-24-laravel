<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
// User::factory(5)->create() => Records will be created in DB
// User::factory(5)->make() => returns collection of 5 User objects
// User::factory(1, ['password' => 'test1234'])->create()
// User::factory(1, ['password' => 'test1234'])->unverified()->create()
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
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'birthdate' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'password' => Hash::make(static::$password ??='test1234'),
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            if (! $user->hasAnyRole(Role::values())) {
                $user->assignRole(Role::CUSTOMER->value);
            }
        });
    }

    public function admin(): static
    {
        return $this->state(
            fn (array $attrs) => ['email' => 'admin@admin.com']
        )->afterCreating(function (User $user) {
            $user->syncRoles(Role::ADMIN->value);
        });
    }

    public function moderator(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->syncRoles(Role::MODERATOR->value);
        });
    }

    public function withEmail(string $email): static
    {
        return $this->state(fn (array $attrs) => ['email' => $email]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
