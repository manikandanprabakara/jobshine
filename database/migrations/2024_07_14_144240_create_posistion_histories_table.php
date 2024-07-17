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
        Schema::create('posistion_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employment_history_id')->constrained()->onDelete('cascade');
            $table->string('position_type')->nullable();
            $table->string('title')->nullable();
            $table->string('organization_name')->nullable();
            $table->text('description')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posistion_histories');
    }
};
