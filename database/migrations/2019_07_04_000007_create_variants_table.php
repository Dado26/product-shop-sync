<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'variants';

    /**
     * Run the migrations.
     * @table variants
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->string('name', 120);
            $table->decimal('price', 9, 2);

            $table->index(["product_id"], 'fk_variants_products1_idx');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('product_id', 'fk_variants_products1_idx')
                ->references('id')->on('products')
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
