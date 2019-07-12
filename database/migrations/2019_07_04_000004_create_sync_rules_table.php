<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyncRulesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'sync_rules';

    /**
     * Run the migrations.
     * @table sync_rules
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('site_id');
            $table->string('title');
            $table->string('description');
            $table->string('specifications')->nullable();
            $table->string('price');
            $table->unsignedTinyInteger('price_decimals');
            $table->string('in_stock');
            $table->string('in_stock_value', 120);
            $table->string('images');
            $table->string('variants', 100)->nullable();

            $table->unique(["site_id"], 'fk_sync_rules_sites1_idx');


            $table->foreign('site_id', 'fk_sync_rules_sites1_idx')
                ->references('id')->on('sites')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
