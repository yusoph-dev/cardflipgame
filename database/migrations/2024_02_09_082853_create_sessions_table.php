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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('laravel_session')->nullable();
            
            $table->boolean('initial')->nullable();
            $table->bigInteger('count')->default(0);
            $table->boolean('active')->comment('active card')->default(false);
            $table->smallInteger('difficulty')->nullable();
            $table->json('cards')->nullable();
            $table->json('random_cards')->nullable();
            $table->smallInteger('matched_cards')->nullable();
            $table->json('first_card')->nullable();
            $table->boolean('verifying')->default(false);
            $table->string('player_name')->nullable();
            $table->bigInteger('timer_seconds')->nullable();
            $table->bigInteger('total_score')->nullable();
            $table->smallInteger('timer_interval')->nullable();
            $table->boolean('show_modal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
