<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsLinkRulesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'products_link_rules';

    /**
     * Run the migrations.
     * @table products_link_rules
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('site_id');
            $table->string('next_page')->nullable();
            $table->string('product_link')->nullable();

            $table->index(["site_id"], 'fk_products_link_rules_sites1_idx');
            $table->nullableTimestamps();


            $table->foreign('site_id', 'fk_products_link_rules_sites1_idx')
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
