<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('dob',50)->nullable();
            $table->string('contact',50)->nullable();
            $table->string('company',100)->nullable();
            $table->string('gender',10)->nullable();
            $table->string('currency',10)->default('EUR');
            $table->string('address')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamp('last_transaction_fetch_time')->nullable();
            $table->smallInteger('account_error_code')->nullable();
            $table->smallInteger('agreement_error_code')->nullable();
            $table->smallInteger('balance_error_code')->nullable();
            $table->smallInteger('institution_error_code')->nullable();
            $table->smallInteger('requisition_create_error_code')->nullable();
            $table->smallInteger('requisition_delete_error_code')->nullable();
            $table->smallInteger('requisition_fetch_error_code')->nullable();
            $table->smallInteger('transaction_error_code')->nullable();
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
        Schema::dropIfExists('users');
    }
}
