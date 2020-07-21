<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../../libraries/users.php";
        $_user = new user($_POST["token"]);
        if ($_user -> check_level(1001)) {
            require __DIR__ . "/../../../../../../configurations/database/class.php";
            $q = $database -> query("SELECT `id` FROM `enr_news` WHERE `id` = " . intval($_POST["id"]) . ";");
            if ($q -> num_rows != 0) {
                $specialty = intval($_POST["group"]);
                $granted = false;
                if ($database -> query("SELECT `id` FROM `enr_specialties` WHERE `id` = $specialty;") -> num_rows != 0 || $specialty == 0)
                    $granted = true;
                if ($granted) {
                    $database -> query("UPDATE `enr_news` SET `heading` = '" . addslashes($_POST["heading"]) . "', `synopsis` = '" . addslashes($_POST["synopsis"]) . "', `mainText` = '" . htmlspecialchars($_POST["text"]) . "', `isImportant` = " . ($_POST["important"] == "true" ? 1 : 0) . ", specialty = " . ($specialty == 0 ? "NULL" : "{$specialty}") . " WHERE `id` = " . intval($_POST["id"]) . ";");
                    echo json_encode([
                        "status" => "OK",
                        "heading" => $_POST["heading"],
                    ]);
                }  else
                    echo json_encode([
                        "status" => "SPECIALTY_IS_NOT_FOUND",
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