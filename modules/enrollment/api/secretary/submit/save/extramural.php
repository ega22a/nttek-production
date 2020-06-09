<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../../../libraries/users.php";
        $_user = new user($_POST["token"]);
        if ($_user -> check_level(1001) || $_user -> check_level(1002)) {
            require __DIR__ . "/../../../../../../configurations/database/class.php";
            $enrollee_data = [];
            $errors_array = [];
            foreach ($_POST as $key => $value) {
                if (in_array($key, ["lastname", "firstname", "sex", "birthday", "telephone", "email", "birth-country", "birth-region", "birth-city", "place-country", "place-region", "region-city", "place-street", "place-house", "place-zip-code", "passport-series", "passport-number", "passport-date", "passport-place", "passport-code", "specialty", "pay", "previous-fullname", "previous-date", "previous-level", "previous-doc-type", "previous-doc-number", "previous-doc-date", "language", "category-of-citizen"])) {
                    if (empty($value))
                        $errors_array[] = $key;
                    else {
                        $enrollee_data[$key] = strval($database -> real_escape_string($value));
                        unset($_POST[$key]);
                    }
                }
            }
            if ($_POST["checkbox-not-working"] == "false") {
                foreach($_POST as $key => $value)
                    if (mb_strpos($key, "job") !== false) {
                        if (empty($value))
                            $errors_array[] = $key;
                        else {
                            $enrollee_data[$key] = strval($database -> real_escape_string($value));
                            unset($_POST[$key]);
                        }
                    }
            } elseif (!in_array($_POST["checkbox-not-working"], ["true", "false"]))
                $errors_array[] = "checkbox-not-working";
            unset($_POST["checkbox-not-working"]);
            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    $enrollee_data[$key] = $database -> real_escape_string($value);
                    unset($_POST[$key]);
                } else
                    unset($_POST[$key]);
            }
            if (empty($errors_array)) {
                require_once __DIR__ . "/../../../../../../configurations/main.php";
                require __DIR__ . "/../../../../../../configurations/cipher-keys.php";
                $crypt = new cryptService($ciphers["database"]);
                if ($database -> query("SELECT `id` FROM `enr_statements` WHERE `email` = '{$crypt -> encrypt($enrollee_data["email"])}';") -> num_rows == 0) {
                    $check_files = $database -> query("SELECT `id`, `latinName`, `isNessesary`, `forOnline` FROM `enr_attached_docs` WHERE `forExtramural` = 1;");
                    if ($check_files -> num_rows != 0) {
                        $attachedDocs = [];
                        while ($check_file = $check_files -> fetch_assoc())
                            foreach ($enrollee_data as $key => $value)
                                if ("file-{$check_file["latinName"]}" == $key && $value == "true")
                                    $attachedDocs[] = $check_file["id"];
                        if ($enrollee_data["sex"] == "1" || $enrollee_data["sex"] == "2") {
                            if ($database -> query("SELECT `id` FROM `enr_specialties` WHERE `id` = {$enrollee_data["specialty"]} AND `forExtramural` = 1;") -> num_rows == 1) {
                                if ($enrollee_data["pay"] == "1" || $enrollee_data["pay"] == "2") {
                                    if ($database -> query("SELECT `id` FROM `enr_education_levels` WHERE `id` = {$enrollee_data["previous-level"]};") -> num_rows == 1) {
                                        if ($database -> query("SELECT `id` FROM `enr_educational_docs` WHERE `id` = {$enrollee_data["previous-doc-type"]};") -> num_rows == 1) {
                                            if ($database -> query("SELECT `id` FROM `enr_languages` WHERE `id` = {$enrollee_data["language"]};") -> num_rows == 1) {
                                                if ($database -> query("SELECT `id` FROM `enr_category_of_citizen` WHERE `id` = {$enrollee_data["category-of-citizen"]};") -> num_rows == 1 || $enrollee_data["category-of-citizen"] == -1) {
                                                    foreach ($enrollee_data as $enr_key => $enr_value)
                                                        if (is_string($enr_value))
                                                            $enrollee_data[$enr_key] = trim($enr_value);
                                                    $sql = [
                                                        "lastname" => $crypt -> encrypt($enrollee_data["lastname"]),
                                                        "firstname" => $crypt -> encrypt($enrollee_data["firstname"]),
                                                        "patronymic" => isset($enrollee_data["patronymic"]) ? $crypt -> encrypt($enrollee_data["patronymic"]) : NULL,
                                                        "sex" => intval($enrollee_data["sex"]),
                                                        "educationalType" => "extramural",
                                                        "specialty" => intval($enrollee_data["specialty"]),
                                                        "address" => $crypt -> encrypt(json_encode([
                                                            "zipCode" => $enrollee_data["place-zip-code"],
                                                            "country" => $enrollee_data["place-country"],
                                                            "region" => $enrollee_data["place-region"],
                                                            "city" => $enrollee_data["place-city"],
                                                            "street" => $enrollee_data["place-street"],
                                                            "house" => $enrollee_data["place-house"],
                                                            "building" => isset($enrollee_data["place-building"]) ? $enrollee_data["place-building"] : NULL,
                                                            "flat" => isset($enrollee_data["place-flat"]) ? $enrollee_data["place-flat"] : NULL,
                                                        ])),
                                                        "telephone" => $crypt -> encrypt($enrollee_data["telephone"]),
                                                        "homeTelephone" => isset($enrollee_data["home-telephone"]) ? $crypt -> encrypt($enrollee_data["home-telephone"]) : NULL,
                                                        "email" => $crypt -> encrypt($enrollee_data["email"]),
                                                        "paysType" => intval($enrollee_data["pay"]),
                                                        "birthday" => $crypt -> encrypt($enrollee_data["birthday"]),
                                                        "birthplace" => $crypt -> encrypt(json_encode([
                                                            "country" => $enrollee_data["birth-country"],
                                                            "region" => $enrollee_data["birth-region"],
                                                            "city" => $enrollee_data["birth-city"],
                                                        ])),
                                                        "passport" => $crypt -> encrypt(json_encode([
                                                            "series" => $enrollee_data["passport-series"],
                                                            "number" => $enrollee_data["passport-number"],
                                                            "date" => $enrollee_data["passport-date"],
                                                            "place" => $enrollee_data["passport-place"],
                                                            "code" => $enrollee_data["passport-code"],
                                                        ])),
                                                        "previousSchool" => $crypt -> encrypt($enrollee_data["previous-fullname"]),
                                                        "previousSchoolDate" => $crypt -> encrypt($enrollee_data["previous-date"]),
                                                        "degree" => intval($enrollee_data["previous-level"]),
                                                        "previousSchoolDoc" => intval($enrollee_data["previous-doc-type"]),
                                                        "previousSchoolDocData" => $crypt -> encrypt(json_encode([
                                                            "series" => isset($enrollee_data["previous-doc-series"]) ? $enrollee_data["previous-doc-series"] : "-",
                                                            "number" => $enrollee_data["previous-doc-number"],
                                                            "date" => $enrollee_data["previous-doc-date"],
                                                        ])),
                                                        "language" => intval($enrollee_data["language"]),
                                                        "category" => $enrollee_data["category-of-citizen"] != "-1" ? intval($enrollee_data["category-of-citizen"]) : NULL,
                                                        "about" => isset($enrollee_data["about"]) ? $crypt -> encrypt($enrollee_data["about"]) : NULL,
                                                        "work" => isset($enrollee_data["job-name"]) ? $crypt -> encrypt($enrollee_data["job-name"]) : NULL,
                                                        "position" => isset($enrollee_data["job-position"]) ? $crypt -> encrypt($enrollee_data["job-position"]) : NULL,
                                                        "workExpirence" => isset($enrollee_data["job-years"]) ? $crypt -> encrypt($enrollee_data["job-years"]) : NULL,
                                                        "attachedDocs" => $crypt -> encrypt(json_encode($attachedDocs)),
                                                        "isExtramural" => 1,
                                                        "isOnline" => 0,
                                                        "isChecked" => 0,
                                                        "withStatement" => 1,
                                                        "withOriginalDiploma" => $enrollee_data["original-diploma"] == "true" ? 1 : 0,
                                                        "timestamp" => time()
                                                    ];
                                                    $insert_sql = [
                                                        "names" => "",
                                                        "values" => "",
                                                    ];
                                                    foreach ($sql as $key => $value) {
                                                        $insert_sql["names"] .= "`{$key}`, ";
                                                        if (is_string($value))
                                                            $insert_sql["values"] .= "'{$value}', ";
                                                        elseif (is_null($value))
                                                            $insert_sql["values"] .= "NULL, ";
                                                        else
                                                            $insert_sql["values"] .= "{$value}, ";
                                                    }
                                                    $insert_sql["names"] = substr($insert_sql["names"], 0, -2);
                                                    $insert_sql["values"] = substr($insert_sql["values"], 0, -2);
                                                    $database -> query("INSERT INTO `enr_statements` ({$insert_sql["names"]}) VALUES ({$insert_sql["values"]});");
                                                    if (empty($database -> error))
                                                        echo json_encode([
                                                            "status" => "OK",
                                                            "id" => $database -> insert_id,
                                                        ]);
                                                    else
                                                        echo json_encode([
                                                            "status" => "ERRORS_IN_DB",
                                                        ]);
                                                } else
                                                    echo json_encode([
                                                        "status" => "CATEGORY_OF_CITIZEN_IS_NOT_FOUND"
                                                    ]);
                                            } else
                                                echo json_encode([
                                                    "status" => "LANGUAGE_IS_NOT_FOUND",
                                                ]);
                                        } else
                                            echo json_encode([
                                                "status" => "EDUCATIONAL_DOC_IS_NOT_FOUND",
                                            ]);
                                    } else
                                        echo json_encode([
                                            "status" => "EDUCATIONAL_LEVEL_IS_NOT_FOUND",
                                        ]);
                                } else
                                    echo json_encode([
                                        "status" => "TYPE_OF_PAY_CAN_ONLY_BY_1_OR_2",
                                    ]);
                            } else
                                echo json_encode([
                                    "status" => "SPECIALTY_IS_NOT_FOUND",
                                ]);
                        } else
                            echo json_encode([
                                "status" => "SEX_CAN_ONLY_BE_1_OR_2",
                            ]);
                    } else
                        echo json_encode([
                            "status" => "FILE_LIST_IS_EMPTY",
                        ]);
                } else
                    echo json_encode([
                        "status" => "EMAIL_IS_HOLD",
                    ]);
            } else
                echo json_encode([
                    "status" => "ERRORS_IN_DATA",
                    "where" => $errors_array,
                ]);
            $database -> close();
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $_user -> c();
    }
?>