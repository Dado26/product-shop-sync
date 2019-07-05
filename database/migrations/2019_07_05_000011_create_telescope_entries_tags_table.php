<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelescopeEntriesTagsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'telescope_entries_tags';

    /**
     * Run the migrations.
     * @table telescope_entries_tags
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('entry_uuid', 36);
            $table->string('tag');

            $table->index(["tag"], 'telescope_entries_tags_tag_index');

            $table->index(["entry_uuid", "tag"], 'telescope_entries_tags_entry_uuid_tag_index');


            $table->foreign('entry_uuid', 'telescope_entries_tags_entry_uuid_tag_index')
                ->references('uuid')->on('telescope_entries')
                ->onDelete('cascade')
                ->onUpdate('restrict');
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
