<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../libraries/users.php";
        $user = new user($_POST["token"]);
        if ($user -> check_level(2001) || $user -> check_level(0)) {
            require __DIR__ . "/../../../../../configurations/database/class.php";
            if (isset($_POST["id"])) {
                $id = intval($_POST["id"]);
                $database -> query("DELETE FROM `frm_forms` WHERE `id` = {$id};");
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
