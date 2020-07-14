<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../../libraries/users.php";
        $_user = new user($_POST["token"]);
        if ($_user -> check_level(1001)) {
            require __DIR__ . "/../../../../../../configurations/database/class.php";
            $database -> query("DELETE FROM `enr_news` WHERE `id` = " . intval($_POST["id"]) . ";");
            echo json_encode([
                "status" => "OK",
            ]);
            $database -> close();
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $_user -> c();
    }
?>
