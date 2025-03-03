<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_usersettings', function (Blueprint $table) {
            $table->id();
            $table->mediumText('access_token');
            $table->string('store_name', 300);
            $table->dateTime('installed_date');
            $table->integer('app_id');
            $table->string('status')->default('trial');
            $table->mediumText('confirmation_url')->nullable();
            $table->string('plan_name')->default('basic');
            $table->bigInteger('plan_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('tbl_usersettings');
    }
}
