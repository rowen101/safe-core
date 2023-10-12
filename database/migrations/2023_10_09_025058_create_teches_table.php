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
        Schema::create('teches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('techno',50)->nullable();
            $table->string('company',50)->nullable();
            $table->string('branch',50)->nullable();
            $table->string('department',50)->nullable();
            $table->string('warehouse',50)->nullable();
            $table->string('user',50)->nullable();
            $table->text('report')->nullable();
            $table->text('udetails')->nullable();
            $table->text('ass_conducted')->nullable();
            $table->text('recommendation')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teches');
    }
};
