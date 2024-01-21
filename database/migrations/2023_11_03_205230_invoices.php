<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('invoices', function (Blueprint $table) {

            $table->increments('id');
            $table->string('invoiceNo')->unique();
            $table->date('invoiceDate')->nullable();
            $table->date('dueDate')->nullable();
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');
            $table->string('title');
            $table->string('client');
            $table->string('clientAddress');
            $table->string('clientInfo');
            $table->decimal('subTotal', 10, 2)->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('grandTotal', 10, 2)->default(0);
            $table->text('termsAndConditions')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->char('item', 255);
            $table->integer('qty');
            $table->decimal('unitPrice', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_items');
        Schema::enableForeignKeyConstraints();
    }
};
