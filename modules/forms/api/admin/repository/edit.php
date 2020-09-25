<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../libraries/users.php";
        $user = new user($_POST["token"]);
        if ($user -> check_level(2001) || $user -> check_level(0)) {
            require __DIR__ . "/../../../../../configurations/database/class.php";
            if (isset($_POST["name"]) && isset($_POST["collectEmail"]) && isset($_POST["form"]) && isset($_POST["id"])) {
                $append = [
                    "name" => $_POST["name"],
                    "email" => $_POST["email"],
                    "collectEmail" => $_POST["collectEmail"] == "true" ? 1 : 0,
                    "form" => $_POST["form"],
                    "id" => intval($_POST["id"]),
                ];
                $database -> query("UPDATE `frm_forms` SET `name` = '{$append["name"]}', `email` = '{$append["email"]}', `collectEmail` = {$append["collectEmail"]}, `form` = '{$append["form"]}' WHERE `id` = {$append["id"]};");
                echo json_encode([
                    "status" => "OK",
                ]);
            } else
                echo json_encode([
                    "status" => "SOME_DATA_IS_EMPTY",
                ]);
            $database -> close();
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
    } else
        echo json_encode([
            "status" => "ACCESS_DENIED",
        ]);
?>
