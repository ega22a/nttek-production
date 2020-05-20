<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../../../../../libraries/users.php";
    if (!empty($_POST["token"])) {
        $users = new user($_POST["token"]);
        if ($users -> _isFound && $users -> check_level(1001)) {
            if (!empty($_POST["id"]) && !empty($_POST["form-type"])) {
                require __DIR__ . "/../../../../../../configurations/database/class.php";
                $id = intval($database -> real_escape_string($_POST["id"]));
                switch (strval($_POST["form-type"])) {
                    case "specialty":
                        $check_field = $database -> query("SELECT `id` FROM `enr_specialties` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $database -> query("DELETE FROM `enr_specialties` WHERE `id` = {$id};");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                ]);
                            else
                                echo json_encode([
                                    "status" => $database -> error,
                                ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "educational-levels":
                        $check_field = $database -> query("SELECT `id` FROM `enr_education_levels` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $database -> query("DELETE FROM `enr_education_levels` WHERE `id` = {$id};");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                ]);
                            else
                                echo json_encode([
                                    "status" => $database -> error,
                                ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "educational-docs":
                        $check_field = $database -> query("SELECT `id` FROM `enr_educational_docs` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $database -> query("DELETE FROM `enr_educational_docs` WHERE `id` = {$id};");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                ]);
                            else
                                echo json_encode([
                                    "status" => $database -> error,
                                ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "languages":
                        $check_field = $database -> query("SELECT `id` FROM `enr_languages` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $database -> query("DELETE FROM `enr_languages` WHERE `id` = {$id};");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                ]);
                            else
                                echo json_encode([
                                    "status" => $database -> error,
                                ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "hostel-rooms":
                        $check_field = $database -> query("SELECT `id` FROM `enr_hostel_rooms` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $database -> query("DELETE FROM `enr_hostel_rooms` WHERE `id` = {$id};");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                ]);
                            else
                                echo json_encode([
                                    "status" => $database -> error,
                                ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "category-of-citizen":
                        $check_field = $database -> query("SELECT `id` FROM `enr_category_of_citizen` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $database -> query("DELETE FROM `enr_category_of_citizen` WHERE `id` = {$id};");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                ]);
                            else
                                echo json_encode([
                                    "status" => $database -> error,
                                ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "attached-docs":
                        $check_field = $database -> query("SELECT `id` FROM `enr_attached_docs` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $database -> query("DELETE FROM `enr_attached_docs` WHERE `id` = {$id};");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                ]);
                            else
                                echo json_encode([
                                    "status" => $database -> error,
                                ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "docs-for-review":
                        $check_field = $database -> query("SELECT * FROM `enr_docs_for_review` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            require __DIR__ . "/../../../../../../libraries/files.php";
                            $check_field = intval($check_field -> fetch_assoc()["fileId"]);
                            $file = new files("/enrollment/docs-for-review");
                            $database -> query("DELETE FROM `enr_docs_for_review` WHERE `id` = {$id};");
                            if (empty($database -> error)) {
                                $thumb = $file -> delete($check_field);
                                if ($thumb == "OK")
                                    echo json_encode([
                                        "status" => "OK",
                                    ]);
                                else
                                    echo json_encode([
                                        "status" => $thumb,
                                    ]);
                            } else {
                                echo json_encode([
                                    "status" => $database -> error,
                                ]);
                            }
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    default:
                        echo json_encode([
                            "status" => "WRONG_TYPE",
                        ]);
                    break;
                }
                $database -> close();
            } else
                echo json_encode([
                    "status" => "FIELD_DATA_IS_EMPTY",
                ]);
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $users -> c();
    } else
    echo json_encode([
        "status" => "NEED_TOKEN",
    ]);
?>