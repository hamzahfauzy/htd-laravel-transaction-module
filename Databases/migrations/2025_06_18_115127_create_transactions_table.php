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
        Schema::create('trx_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('description');
            $table->decimal('debt', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            
            $table->unsignedBigInteger('cash_id')->nullable();
            $table->foreign('cash_id')->references('id')->on('trx_cash')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_transactions');
    }
};
