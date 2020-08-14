Д<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../libraries/users.php";
        $_user = new user($_POST["token"]);
        if ($_user -> check_level(1001)) {
            require __DIR__ . "/../../../../../configurations/database/class.php";
            if (isset($_POST["fix"])) {
                switch (intval($_POST["fix"])) {
                    case 1:
                        $database -> query("UPDATE `enr_statements` SET `isChecked` = 1 WHERE `isOnline` = 0 AND `compositeKey` IS NULL AND `averageMark` IS NULL;");
                        echo json_encode([
                            "status" => "OK",
                        ]);
                    break;
                    case 2:
                        $database -> query("UPDATE `enr_statements` SET `withStatement` = 1 WHERE `isOnline` = 1 AND `withOriginalDiploma` = 1;");
                        echo json_encode([
                            "status" => "OK",
                        ]);
                    break;
                    default:
                        echo json_encode([
                            "status" => "WRONG_NUMBER_OF_FIX",
                        ]);
                    break;
                }
            } else
                echo json_encode([
                    "status" => "NUMBER_OF_FIX_DOES_NOT_FOUND",
                ]);
            $database -> close();
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $_user -> c();
    }
?>