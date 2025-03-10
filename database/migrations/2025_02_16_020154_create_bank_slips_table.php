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
        Schema::create('bank_slips', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->bigInteger("amount");
            $table->string("code");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_slips');
    }
};
