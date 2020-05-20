<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["id"])) {
            require __DIR__ . "/../../../../../libraries/users.php";
            $_user = new user($_POST["token"]);
            if ($_user -> check_level(1001) || $_user -> check_level(1002)) {
                require __DIR__ . "/../../../../../configurations/database/class.php";
                $id = intval($_POST["id"]);
                if ($database -> query("SELECT `id` FROM `enr_statements` WHERE `id` = {$id} AND `isOnline` = 0 AND `usersId` IS NULL;") -> num_rows == 1) {
                    if (empty($database -> query("DELETE FROM `enr_statements` WHERE `id` = {$id}") -> error))
                        echo json_encode([
                            "status" => "OK",
                        ]);
                    else
                        echo json_encode([
                            "status" => "DB_ERROR",
                        ]);
                } else
                    echo json_encode([
                        "status" => "ENROLLEE_IS_NOT_FOUND",
                    ]);
                $database -> close();
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
        } else
            echo json_encode([
                "status" => "ID_IS_EMPTY",
            ]);
    }
?>