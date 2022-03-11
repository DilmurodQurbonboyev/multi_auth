<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data', function (Blueprint $table) {
            $table->unsignedBigInteger('userid')->primary();
            $table->string('birth_date')->nullable();
            $table->string('ctzn')->nullable();
            $table->string('per_adr')->nullable();
            $table->string('pport_issue_place')->nullable();
            $table->string('sur_name')->nullable();
            $table->string('gd')->nullable();
            $table->string('natn')->nullable();
            $table->string('pport_issue_date')->nullable();
            $table->string('pport_expr_date')->nullable();
            $table->string('pport_no')->nullable();
            $table->string('pin')->unique()->nullable();
            $table->string('mob_phone_no')->nullable();
            $table->string('user_id')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('birth_place')->nullable();
            $table->string('mid_name')->nullable();
            $table->string('valid')->nullable();
            $table->string('user_type')->nullable();
            $table->string('ret_cd')->nullable();
            $table->string('first_name')->nullable();
            $table->string('full_name')->nullable();
            $table->timestamps();
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_data');
    }
}
