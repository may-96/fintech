<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agreement_id')->nullable(false);
            $table->string('requisition_id',512)->nullable(false);
            $table->string('language', 30)->nullable(true)->default("EN");
            $table->string('status')->default('CR');
            $table->string('status_long')->default('CREATED');
            $table->string('status_description')->default('Requisition has been succesfully created');
            $table->string('reference_id');
            $table->string('link',512);
            $table->timestamps();

            $table->foreign('agreement_id')->references('id')->on('agreements')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
}
