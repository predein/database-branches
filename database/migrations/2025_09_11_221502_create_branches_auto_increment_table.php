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
        Schema::create('branches_auto_increment', function (Blueprint $table) {
            $table->id();
            $table->string('table_name', 255);
            $table->unsignedBigInteger('auto_increment');
            $table->timestamps();

            $table->unique('table_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches_auto_increment');
    }
};
