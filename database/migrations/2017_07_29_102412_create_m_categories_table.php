<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_categories', function(Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name', 255);
            $table->string('icon', 255);
            $table->integer('indexing')->nullable();
            $table->text('description')->nullable();
            $table->integer('parent_id')->nullable();
            $table->rememberToken();
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
        Schema::drop('m_categories');
    }
}
