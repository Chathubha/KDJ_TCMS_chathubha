<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('section', 10);
            $table->integer('capacity')->default(40);
            $table->string('academic_year', 10);
            $table->unsignedBigInteger('class_teacher_id')->nullable();
            $table->timestamps();

            $table->unique(['name', 'section', 'academic_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
