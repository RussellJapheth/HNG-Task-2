<?php

require_once __DIR__ . '/../vendor/autoload.php';

Flight::route(
    '/',
    function () {
        Flight::redirect('/api/');
    }
);
Flight::route(
    '/api',
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

Flight::start();
