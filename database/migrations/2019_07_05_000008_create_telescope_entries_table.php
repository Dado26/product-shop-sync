<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelescopeEntriesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'telescope_entries';

    /**
     * Run the migrations.
     * @table telescope_entries
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('sequence');
            $table->char('uuid', 36);
            $table->char('batch_id', 36);
            $table->string('family_hash')->nullable()->default(null);
            $table->tinyInteger('should_display_on_index')->default('1');
            $table->string('type', 20);
            $table->longText('content');
            $table->dateTime('created_at')->nullable()->default(null);

            $table->index(["batch_id"], 'telescope_entries_batch_id_index');

            $table->index(["family_hash"], 'telescope_entries_family_hash_index');

            $table->index(["type", "should_display_on_index"], 'telescope_entries_type_should_display_on_index_index');

            $table->unique(["uuid"], 'telescope_entries_uuid_unique');
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
