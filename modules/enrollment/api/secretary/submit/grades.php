<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["id"])) {
            require __DIR__ . "/../../../../../libraries/users.php";
            $_user = new user($_POST["token"]);
            if ($_user -> check_level(1001) || $_user -> check_level(1002)) {
                if (!empty($_POST["grades"])) {
                    $granted = true;
                    $grades = [];
                    foreach (str_split($_POST["grades"]) as $value)
                        if (in_array(intval($value), [3, 4, 5]))
                            $grades[] = intval($value);
                        else
                            $granted = false;
                    if ($granted) {
                        require __DIR__ . "/../../../../../configurations/database/class.php";
                        $id = intval($_POST["id"]);
                        if ($database -> query("SELECT `id` FROM `enr_statements` WHERE `id` = {$id} AND `averageMark` IS NULL;") -> num_rows == 1) {
                            $average = round(array_sum($grades) / count($grades), 2);
                            $database -> query("UPDATE `enr_statements` SET `averageMark` = {$average} WHERE `id` = {$id};");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                ]);
                            else
                                echo json_encode([
                                    "status" => "DB_ERROR",
                                ]);
                        } else
                            echo json_encode([
                                "status" => "ENROLLEE_IS_NOT_FOUND",
                            ]);
                        $database -> close();
                    } else
                        echo json_encode([
                            "status" => "NOT_GRANTED_GRADES",
                        ]);
                } else
                    echo json_encode([
                        "status" => "GRADES_ARE_NOT_FOUND",
                    ]);
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
        } else
            echo json_encode([
                "status" => "ID_IS_EMPTY",
            ]);
    }
?>
