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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('purchased_currency');
            $table->float('purchased_amount', 20, 2);
            $table->float('paid_amount_usd', 20, 2);
            $table->float('rate', 16, 6);
            $table->string('surcharge_percent', 5, 2);
            $table->string('surcharge_amount', 20, 2);
            $table->string('discount_percent', 5, 2);
            $table->string('discount_amount', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
