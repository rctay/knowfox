<?php

namespace Knowfox\Repositories;

use Illuminate\Support\Facades\DB;
use PDO;

class ConceptRepository
{
    public function withFullTextSearchFragment($query, string $search_term)
    {
        switch (DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'mysql':
                $query->whereRaw(
                    'MATCH(title,summary,body) AGAINST(? IN NATURAL LANGUAGE MODE)', [$search_term]
                );
                break;
            case 'pgsql':
                $query->whereRaw(<<<PSQL
                    to_tsvector(
                        CASE
                            WHEN language = 'de' THEN 'german'::regconfig
                            WHEN language = 'en' THEN 'english'::regconfig
                            ELSE 'simple'::regconfig
                        END,
                        coalesce(title, '') || ' ' || coalesce(summary, '') || ' ' || coalesce(body, '')) @@ to_tsquery(?)
PSQL
                    , [$search_term]);
                break;
        }
    }
}
