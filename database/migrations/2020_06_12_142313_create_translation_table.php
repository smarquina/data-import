<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('translation', function (Blueprint $table) {
            $table->id();
            $table->string('table_type');
            $table->integer('table_id');
            $table->string('column_name');
            $table->string('locale', 5);
            $table->string('value', 255);
            $table->timestamps();
//            $table->index(['table', 'column_name']);
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
