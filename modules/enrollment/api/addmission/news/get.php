<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../libraries/users.php";
        $_user = new user($_POST["token"]);
        if ($_user -> check_level(1003)) {
            require __DIR__ . "/../../../../../configurations/database/class.php";
            $q = $database -> query("SELECT * FROM `enr_news` WHERE `id` = " . intval($_POST["id"]) . ";");
            if ($q -> num_rows != 0) {
                $q = $q -> fetch_assoc();
                echo json_encode([
                    "status" => "OK",
                    "heading" => stripcslashes($q["heading"]),
                    "text" => htmlspecialchars_decode($q["mainText"]),
                    "date" => Date("d.m.Y", $q["timestamp"]),
                ]);
            } else
                echo json_encode([
                    "status" => "NEWS_IS_NOT_FOUND",
                ]);
            $database -> close();
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $_user -> c();
    }
?>
