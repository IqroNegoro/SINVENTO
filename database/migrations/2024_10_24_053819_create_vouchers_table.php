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
            $table->enum("type", ["fixed", "percentage"])->default("percentage");
            $table->integer("value")->default(0);
            $table->dateTime("valid_from")->useCurrent();
            $table->dateTime("valid_to")->nullable();
            $table->integer("stock")->nullable();
            $table->integer("used")->default(0);
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
