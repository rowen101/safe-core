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
            $table->string('site_email',20)->nullable();
            $table->string('site_phone',20)->nullable();
            $table->string('site_address',50)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('region');
            $table->string('site');
            $table->string('sitehead')->nullable();
            $table->string('location')->nullable();
            $table->text('image')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('geomap')->nullable();
            $table->boolean('is_active')->default(true)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('body');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->integer('created_by')->default(0);
            $table->boolean('is_publish')->default(false)->nullable();
            $table->boolean('is_active')->default(true)->nullable();
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('website')->nullable();
            $table->text('comment');
            $table->unsignedBigInteger('posts_id');
            $table->boolean('is_publish')->default(true)->nullable();
            $table->foreign('posts_id')->references('id')->on('posts')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->text('content');
            $table->timestamps();

            // Define foreign key constraint for the comment_id column
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->onDelete('cascade');
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
         Schema::dropIfExists('branches');
    }
};
