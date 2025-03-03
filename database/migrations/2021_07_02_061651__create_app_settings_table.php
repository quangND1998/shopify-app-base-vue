<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_appsettings', function (Blueprint $table) {
            $table->id();
            $table->string('api_key', 300)->nullable();
            $table->string('redirect_url', 300)->nullable();
            $table->mediumText('permissions')->nullable();
            $table->string('shared_secret', 300);
            $table->string('app_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('tbl_appsettings');
    }
}
