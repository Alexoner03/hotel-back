<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->enum('state',['paid','created','canceled']);
            $table->double('price');
            $table->double('igv');
            $table->unsignedBigInteger('type_voucher_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('type_voucher_id')->references('id')->on('type_vouchers');
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
        Schema::dropIfExists('vouchers');
    }
}
