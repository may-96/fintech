<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSharesWithUnregisteredUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_shares_with_unregistered_users', function (Blueprint $table) {
            $table->id();
            $table->string("email");
            $table->unsignedBigInteger('account_id');
            $table->timestamps();

            $table->unique(['email', 'account_id']);
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_shares_with_unregistered_users');
    }
}
