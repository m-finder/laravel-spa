<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id');
            $table->string('name');
            $table->string('title');
            $table->string('redirect')->nullable()->default(null);
            $table->string('component');
            $table->string('path');
            $table->string('icon');
            $table->integer('order_num')->default(0);
            $table->boolean('hidden')->nullable()->default(false);
            $table->boolean('affix')->nullable()->default(false);
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
        Schema::dropIfExists('menus');
    }
}
