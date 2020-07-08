<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["id"])) {
            require __DIR__ . "/../../../../../libraries/users.php";
            $_user = new user($_POST["token"]);
            if ($_user -> check_level(1001) || $_user -> check_level(1002)) {
                require __DIR__ . "/../../../php/docs.php";
                $id = intval($_POST["id"]);
                switch ($_POST["type"]) {
                    case "receipt":
                        echo json_encode([
                            "status" => "OK",
                            "doc" => base64_encode(receipt($_user, $id)),
                        ]);
                    break;
                    case "statement":
                        echo json_encode([
                            "status" => "OK",
                            "doc" => base64_encode(statement($_user, $id)),
                        ]);
                    break;
                } 
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
            $_user -> c();
        } else
            echo json_encode([
                "status" => "ID_IS_EMPTY",
            ]);
    }
?>