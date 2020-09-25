<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../libraries/users.php";
        $user = new user($_POST["token"]);
        if ($user -> check_level(2001) || $user -> check_level(0)) {
            require __DIR__ . "/../../../../../configurations/database/class.php";
            if (isset($_POST["id"])) {
                $id = intval($_POST["id"]);
                $query = $database -> query("SELECT * FROM `frm_forms` WHERE `id` = {$id}");
                if ($query -> num_rows != 0) {
                    $query = $query -> fetch_assoc();
                    echo json_encode([
                        "status" => "OK",
                        "name" => $query["name"],
                        "collectEmail" => $query["collectEmail"],
                        "email" => $query["email"],
                        "form" => $query["query"],
                    ]);
                } else
                    echo json_encode([
                        "status" => "FORM_IS_NOT_FOUND",
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
