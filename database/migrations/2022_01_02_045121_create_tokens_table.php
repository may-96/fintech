<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->string('access', 1024);
            $table->unsignedInteger('access_expires');
            $table->string('refresh',1024);
            $table->unsignedInteger('refresh_expires');
            $table->unsignedTinyInteger('status')->default(1)->comment("0 - Expired\n1 - Active\n2 - New");
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
        Schema::dropIfExists('tokens');
    }
}
