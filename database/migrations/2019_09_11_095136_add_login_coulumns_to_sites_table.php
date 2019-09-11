<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoginCoulumnsToSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->string('login_url', 255)->nullable()->after('price_modification');
            $table->string('username', 64)->nullable()->after('login_url');
            $table->string('password', 255)->nullable()->after('username');
            $table->string('login_button_text', 30)->nullable()->after('login_url');
            $table->string('username_input_field', 60)->nullable()->after('password');
            $table->string('password_input_field', 60)->nullable()->after('username_input_field');
            $table->string('session_name', 32)->nullable()->after('password_input_field');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn(['login_url', 'username', 'password', 'session_name']);
        });
    }
}
