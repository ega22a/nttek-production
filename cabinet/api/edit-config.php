<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../libraries/users.php";
    if (!empty($_POST["token"]) && !empty($_POST["type"]) && !empty($_POST["data"])) {
        $users = new user($_POST["token"]);
        if ($users -> _isFound && $users -> check_level(0)) {
            require_once __DIR__ . "/../../configurations/main.php";
            if ($json = json_decode($_POST["data"])) {
                $conf = new configuration();
                switch($_POST["type"]) {
                    case "database":
                        if (!empty($json -> host) && !empty($json -> login) && !empty($json -> password) && !empty($json -> name)) {
                            $conf -> update(__DIR__ . "/../../configurations/database/auth.ini", [
                                "host" => $json -> host,
                                "login" => $json -> login,
                                "password" => $json -> password,
                                "name" => $json -> name,
                            ]);
                            echo json_encode([
                                "status" => "OK",
                            ]);
                        } else
                            echo json_encode([
                                "status" => "JSON_DATA_ARE_NOT_FULL",
                            ]);
                    break;
                    case "email":
                        if (!empty($json -> host) && !empty($json -> login) && !empty($json -> password) && !empty($json -> port)) {
                            $conf -> update(__DIR__ . "/../../configurations/email/auth.ini", [
                                "host" => $json -> host,
                                "login" => $json -> login,
                                "password" => $json -> password,
                                "port" => $json -> port,
                            ]);
                            echo json_encode([
                                "status" => "OK",
                            ]);
                        } else
                            echo json_encode([
                                "status" => "JSON_DATA_ARE_NOT_FULL",
                            ]);
                    break;
                }
            } else
                echo json_encode([
                    "status" => "INVALID_JSON_TYPE",
                ]);
        }
        else
            echo json_encode([
                "status" => "ADMIN_IS_NOT_FOUND",
            ]);
        $users -> c();
    } else
        echo json_encode([
            "status" => "SOME_DATA_IS_EMPTY",
        ]);
?>