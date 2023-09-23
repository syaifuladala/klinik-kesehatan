<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalReport>
 */
class MedicalReportFactory extends Factory
{
    public function definition()
    {
        $patient = Patient::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        return [
            'patient_id' => $patient->id,
            'user_id' => $user->id,
            'date' => Carbon::parse(fake()->dateTimeBetween($patient->created_at, 'now'))->format('Y-m-d'),
            'note' => fake()->paragraph(2),
        ];
    }
}
