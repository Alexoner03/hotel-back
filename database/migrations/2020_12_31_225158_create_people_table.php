<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('sex', ['M', 'F']);
            $table->char('cellphone',9);
            $table->char('dni',8)->unique()->nullable();
            $table->string('first_lastname')->nullable();
            $table->string('second_lastname')->nullable();
            $table->date('birthday');
            $table->string('email');
            $table->char('ruc',11)->nullable();
            $table->string('business_name')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('type_people_id');
            $table->foreign('type_people_id')->references('id')->on('type_people');
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
        Schema::dropIfExists('people');
    }
}
