<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('shared_with')->nullable(false);
            $table->unsignedTinyInteger('view_cash_flow')->default(1);
            $table->unsignedTinyInteger('view_expense')->default(1);
            $table->unsignedTinyInteger('view_income')->default(1);
            $table->unsignedTinyInteger('view_email')->default(1);
            $table->unsignedTinyInteger('view_contact')->default(1);
            $table->unsignedTinyInteger('view_credit_score')->default(1);
            $table->unsignedTinyInteger('view_initials_only')->default(0);
            $table->unsignedTinyInteger('view_account_initials_only')->default(0);
            $table->unsignedDouble('amount',10,2)->default(0)->nullable(false);
            $table->string('currency',100)->default('EUR')->nullable(false);
            $table->string('token')->nullable(false)->unique();
            $table->string('shareable_link')->nullable(true);
            $table->string('reference',128)->nullable(true);
            $table->timestamps();

            // $table->unique(['user_id','shared_with']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shared_with')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_user');
    }
}
