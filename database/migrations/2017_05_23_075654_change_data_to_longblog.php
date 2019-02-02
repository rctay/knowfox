<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeDataToLongblog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('versions', function (Blueprint $table) {
            switch (config('database.default')) {
                case 'mysql':
                    DB::statement('ALTER TABLE versions CHANGE model_data model_data LONGBLOB NOT NULL');
                    break;
                case 'pgsql':
                    // $table->binary('model_data') is already of type BYTEA
                    break;
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('versions', function (Blueprint $table) {
            //
        });
    }
}
