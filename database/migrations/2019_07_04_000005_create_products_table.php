<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'products';

    /**
     * Run the migrations.
     * @table products
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('site_id');
            $table->string('title', 180);
            $table->text('description')->nullable();
            $table->string('url');
            $table->string('category', 60);
            $table->string('status', 20);
            $table->timestamp('synced_at')->nullable();

            $table->index(["site_id"], 'fk_products_sites1_idx');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('site_id', 'fk_products_sites1_idx')
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
