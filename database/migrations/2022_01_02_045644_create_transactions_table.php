<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->string('custom_uid');
            $table->double("transaction_amount",15,2);
            $table->date('fixed_date');
            $table->string('year');
            $table->string("transaction_id",255)->nullable();
            $table->string('transaction_currency',20)->nullable();
            $table->date('booking_date')->nullable()->comment("The Date when an entry is posted to an account on the financial institutions books.");
            $table->date('value_date')->nullable()->comment("The Date at which assets become available to the account owner in case of a credit");
            $table->string("remit_info_unstructured",512)->nullable();
            $table->string("debator_name",100)->nullable();
            $table->string("debtor_account")->nullable();
            $table->string("creditor_name",100)->nullable();
            $table->string("creditor_account")->nullable();
            $table->string("additional_information",512)->nullable();
            $table->string("entry_reference",60)->nullable();
            $table->string("category")->nullable()->comment("Nordigen Premium EndPoint");
            $table->string("merchant_name")->nullable()->comment("Nordigen Premium EndPoint");
            $table->string("transaction_type")->nullable()->comment("Nordigen Premium EndPoint - Transaction types:\nPAYMENT\nTRANSFER\nREFUND\nATM\nOTHER");
            $table->string("purpose_code")->nullable();
            $table->string("bank_transaction_code")->nullable();
            $table->string("status",20)->default('pending')->comment("- booked\n- pending");
            $table->string("end_to_end_id")->nullable();
            $table->string("notes",1024)->nullable()->comment("User Notes");
            $table->unsignedBigInteger('category_id')->nullable()->comment('Our own cateogories');
            $table->string("additional_information_structured",512)->nullable();
            $table->string("balance_after_transaction")->nullable();
            $table->string("check_id")->nullable();
            $table->string("creditor_agent")->nullable();
            $table->string("creditor_id")->nullable();
            $table->string("currency_exchange")->nullable();
            $table->string("debtor_agent")->nullable();
            $table->string("mandate_id")->nullable();
            $table->string("proprietary_bank_transaction_code")->nullable();
            $table->string("remittance_information_structured",512)->nullable();
            $table->string("remittance_information_structured_array",1024)->nullable();
            $table->string("remittance_information_unstructured_array",1024)->nullable();
            $table->string("ultimate_creditor")->nullable();
            $table->string("ultimate_debtor")->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
