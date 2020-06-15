<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('table');
            $table->string('column_name');
            $table->integer('foreign_key');
            $table->string('locale', 5);
            $table->string('value', 255);
            $table->timestamps();
            $table->index(['table', 'column_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('translations');
    }
}
