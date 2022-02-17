<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('institution_id')->nullable(false);
            $table->unsignedBigInteger('requisition_id')->nullable(true);
            $table->string('account_id',80)->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_status',30)->nullable();
            $table->string('display_name')->nullable();
            $table->string('currency')->nullable();
            $table->string('bic')->nullable();
            $table->string('iban')->nullable();
            $table->string('bban')->nullable();
            $table->string('msisdn')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->nullable()->comment("ExternalCashAccountType1Code from ISO 20022");
            $table->string('type_string')->nullable();
            $table->string('status')->nullable()->default('enabled')->comment("Account status. The value is one of the following:\n'enabled': account is available\n'deleted': account is terminated\n'blocked': account is blocked e.g. for legal reasons");
            $table->string('usage')->nullable()->comment("Specifies the usage of the account\nPRIV: private personal account\nORGA: professional account");
            $table->string('linked_accounts')->nullable()->comment("This data attribute is a field, where an financial institution can name a cash account associated to pending card transactions.");
            $table->string('resource_id')->nullable()->comment("The account id of the given account in the financial institution");
            $table->string('product_name')->nullable()->comment("Product Name of the Bank for this account, proprietary definition");
            $table->string('details',512)->nullable();
            $table->double('credit_score',10,2,true)->nullable(true);
            $table->string('nickname',100)->nullable();
            $table->timestamps();

            $table->unique(['user_id','institution_id','account_id']);
            

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('requisition_id')->references('id')->on('requisitions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
