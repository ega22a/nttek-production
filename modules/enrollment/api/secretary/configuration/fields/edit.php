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
                        $check_field = $database -> query("SELECT * FROM `enr_specialties` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $check_field = $check_field -> fetch_assoc();
                            $sql = "";
                            if (!empty($_POST["fullname"]))
                                $sql .= "`fullname` = '{$database -> real_escape_string(strval($_POST["fullname"]))}', ";
                            if (!empty($_POST["shortname"]))
                                $sql .= "`shortname` = '{$database -> real_escape_string(strval($_POST["shortname"]))}', ";
                            if (!empty($_POST["composite-key"]))
                                $sql .= "`compositeKey` = '{$database -> real_escape_string(strval($_POST["composite-key"]))}', ";
                            if (!empty($_POST["budget"])) {
                                $thumb = intval($_POST["budget"]);
                                $sql .= "`budget` = {$thumb}, ";
                            }
                            if (!empty($_POST["contract"])) {
                                $thumb = intval($_POST["contract"]);
                                $sql .= "`contract` = {$thumb}, ";
                            }
                            if (!empty($_POST["for-extramural"])) {
                                $thumb = strtolower(strval($_POST["for-extramural"])) == "true" ? 1 : 0;
                                $sql .= "`forExtramural` = $thumb, ";
                            }
                            if (!empty($sql)) {
                                $sql = substr($sql, 0, -2);
                                $database -> query("UPDATE `enr_specialties` SET {$sql} WHERE `id` = {$id};");
                            }
                            echo json_encode([
                                "status" => "OK",
                                "data" => [
                                    "id" => $id,
                                    "name" => !empty($_POST["fullname"]) ? $_POST["fullname"] : $check_field["fullname"],
                                    "fullname" => !empty($_POST["fullname"]) ? $_POST["fullname"] : $check_field["fullname"],
                                    "shortname" => !empty($_POST["shortname"]) ? $_POST["shortname"] : $check_field["shortname"],
                                    "composite-key" => !empty($_POST["composite-key"]) ? $_POST["composite-key"] : $check_field["compositeKey"],
                                    "budget" => !empty($_POST["budget"]) ? $_POST["budget"] : $check_field["budget"],
                                    "contract" => !empty($_POST["contract"]) ? $_POST["contract"] : $check_field["contract"],
                                    "for-extramural" => !empty($_POST["for-extramural"]) ? strtolower(strval($_POST["for-extramural"])) == "true" ? 1 : 0 : $check_field["forExtramural"],
                                ],
                            ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "educational-levels":
                        $check_field = $database -> query("SELECT * FROM `enr_education_levels` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $check_field = $check_field -> fetch_assoc();
                            $sql = "";
                            if (!empty($_POST["name"]))
                                $sql .= "`name` = '{$database -> real_escape_string(strval($_POST["name"]))}', ";
                            if (!empty($_POST["composite-key"]))
                                $sql .= "`compositeKey` = '{$database -> real_escape_string(strval($_POST["composite-key"]))}', ";
                            if (!empty($sql)) {
                                $sql = substr($sql, 0, -2);
                                $database -> query("UPDATE `enr_education_levels` SET {$sql} WHERE `id` = {$id};");
                            }
                            echo json_encode([
                                "status" => "OK",
                                "data" => [
                                    "id" => $id,
                                    "name" => !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"],
                                    "composite-key" => !empty($_POST["composite-key"]) ? $_POST["composite-key"] : $check_field["compositeKey"],
                                ],
                            ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "educational-docs":
                        $check_field = $database -> query("SELECT * FROM `enr_educational_docs` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $check_field = $check_field -> fetch_assoc();
                            $sql = "";
                            if (!empty($_POST["name"]))
                                $sql .= "`name` = '{$database -> real_escape_string(strval($_POST["name"]))}'";
                            if (!empty($sql))
                                $database -> query("UPDATE `enr_educational_docs` SET {$sql} WHERE `id` = {$id};");
                            echo json_encode([
                                "status" => "OK",
                                "data" => [
                                    "id" => $id,
                                    "name" => !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"],
                                ],
                            ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "languages":
                        $check_field = $database -> query("SELECT * FROM `enr_languages` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $check_field = $check_field -> fetch_assoc();
                            $sql = "";
                            if (!empty($_POST["name"]))
                                $sql .= "`name` = '{$database -> real_escape_string(strval($_POST["name"]))}'";
                            if (!empty($sql))
                                $database -> query("UPDATE `enr_languages` SET {$sql} WHERE `id` = {$id};");
                            echo json_encode([
                                "status" => "OK",
                                "data" => [
                                    "id" => $id,
                                    "name" => !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"],
                                ],
                            ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "hostel-rooms":
                        $check_field = $database -> query("SELECT * FROM `enr_hostel_rooms` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $check_field = $check_field -> fetch_assoc();
                            $sql = "";
                            if (!empty($_POST["name"]))
                                $sql .= "`name` = '{$database -> real_escape_string(strval($_POST["name"]))}', ";
                            if (!empty($_POST["price"])) {
                                $thumb = floatval($_POST["price"]);
                                $sql .= "`price` = $thumb, ";
                            }
                            if (!empty($sql)) {
                                $sql = substr($sql, 0, -2);
                                $database -> query("UPDATE `enr_hostel_rooms` SET {$sql} WHERE `id` = {$id};");
                            }
                            echo json_encode([
                                "status" => "OK",
                                "data" => [
                                    "id" => $id,
                                    "name" => !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"],
                                    "price" => !empty($_POST["price"]) ? floatval($_POST["price"]) : $check_field["price"],
                                ],
                            ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "category-of-citizen":
                        $check_field = $database -> query("SELECT * FROM `enr_category_of_citizen` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $check_field = $check_field -> fetch_assoc();
                            $sql = "";
                            if (!empty($_POST["name"]))
                                $sql .= "`name` = '{$database -> real_escape_string(strval($_POST["name"]))}'";
                            if (!empty($sql))
                                $database -> query("UPDATE `enr_category_of_citizen` SET {$sql} WHERE `id` = {$id};");
                            echo json_encode([
                                "status" => "OK",
                                "data" => [
                                    "id" => $id,
                                    "name" => !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"],
                                ],
                            ]);
                        } else
                            echo json_encode([
                                "status" => "FIELD_DOES_NOT_FOUND",
                            ]);
                    break;
                    case "attached-docs":
                        $check_field = $database -> query("SELECT * FROM `enr_attached_docs` WHERE `id` = {$id};");
                        if ($check_field -> num_rows != 0) {
                            $check_field = $check_field -> fetch_assoc();
                            $sql = "";
                            if (!empty($_POST["name"]))
                                $sql .= "`name` = '{$database -> real_escape_string(strval($_POST["name"]))}', ";
                            if (!empty($_POST["latin-name"]))
                                $sql .= "`latinName` = '{$database -> real_escape_string(strval($_POST["latin-name"]))}', ";
                            if (!empty($_POST["is-nessesary"])) {
                                $thumb = strtolower(strval($_POST["is-nessesary"])) == "true" ? 1 : 0;
                                $sql .= "`isNessesary` = $thumb, ";
                            }
                            if (!empty($_POST["for-extramural"])) {
                                $thumb = strtolower(strval($_POST["for-extramural"])) == "true" ? 1 : 0;
                                $sql .= "`forExtramural` = $thumb, ";
                            }
                            if (!empty($_POST["for-online"])) {
                                $thumb = strtolower(strval($_POST["for-online"])) == "true" ? 1 : 0;
                                $sql .= "`forOnline` = $thumb, ";
                            }
                            if (!empty($sql)) {
                                $sql = substr($sql, 0, -2);
                                $database -> query("UPDATE `enr_attached_docs` SET {$sql} WHERE `id` = {$id};");
                            }
                            echo json_encode([
                                "status" => "OK",
                                "data" => [
                                    "id" => $id,
                                    "name" => !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"],
                                    "latin-name" => !empty($_POST["latin-name"]) ? $_POST["latin-name"] : $check_field["latinName"],
                                    "is-nessesary" => !empty($_POST["is-nessesary"]) ? strtolower(strval($_POST["is-nessesary"])) == "true" ? 1 : 0 : $check_field["isNessesary"],
                                    "for-extramural" => !empty($_POST["for-extramural"]) ? strtolower(strval($_POST["for-extramural"])) == "true" ? 1 : 0 : $check_field["forExtramural"],
                                    "for-online" => !empty($_POST["for-online"]) ? strtolower(strval($_POST["for-online"])) == "true" ? 1 : 0 : $check_field["forOnline"],
                                ],
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
                            $file = new files("/enrollment/docs-for-review");
                            $check_field = $check_field -> fetch_assoc();
                            $sql = "";
                            if (!empty($_POST["name"]))
                                $sql .= "`name` = '{$database -> real_escape_string(strval($_POST["name"]))}'";
                            if (!empty($_FILES["pdf-file"])) {
                                $thumb = $file -> update(intval($check_field["fileId"]), $_FILES["pdf-file"], !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"]);
                                if (!empty($sql))
                                    $database -> query("UPDATE `enr_docs_for_review` SET {$sql} WHERE `id` = {$id};");
                                echo json_encode([
                                    "status" => "OK",
                                    "data" => [
                                        "id" => $id,
                                        "name" => !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"],
                                        "fileId" => $check_field["fileId"],
                                    ],
                                ]);
                            } else {
                                if (!empty($sql))
                                    $database -> query("UPDATE `enr_docs_for_review` SET {$sql} WHERE `id` = {$id};");
                                echo json_encode([
                                    "status" => "OK",
                                    "data" => [
                                        "id" => $id,
                                        "name" => !empty($_POST["name"]) ? $_POST["name"] : $check_field["name"],
                                        "fileId" => $check_field["fileId"],
                                    ],
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