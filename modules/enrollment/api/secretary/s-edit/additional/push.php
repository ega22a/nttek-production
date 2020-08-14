<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["statement"])) {
            require __DIR__ . "/../../../../../../libraries/users.php";
            $user = new user($_POST["token"]);
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                $_statement_id = intval($_POST["statement"]);
                require __DIR__ . "/../../../../../../configurations/database/class.php";
                if ($database -> query("SELECT * FROM `enr_statements` WHERE `id` = {$_statement_id} AND `usersId` IS NOT NULL;") -> num_rows == 1) {
                    $code = is_null($_POST["message"]) || empty($_POST["message"]) ? "NULL" : "'" . htmlspecialchars($_POST["message"]) . "'";
                    $t = $database -> query("UPDATE `enr_statements` SET `additionalText` = {$code} WHERE `id` = {$_statement_id};");
                    echo json_encode([
                        "status" => "OK",
                    ]);
                } else
                    echo json_encode([
                        "status" => "STATEMENT_IS_NOT_FOUND",
                    ]);
                $database -> close();
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
        } else
            echo json_encode([
                "status" => "STATEMENT_ID_IS_EMPTY",
            ]);
    } else
        echo json_encode([
            "status" => "ACCESS_DENIED",
        ]);
?>
