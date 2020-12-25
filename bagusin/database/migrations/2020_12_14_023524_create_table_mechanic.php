<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMechanic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('address');
            $table->string('services');
            $table->string('servicedescription');
            $table->integer('score')->default(0);
            $table->integer('reviews_number')->default(0);
            $table->string('garage_photo_path1')->nullable();
            $table->string('garage_photo_path2')->nullable();
            $table->string('garage_photo_path3')->nullable();
            $table->string('garage_photo_path4')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            // created_at and updated_at
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
        Schema::dropIfExists('mechanics');
    }
}
