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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');    // name of the student making the payment
            $table->string('course');       // e.g., DHRT, BSIS
            $table->string('year_level')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('description');  // e.g., "Tuition Fee", "Miscellaneous Fee"
            $table->string('recorded_by');  // e.g., admin name or user ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
