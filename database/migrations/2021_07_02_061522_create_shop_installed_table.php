<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopInstalledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_installed', function (Blueprint $table) {
            $table->id();
            $table->string('shop', 300);
            $table->dateTime('date_installed');
            $table->integer('app_id');
            $table->string('name_shop')->nullable();
            $table->string('email_shop')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('country')->nullable();
            $table->dateTime('date_uninstalled')->nullable();
            $table->text('note')->nullable();
            $table->string('timezone')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('shop_installed');
    }
}
