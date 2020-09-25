<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../libraries/users.php";
        $user = new user($_POST["token"]);
        if ($user -> check_level(2001) || $user -> check_level(0)) {
            require __DIR__ . "/../../../../../configurations/database/class.php";
            if (isset($_POST["name"]) && isset($_POST["collectEmail"]) && isset($_POST["form"])) {
                $append = [
                    "name" => $_POST["name"],
                    "email" => $_POST["email"],
                    "collectEmail" => $_POST["collectEmail"] == "true" ? 1 : 0,
                    "form" => $_POST["form"],
                ];
                $database -> query("INSERT INTO `frm_forms` (`name`, `form`, `email`, `collectEmail`) VALUES ('{$append["name"]}', '{$_POST["form"]}', '{$append["email"]}', {$append["collectEmail"]});");
                echo json_encode([
                    "status" => "OK",
                    "id" => $database -> insert_id,
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
