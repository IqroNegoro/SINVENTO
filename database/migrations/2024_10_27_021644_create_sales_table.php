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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string("customer_id")->nullable()->constrained("customers")->references("code")->on("customers");
            $table->foreignId("voucher_id")->nullable()->constrained("vouchers")->references("id")->on("vouchers");
            $table->integer("subtotal");
            $table->integer("total");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
