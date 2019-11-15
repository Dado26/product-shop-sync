<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'sites';

    /**
     * Run the migrations.
     * @table sites
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name', 120);
            $table->string('url', 120);
            $table->string('email', 120)->nullable();
            $table->decimal('price_modification', 5, 2)->nullable();
            $table->string('login_url')->nullable();
            $table->string('login_button_text', 30)->nullable();
            $table->string('username', 64)->nullable();
            $table->string('password')->nullable();
            $table->string('username_input_field', 60)->nullable();
            $table->string('password_input_field', 60)->nullable();
            $table->string('auth_element_check', 60)->nullable();
            $table->string('session_name', 32)->nullable();

            $table->index(["user_id"], 'fk_sites_users_idx');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('user_id', 'fk_sites_users_idx')
                ->references('id')->on('users')
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
