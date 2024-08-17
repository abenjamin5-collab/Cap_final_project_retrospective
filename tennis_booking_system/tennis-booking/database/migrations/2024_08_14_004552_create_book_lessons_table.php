<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_lessons', function (Blueprint $table) {
            $table->id();
            
            
            $table->foreignId('student_id')
                  ->constrained('users')
                  ->onDelete('cascade');

          
            $table->foreignId('coach_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            
            $table->date('booking_date');
            $table->time('booking_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_lessons');
    }
};
