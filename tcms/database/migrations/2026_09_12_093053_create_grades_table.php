<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->decimal('marks_obtained', 5, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'exam_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
