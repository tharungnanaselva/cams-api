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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->cascadeOnDelete();
            $table->string('room_number');
            $table->enum('room_type', [
                'single',
                'double',
                'triple',
                'four'
            ]);
            $table->unsignedTinyInteger('capacity');
            $table->enum('gender_restriction', [
                'male',
                'female',
                'mixed'
            ]);
            $table->enum('status', [
                'available',
                'occupied',
                'reserved',
                'blocked',
                'maintenance'
            ])->default('available');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['building_id','room_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
