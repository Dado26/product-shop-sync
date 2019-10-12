<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkuColumnsToProductsAndSyncRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sync_rules', function (Blueprint $table) {
            $table->string('sku')->nullable();
            $table->string('remove_string_from_sku', 64)->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sync_rules', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('remove_string_from_sku');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sku');
        });
    }
}
