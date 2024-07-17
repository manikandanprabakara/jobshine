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
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_id')->constrained()->onDelete('cascade');
            $table->string('employer_org_name')->nullable();
            $table->string('title')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('company')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->text('description')->nullable();
            $table->text('leaving_reason')->nullable();
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
        Schema::dropIfExists('employment_histories');
    }
};
