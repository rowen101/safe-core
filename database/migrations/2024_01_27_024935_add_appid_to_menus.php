<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('menus', function (Blueprint $table) {
            $table->integer('app_id')->unsigned()->after('menu_id');
            $table->foreign('app_id')->references('id')->on('app');
            $table->string('menu_code', 20)->default('NONE')->after('app_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('menus');
    }
};
