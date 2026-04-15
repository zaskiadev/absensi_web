<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
    protected static int $employeeCounter = 2; // Start from 2 since U0001 is reserved for admin    
    

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'jabatan' => fake()->randomElement(['GM', 'FBM', 'BanquetManager', 'BanquetCaptain', 'BanquetStaff', 'DWBanquet', 'RestaurantManager', 'FBCaptain', 'FBCashier', 'Waiter', 'Bartender', 'Server', 'AsstServer', 'DWFBStaff', 'TraineeFBS', 'SportActivityManager', 'SportActivitySPV', 'PoolAttendant', 'BeachAttendant', 'Secretary', 'PurchasingManager', 'PurchasingStaff', 'LOManager', 'SalesManager', 'LOOfficer', 'ExecutiveCheff', 'SousChef', 'ChiefSteward', 'Steward', 'DWSteward', 'CDP', 'CommisChef', 'DWKitchen', 'DemiPastrier', 'CommisPastrier', 'DwPastrier', 'DemiChef', 'KitchenAdmin', 'ChiefEngineering', 'Engineering', 'ExecutiveHousekeeper', 'HKSPV', 'HKStaff', 'PA', 'DWPA', 'DWMaintenanceAC', 'RA', 'GardenerSPV', 'Gardener', 'LaundrySPV', 'Laundry', ]),
            'employee_id' =>'U' . str_pad(static::$employeeCounter++, 4, '0', STR_PAD_LEFT),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
