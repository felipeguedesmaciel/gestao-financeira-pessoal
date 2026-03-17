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
        Schema::create('due_date_debts', function (Blueprint $table) {
            $table->id(); // Chave primária 'id'
            $table->unsignedBigInteger('id_debts'); // Chave estrangeira para 'debts'
            $table->date('date')->nullable(); // Data de vencimento
            $table->enum('status', ['À pagar', 'Pago', 'Atrasado'])->nullable(); // Situação da dívida
            $table->timestamps(); // Adiciona 'created_at' e 'updated_at' (opcional, mas comum em Laravel)

            // Define a chave estrangeira
            $table->foreign('id_debts')->references('id')->on('debts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('due_date_debts');
    }
};
