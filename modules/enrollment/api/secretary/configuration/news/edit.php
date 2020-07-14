<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../../libraries/users.php";
        $_user = new user($_POST["token"]);
        if ($_user -> check_level(1001)) {
            require __DIR__ . "/../../../../../../configurations/database/class.php";
            $q = $database -> query("SELECT `id` FROM `enr_news` WHERE `id` = " . intval($_POST["id"]) . ";");
            if ($q -> num_rows != 0) {
                $database -> query("UPDATE `enr_news` SET `heading` = '" . addslashes($_POST["heading"]) . "', `synopsis` = '" . addslashes($_POST["synopsis"]) . "', `mainText` = '" . htmlspecialchars($_POST["text"]) . "', `isImportant` = " . ($_POST["important"] == "true" ? 1 : 0) . " WHERE `id` = " . intval($_POST["id"]) . ";");
                echo json_encode([
                    "status" => "OK",
                    "heading" => $_POST["heading"],
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
