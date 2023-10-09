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
            $table->string('techno',50);
            $table->string('company',50);
            $table->string('branch',50);
            $table->string('department',50);
            $table->string('warehouse',50);
            $table->string('user',50);
            $table->text('report');
            $table->text('udetails')->nullable();
            $table->text('ass_conducted');
            $table->text('recommendation');
            $table->integer('created_by');
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
