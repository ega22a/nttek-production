<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../../libraries/users.php";
        $_user = new user($_POST["token"]);
        if ($_user -> check_level(1001)) {
            require __DIR__ . "/../../../../../../configurations/database/class.php";
            $specialty = intval($_POST["group"]);
            $granted = false;
            if ($database -> query("SELECT `id` FROM `enr_specialties` WHERE `id` = $specialty;") -> num_rows != 0 || $specialty == 0)
                $granted = true;
            if ($granted) {
                $database -> query("INSERT INTO `enr_news` (`heading`, `synopsis`, `mainText`, `isImportant`, `author`, `specialty`, `timestamp`) VALUES ('" . addslashes($_POST["heading"]) . "', '" . addslashes($_POST["synopsis"]) . "', '" . htmlspecialchars($_POST["text"]) . "', " . ($_POST["important"] == "true" ? 1 : 0) . ", {$_user -> _mainId}, " . ($specialty == 0 ? "NULL" : "{$specialty}") . ", " . time() . ");");
                echo json_encode([
                    "status" => "OK",
                    "heading" => $_POST["heading"],
                    "id" => $database -> insert_id,
                ]);
            } else
                echo json_encode([
                    "status" => "SPECIALTY_IS_NOT_FOUND",
                ]);
            $database -> close();
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $_user -> c();
    }
?>
