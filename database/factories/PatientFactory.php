<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $identityType = ['sim', 'ktp', 'paspor'];
        $gender = ['laki-laki', 'perempuan'];
        $type = ['konsultasi', 'skhpn'];
        $createdAt = fake()->dateTimeBetween('-2 years', 'now');
        return [
            'medical_number' => 'RM' . Carbon::parse($createdAt)->format('my') . $this->generateUniqueFourDigitNumber(),
            'name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date('Y-m-d', '17 years ago'),
            'identity_number' => fake()->unique()->nik(),
            'identity_type' => $identityType[array_rand($identityType)],
            'address' => fake()->address(),
            'gender' => $gender[array_rand($gender)],
            'type' => $type[array_rand($type)],
            'created_at' => $createdAt,
        ];
    }

    private function generateUniqueFourDigitNumber()
    {
        $number = fake()->unique()->numberBetween(1, 200);
        return str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
