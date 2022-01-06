<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('agreement_id',512)->nullable(false);
            $table->string('agreement_date')->nullable();
            $table->unsignedTinyInteger('balances_scope')->default(1);
            $table->unsignedTinyInteger('details_scope')->default(1);
            $table->unsignedTinyInteger('transactions_scope')->default(1);
            $table->unsignedInteger('max_historical_days')->default(90);
            $table->unsignedInteger('access_valid_for_days')->default(90);
            $table->string('accepted')->nullable();
            $table->unsignedBigInteger('institution_id')->nullable(false);
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreements');
    }
}
