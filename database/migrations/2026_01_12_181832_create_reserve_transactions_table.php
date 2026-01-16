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
        Schema::create('reserve_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_section')->constrained('sections')->onDelete('cascade');
            $table->string('transaction');
            $table->decimal('value', 10, 2);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserve_transactions');
    }
};
