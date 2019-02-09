<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFulltext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concepts', function (Blueprint $table) {
            switch (config('database.default')) {
                case 'mysql':
                    DB::statement('ALTER TABLE concepts ADD FULLTEXT search(title, summary, body)');
                    break;
                case 'pgsql':
                    DB::statement(<<<EOT
CREATE INDEX concepts_fts_index
  ON concepts
  USING GIN(
  to_tsvector(
    CASE
    WHEN language = 'de' THEN 'german'::regconfig
    WHEN language = 'en' THEN 'english'::regconfig
    ELSE 'simple'::regconfig
    END,
    coalesce(title, '') || ' ' || coalesce(summary, '') || ' ' || coalesce(body, '')))
EOT
                    );
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
        Schema::table('concepts', function (Blueprint $table) {
            //
        });
    }
}
