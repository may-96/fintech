<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportSharesWithUnregisteredUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_shares_with_unregistered_users', function (Blueprint $table) {
            $table->id();
            $table->string("email",128);
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('view_cash_flow')->default(0);
            $table->unsignedTinyInteger('view_expense')->default(0);
            $table->unsignedTinyInteger('view_income')->default(0);
            $table->unsignedTinyInteger('view_email')->default(0);
            $table->unsignedTinyInteger('view_contact')->default(0);
            $table->unsignedTinyInteger('view_credit_score')->default(0);
            $table->string('token')->unique()->nullable(false);
            $table->timestamps();

            $table->unique(['email', 'user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_shares_with_unregistered_users');
    }
}
