<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../../libraries/users.php";
        $_user = new user($_POST["token"]);
        if ($_user -> check_level(1001)) {
            require __DIR__ . "/../../../../../../configurations/database/class.php";
            $database -> query("INSERT INTO `enr_news` (`heading`, `synopsis`, `mainText`, `isImportant`, `author`, `timestamp`) VALUES ('" . addslashes($_POST["heading"]) . "', '" . addslashes($_POST["synopsis"]) . "', '" . htmlspecialchars($_POST["text"]) . "', " . ($_POST["important"] == "true" ? 1 : 0) . ", {$_user -> _mainId}, " . time() . ");");
            echo json_encode([
                "status" => "OK",
                "heading" => $_POST["heading"],
                "id" => $database -> insert_id,
            ]);
            $database -> close();
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $_user -> c();
    }
?>
