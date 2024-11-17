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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string("code", 50);
            $table->string("name", 100);
            $table->string("description")->nullable();
            $table->enum("value_type", ["fixed", "percentage"])->default("percentage");
            $table->enum("type", ["item", "cart"])->nullable();
            $table->integer("value")->default(0);
            $table->date("valid_from")->useCurrent();
            $table->date("valid_to");
            $table->integer("stock")->nullable();
            $table->boolean("active")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
