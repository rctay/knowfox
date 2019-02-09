<?php

# Source: https://github.com/cloudfoundry-samples/cf-ex-phpmyadmin/blob/master/htdocs/config.inc.php#L27
$service_blob = json_decode($_ENV['VCAP_SERVICES'], true);
$mysql_services = array();
$pgsql_services = array();
foreach($service_blob as $service_provider => $service_list) {
    foreach ($service_list as $some_service) {
        if (in_array('mysql', $some_service['tags'], true)) {
            $mysql_services[] = $some_service;
            continue;
        }
        if (in_array('postgresql', $some_service['tags'], true)) {
            $pgsql_services[] = $some_service;
            continue;
        }
    }
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => $mysql_services[0]['credentials']['hostname'],
            'port' => $mysql_services[0]['credentials']['port'],
            'database' => $mysql_services[0]['credentials']['name'],
            'username' => $mysql_services[0]['credentials']['username'],
            'password' => $mysql_services[0]['credentials']['password'],
            /*
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            */
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],


        'd7' => [
            'driver' => 'mysql',
            'host' => env('DB_D7_HOST', '127.0.0.1'),
            'port' => env('DB_D7_PORT', '3306'),
            'database' => env('DB_D7_DATABASE', 'forge'),
            'username' => env('DB_D7_USERNAME', 'forge'),
            'password' => env('DB_D7_PASSWORD', ''),
            /*
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            */
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => parse_url($pgsql_services[0]['credentials']['uri'])['host'],
            'port' => parse_url($pgsql_services[0]['credentials']['uri'])['port'],
            'database' => trim(parse_url($pgsql_services[0]['credentials']['uri'])['path'], '/'),
            'username' => parse_url($pgsql_services[0]['credentials']['uri'])['user'],
            'password' => parse_url($pgsql_services[0]['credentials']['uri'])['pass'],
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
