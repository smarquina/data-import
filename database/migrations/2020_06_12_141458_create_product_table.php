<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->foreignId('category_id')->nullable()->constrained('category')->onDelete('cascade');
            $table->string('name', 255)->unique();
            $table->string('description', 255)->nullable();
            $table->float('price')->nullable();
            $table->integer('stock')->nullable();
            $table->dateTime('last_sale_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('product');
    }
}
