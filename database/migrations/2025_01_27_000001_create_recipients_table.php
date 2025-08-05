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
        Schema::create('recipients', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->unique();
            $table->string('child_name');
            $table->string('parent_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('school_level');
            $table->string('school_name');
            $table->text('address');
            $table->string('class');
            $table->string('shoe_size');
            $table->string('shirt_size');
            $table->boolean('uniform_received')->default(false);
            $table->boolean('shoes_received')->default(false);
            $table->boolean('bag_received')->default(false);
            $table->boolean('is_distributed')->default(false);
            $table->timestamp('distributed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipients');
    }
};