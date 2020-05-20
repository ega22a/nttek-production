<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../configuration.php";
    if (checkConfigurations())
        http_response_code(404);
    else {
        if (in_array(CLIENT_IP, ALLOWED_IPS)) {
            if (!empty($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["host"]) && !empty($_POST["database"])) {
                $check = new mysqli($_POST["host"], $_POST["login"], $_POST["password"], $_POST["database"]);
                if ($check -> connect_errno)
                    echo json_encode([
                        "status" => "CONNECT_ERROR",
                        "message" => $check -> connect_error,
                    ]);
                else {
                    $check -> multi_query(file_get_contents(__DIR__ . "/../sql/create-database.sql"));
                    echo json_encode([
                        "status" => "OK",
                    ]);
                }
                $check -> close();
            } else
                echo json_encode([
                    "status" => "SOME_DATA_IS_EMPTY",
                ]);
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
    }
?>