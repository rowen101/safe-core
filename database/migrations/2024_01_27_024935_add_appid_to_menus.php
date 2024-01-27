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
        Schema::create('app', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_code', 20); // application code
            $table->string('app_name', 150); // name of the application
            $table->text('description'); //Describe the product
            $table->string('app_icon', 150)->nullable(); //application icon
            $table->boolean('is_active')->default(true)->nullable(); //ACTIVE,INACTIVE,MAINTENANCE
            $table->string('status_message',150)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

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
        Schema::dropIfExists('app');
        Schema::dropIfExists('menus');
    }
};
