<?php
    $database;
    if ($auth = parse_ini_file(__DIR__ . "/auth.ini")) {
        $database = new mysqli($auth["host"], $auth["login"], $auth["password"], $auth["database"]);
        if ($database -> connect_errno) {
            http_response_code(500);
            exit;
        } else
            $database -> set_charset("utf8");
    } else {
        http_response_code(500);
        exit;
    }
?>