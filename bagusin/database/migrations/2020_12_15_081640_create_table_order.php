<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('mechanic_id');
            $table->string('status')->default('waiting');
            $table->string('problem_description');
            $table->string('customer_phone');
            $table->string('address');
            $table->string('problem_pic1');
            $table->string('problem_pic2')->nullable();
            $table->string('problem_pic3')->nullable();
            $table->string('problem_pic4')->nullable();
            $table->string('customer_review')->nullable();
            $table->integer('customer_rating')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
