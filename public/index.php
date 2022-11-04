<?php

use Russell\HNG\MathHandler;

require_once __DIR__ . '/../vendor/autoload.php';

Flight::route(
    '/',
    function () {
        Flight::redirect('/api/');
    }
);

Flight::route(
    'GET /api',
    function () {
        header("Access-Control-Allow-Origin: *");
        Flight::json(
            [
                "slackUsername" => "russell",
                "backend" => true,
                "age" => 51,
                "bio" => "Backend Developer | Technical Writer | Linux Advocate | Food Enthusiast"
            ]
        );
    }
);

Flight::route(
    'POST /api',
    function () {
        header("Access-Control-Allow-Origin: *");
        $handler = new MathHandler(Flight::request()->data);

        $result = $handler->getResult();

        if (empty($result->operation_type)) {
            Flight::json($result, 500);
            return;
        }
        Flight::json($result);
    }
);

Flight::start();
