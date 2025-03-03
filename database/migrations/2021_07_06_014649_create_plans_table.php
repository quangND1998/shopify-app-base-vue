<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id');
            // The type of plan, either PlanType::RECURRING or PlanType::ONETIME or PlanType::USAGE or PlanType::APPLICATION_CREDIT
            $table->string('type')->default('RECURRING');

            // Name of the plan
            $table->string('name');

            // Price of the plan
            $table->decimal('price', 8, 2);

            // The interval of the plan Interval EVERY_30_DAYS or ANNUAL
            $table->string('interval')->default('EVERY_30_DAYS');

            // Store the amount of the charge, this helps if you are experimenting with pricing
            $table->decimal('capped_amount', 8, 2)->nullable();

            // Terms for the usage charges
            $table->text('terms')->nullable();

            // Nullable in case of 0 trial days
            $table->integer('trial_days')->nullable();

            // Is a test plan or not
            $table->boolean('test')->default(false);

            // On-install
            $table->boolean('on_install')->default(false);

            // Default plan when install
            $table->boolean('default')->default(false);

            // Provides created_at && updated_at columns
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
        // Schema::dropIfExists('shopify_plans');
    }
}
