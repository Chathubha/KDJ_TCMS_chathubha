<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->string('academic_year', 10);
            $table->enum('type', ['tuition', 'exam', 'lab', 'transport', 'library', 'other'])->default('tuition');
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
