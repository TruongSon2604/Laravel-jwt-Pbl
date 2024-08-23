<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Sử dụng foreignId thay vì bigInteger để vừa khai báo cột vừa thiết lập khóa ngoại
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->boolean('is_trendy')->default(false);
            $table->boolean('is_available')->default(true);
            $table->double('price', 8, 2);
            $table->integer('amount');
            $table->double('discount', 8, 2)->nullable();
            $table->string('image');
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
        Schema::dropIfExists('products');
    }
}
