<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_dailytask', function (Blueprint $table) {
            $table->id('dailytask_id');
            $table->integer('user_id');
            $table->integer('immediate_hid');
            $table->string('site');
            $table->timestamp('taskdate');
            $table->integer('tasktype');
            $table->timestamp('plandate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('planenddate')->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->string('project')->nullable();
            $table->timestamp('startdate')->nullable();
            $table->timestamp('enddate')->nullable();
            $table->string('status')->nullable();
            $table->integer('attachment')->default(0)->nullable();
            $table->string('PWS')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('status_task')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
