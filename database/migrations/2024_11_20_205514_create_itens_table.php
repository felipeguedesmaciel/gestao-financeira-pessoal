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
        Schema::create('itens', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id'); // agrupa as parcelas/unidades da mesma compra
            $table->string('category', 100);
            $table->text('description');
            $table->decimal('value', 10 ,2);
            $table->string('payment_method', 50);
            $table->dateTime('date');
            $table->dateTime('payment_date')->nullable();
            $table->string('status', 50);
            // Foreign Keys
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('condition_id')
                  ->unique()
                  ->constrained('payment_terms')
                  ->onDelete('cascade');

            $table->timestamps();

            // Índice para consultas por compra/recebimento
            $table->index('unit_id', 'idx_item_unit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens');
    }
};
