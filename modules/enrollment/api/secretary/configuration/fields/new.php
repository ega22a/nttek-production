<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../../../../../libraries/users.php";
    if (!empty($_POST["token"])) {
        $users = new user($_POST["token"]);
        if ($users -> _isFound && $users -> check_level(1001)) {
            require __DIR__ . "/../../../../../../configurations/database/class.php";
            switch (strval($_POST["form-type"])) {
                case "specialty":
                    if (!empty($_POST["fullname"]) && !empty($_POST["shortname"]) && !empty($_POST["composite-key"]) && !empty($_POST["budget"]) && !empty($_POST["contract"]) && !empty($_POST["for-extramural"])) {
                        $data = [
                            "name" => $database -> real_escape_string(strval($_POST["fullname"])),
                            "fullname" => $database -> real_escape_string(strval($_POST["fullname"])),
                            "shortname" => $database -> real_escape_string(strval($_POST["shortname"])),
                            "composite-key" => $database -> real_escape_string(strval($_POST["composite-key"])),
                            "budget" => intval($_POST["budget"]),
                            "contract" => intval($_POST["contract"]),
                            "for-extramural" => strtolower(strval($_POST["for-extramural"])) == "true" ? 1 : 0,
                        ];
                        $database -> query("INSERT INTO enr_specialties (`fullname`, `shortname`, `compositeKey`, `budget`, `contract`, `forExtramural`) VALUES ('{$data["fullname"]}', '{$data["shortname"]}', '{$data["composite-key"]}', {$data["budget"]}, {$data["contract"]}, {$data["for-extramural"]});");
                        if (empty($database -> error))
                            echo json_encode([
                                "status" => "OK",
                                "data" => $data + ["id" => $database -> insert_id],
                            ]);
                        else
                            echo json_encode([
                                "status" => $database -> error,
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SOME_DATA_IS_EMPTY",
                        ]);
                break;
                case "educational-levels":
                    if (!empty($_POST["name"]) && !empty($_POST["composite-key"])) {
                        $data = [
                            "name" => $database -> real_escape_string(strval($_POST["name"])),
                            "composite-key" => $database -> real_escape_string(strval($_POST["composite-key"])),
                        ];
                        $database -> query("INSERT INTO enr_education_levels (`name`, `compositeKey`) VALUES ('{$data["name"]}', '{$data["composite-key"]}');");
                        if (empty($database -> error))
                            echo json_encode([
                                "status" => "OK",
                                "data" => $data + ["id" => $database -> insert_id],
                            ]);
                        else
                            echo json_encode([
                                "status" => $database -> error,
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SOME_DATA_IS_EMPTY",
                        ]);
                break;
                case "educational-docs":
                    if (!empty($_POST["name"])) {
                        $data = [
                            "name" => $database -> real_escape_string(strval($_POST["name"])),
                        ];
                        $database -> query("INSERT INTO enr_educational_docs (`name`) VALUES ('{$data["name"]}');");
                        if (empty($database -> error))
                            echo json_encode([
                                "status" => "OK",
                                "data" => $data + ["id" => $database -> insert_id],
                            ]);
                        else
                            echo json_encode([
                                "status" => $database -> error,
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SOME_DATA_IS_EMPTY",
                        ]);
                break;
                case "languages":
                    if (!empty($_POST["name"])) {
                        $data = [
                            "name" => $database -> real_escape_string(strval($_POST["name"])),
                        ];
                        $database -> query("INSERT INTO enr_languages (`name`) VALUES ('{$data["name"]}');");
                        if (empty($database -> error))
                            echo json_encode([
                                "status" => "OK",
                                "data" => $data + ["id" => $database -> insert_id],
                            ]);
                        else
                            echo json_encode([
                                "status" => $database -> error,
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SOME_DATA_IS_EMPTY",
                        ]);
                break;
                case "hostel-rooms":
                    if (!empty($_POST["name"]) && !empty($_POST["price"])) {
                        $data = [
                            "name" => $database -> real_escape_string(strval($_POST["name"])),
                            "price" => floatval($_POST["price"]),
                        ];
                        $database -> query("INSERT INTO enr_hostel_rooms (`name`, `price`) VALUES ('{$data["name"]}', {$data["price"]});");
                        if (empty($database -> error))
                            echo json_encode([
                                "status" => "OK",
                                "data" => $data + ["id" => $database -> insert_id],
                            ]);
                        else
                            echo json_encode([
                                "status" => $database -> error,
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SOME_DATA_IS_EMPTY",
                        ]);
                break;
                case "category-of-citizen":
                    if (!empty($_POST["name"])) {
                        $data = [
                            "name" => $database -> real_escape_string(strval($_POST["name"])),
                        ];
                        $database -> query("INSERT INTO enr_category_of_citizen (`name`) VALUES ('{$data["name"]}');");
                        if (empty($database -> error))
                            echo json_encode([
                                "status" => "OK",
                                "data" => $data + ["id" => $database -> insert_id],
                            ]);
                        else
                            echo json_encode([
                                "status" => $database -> error,
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SOME_DATA_IS_EMPTY",
                        ]);
                break;
                case "attached-docs":
                    if (!empty($_POST["name"]) && !empty($_POST["latin-name"]) && !empty($_POST["is-nessesary"]) && !empty($_POST["for-extramural"]) && !empty($_POST["for-online"])) {
                        $data = [
                            "name" => $database -> real_escape_string(strval($_POST["name"])),
                            "latinName" => $database -> real_escape_string(strval($_POST["latin-name"])),
                            "is-nessesary" => strtolower(strval($_POST["is-nessesary"])) == "true" ? 1 : 0,
                            "for-extramural" => strtolower(strval($_POST["for-extramural"])) == "true" ? 1 : 0,
                            "for-online" => strtolower(strval($_POST["for-online"])) == "true" ? 1 : 0,
                        ];
                        $database -> query("INSERT INTO enr_attached_docs (`name`, `latinName`, `isNessesary`, `forOnline`, `forExtramural`) VALUES ('{$data["name"]}', '{$data["latinName"]}', {$data["is-nessesary"]}, {$data["for-online"]}, {$data["for-extramural"]});");
                        if (empty($database -> error))
                            echo json_encode([
                                "status" => "OK",
                                "data" => $data + ["id" => $database -> insert_id],
                            ]);
                        else
                            echo json_encode([
                                "status" => $database -> error,
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SOME_DATA_IS_EMPTY",
                        ]);
                break;
                case "docs-for-review":
                    if (!empty($_POST["name"]) && !empty($_FILES["pdf-file"])) {
                        require __DIR__ . "/../../../../../../libraries/files.php";
                        $file = new files("/enrollment/docs-for-review");
                        $data = [
                            "name" => $database -> real_escape_string(strval($_POST["name"])),
                            "pdf" => $_FILES["pdf-file"],
                        ];
                        $id = $file -> upload($data["pdf"], $data["name"]);
                        if (is_int($id)) {
                            $database -> query("INSERT INTO `enr_docs_for_review` (`name`, `fileId`) VALUES ('{$data["name"]}', {$id});");
                            if (empty($database -> error))
                                echo json_encode([
                                    "status" => "OK",
                                    "data" => [
                                        "id" => $database -> insert_id,
                                        "name" => $data["name"],
                                        "fileId" => $id,
                                    ]
                                ]);
                            else
                                echo json_encode([
                                    "status" => "DATABASE_ERROR",
                                ]);
                        } else
                            echo json_encode([
                                "status" => $id,
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SOME_DATA_IS_EMPTY",
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
                "status" => "ACCESS_DENIED",
            ]);
        $users -> c();
    } else
        echo json_encode([
            "status" => "NEED_TOKEN",
        ]);
?>