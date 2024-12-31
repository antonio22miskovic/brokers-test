<?php

require '../vendor/autoload.php';

// Conexion con base de datos
Flight::register('db', \flight\database\PdoWrapper::class, [
    'mysql:host=localhost;dbname=tarea1', 
    'test', 
    'heavy', [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8mb4\'',
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
]);

// Flight::set('flight.views.path', '/app/resources/views');

require '../routes/web.php';

Flight::start();