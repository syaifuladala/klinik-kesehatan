<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function medicalReports()
    {
        return $this->hasMany(MedicalReport::class)->orderByDesc('date');
    }
}
