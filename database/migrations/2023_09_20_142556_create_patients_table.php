<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('medical_number', 10)->unique();
            $table->string('name');
            $table->string('phone_number');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('identity_number')->unique();
            $table->string('identity_type');
            $table->text('address');
            $table->string('gender');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
