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
        Schema::create('order_record', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('status')->default(0);         // статус заказа
            $table->integer('count_products')->default(0); // общее кол-во товара
            $table->integer('sum_price')->default(0);      // общая сумма заказа
            $table->string('email');                       // почта покупателя
            $table->string('address')->nullable();         // адресс доставки
            $table->text('other')->nullable();             // примечание к заказу
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');                  // ссылка на заказ
            $table->integer('product_id');                // ссылка на товар
            $table->integer('count_product')->default(1); // количество этого товара
            $table->text('param_values')->nullable();     // внесенные параметры товара для заказа
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('order_record');
    }
};
