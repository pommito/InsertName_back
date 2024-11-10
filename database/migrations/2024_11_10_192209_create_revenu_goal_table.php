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
        Schema::create('revenue_goal', function (Blueprint $table) {
            $table->id('id_goal');
            $table->unsignedBigInteger('id_user');
            $table->integer('year');
            $table->integer('month');
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('id_user')->references('id')->on('users');
            $table->unique(['id_user', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_goal');
    }
};
