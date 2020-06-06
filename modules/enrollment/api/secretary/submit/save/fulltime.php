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
                if (in_array($key, ["lastname", "firstname", "sex", "birthday", "telephone", "email", "birth-country", "birth-region", "birth-city", "place-country", "place-region", "region-city", "place-street", "place-house", "place-zip-code", "passport-series", "passport-number", "passport-date", "passport-place", "passport-code", "specialty", "pay", "previous-fullname", "previous-date", "previous-level", "previous-doc-type", "previous-doc-number", "previous-doc-date", "language", "hostel", "category-of-citizen"])) {
                    if (empty($value))
                        $errors_array[] = $key;
                    else {
                        $enrollee_data[$key] = strval($database -> real_escape_string($value));
                        unset($_POST[$key]);
                    }
                }
            }
            if ($_POST["mother-checkbox-do-not-have"] == "true" && $_POST["father-checkbox-do-not-have"] == "true") {
                foreach ($_POST as $key => $value) {
                    if (mb_strpos($key, "representative") !== false && mb_strpos($key, "checkbox") === false) {
                        if ($_POST["representative-checkbox-not-working"] == "true")
                            if (mb_strpos($key, "job") === false) {
                                if (empty($value))
                                    $errors_array[] = $key;
                                else {
                                    $enrollee_data[$key] = strval($database -> real_escape_string($value));
                                    unset($_POST[$key]);
                                }
                        } elseif ($_POST["representative-checkbox-not-working"] == "false") {
                            if (empty($value))
                                $errors_array[] = $key;
                            else {
                                $enrollee_data[$key] = strval($database -> real_escape_string($value));
                                unset($_POST[$key]);
                            }
                        }
                    }
                }
            }
            if ($_POST["mother-checkbox-do-not-have"] == "false") {
                foreach ($_POST as $key => $value) {
                    if (mb_strpos($key, "mother") !== false && mb_strpos($key, "checkbox") === false) {
                        if ($_POST["mother-checkbox-not-working"] == "true") {
                            if (mb_strpos($key, "job") === false)
                                if (empty($value))
                                    $errors_array[] = $key;
                                else {
                                    $enrollee_data[$key] = strval($database -> real_escape_string($value));
                                    unset($_POST[$key]);
                                }
                        } elseif ($_POST["mother-checkbox-not-working"] == "false") {
                            if (empty($value))
                                $errors_array[] = $key;
                            else {
                                $enrollee_data[$key] = strval($database -> real_escape_string($value));
                                unset($_POST[$key]);
                            }
                        }
                    }
                }
            } elseif (!in_array($_POST["mother-checkbox-do-not-have"], ["true", "false"]))
                $errors_array[] = "mother-checkbox-do-not-have";
            unset($_POST["mother-checkbox-do-not-have"]);
            unset($_POST["mother-checkbox-not-working"]);
            if ($_POST["father-checkbox-do-not-have"] == "false") {
                foreach ($_POST as $key => $value) {
                    if (mb_strpos($key, "father") !== false && mb_strpos($key, "checkbox") === false) {
                        if ($_POST["father-checkbox-not-working"] == "true") {
                            if (mb_strpos($key, "job") === false)
                                if (empty($value))
                                    $errors_array[] = $key;
                                else {
                                    $enrollee_data[$key] = strval($database -> real_escape_string($value));
                                    unset($_POST[$key]);
                                }
                        } elseif ($_POST["father-checkbox-not-working"] == "false") {
                            if (empty($value))
                                $errors_array[] = $key;
                            else {
                                $enrollee_data[$key] = strval($database -> real_escape_string($value));
                                unset($_POST[$key]);
                            }
                        }
                    }
                }
            } elseif (!in_array($_POST["father-checkbox-do-not-have"], ["true", "false"]))
                $errors_array[] = "father-checkbox-do-not-have";
            unset($_POST["father-checkbox-do-not-have"]);
            unset($_POST["father-checkbox-not-working"]);
            if ($enrollee_data["hostel"] == "true" && !empty($_POST["hostel-type"])) {
                $enrollee_data["hostel-type"] = $database -> real_escape_string($_POST["hostel-type"]);
                unset($_POST["hostel-type"]);
            } elseif ($enrollee_data["hostel"] == "true" && empty($_POST["hostel-type"]))
                $errors_array[] = "hostel-type";
            elseif ($enrollee_data["hostel"] == "false")
                unset($_POST["hostel-type"]);
            unset($_POST["representative-checkbox-not-working"]);
            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    $enrollee_data[$key] = $database -> real_escape_string($value);
                    unset($_POST[$key]);
                } else
                    unset($_POST[$key]);
            }
            foreach ($errors_array as $key => $value)
                if (in_array($value, ["mother-job-telephone", "father-job-telephone", "representative-job-telephone", "morher-patronymic", "father-patronymic", "representative-patronymic"]))
                    unset($errors_array[$key]);
            if (empty($errors_array)) {
                require_once __DIR__ . "/../../../../../../configurations/main.php";
                require __DIR__ . "/../../../../../../configurations/cipher-keys.php";
                $crypt = new cryptService($ciphers["database"]);
                if ($database -> query("SELECT `id` FROM `enr_statements` WHERE `email` = '{$crypt -> encrypt($enrollee_data["email"])}';") -> num_rows == 0) {
                    $check_files = $database -> query("SELECT `id`, `latinName` FROM `enr_attached_docs` WHERE `forExtramural` = 0;");
                    if ($check_files -> num_rows != 0) {
                        $attachedDocs = [];
                        while ($check_file = $check_files -> fetch_assoc())
                            foreach ($enrollee_data as $key => $value)
                                if ("file-{$check_file["latinName"]}" == $key && $value == "true")
                                    $attachedDocs[] = $check_file["id"];
                        if ($enrollee_data["sex"] == "1" || $enrollee_data["sex"] == "2") {
                            if ($database -> query("SELECT `id` FROM `enr_specialties` WHERE `id` = {$enrollee_data["specialty"]} AND `forExtramural` = 0;") -> num_rows == 1) {
                                if ($enrollee_data["pay"] == "1" || $enrollee_data["pay"] == "2") {
                                    if ($database -> query("SELECT `id` FROM `enr_education_levels` WHERE `id` = {$enrollee_data["previous-level"]};") -> num_rows == 1) {
                                        if ($database -> query("SELECT `id` FROM `enr_educational_docs` WHERE `id` = {$enrollee_data["previous-doc-type"]};") -> num_rows == 1) {
                                            if ($database -> query("SELECT `id` FROM `enr_languages` WHERE `id` = {$enrollee_data["language"]};") -> num_rows == 1) {
                                                if ($database -> query("SELECT `id` FROM `enr_category_of_citizen` WHERE `id` = {$enrollee_data["category-of-citizen"]};") -> num_rows == 1 || $enrollee_data["category-of-citizen"] == -1) {
                                                    $hostel = true;
                                                    if ($enrollee_data["hostel"] == "true")
                                                        if ($database -> query($database -> query("SELECT `id` FROM `enr_hostel_rooms` WHERE `id` = {$enrollee_data["category-of-citizen"]};") -> num_rows == 0))
                                                            $hostel == false;
                                                    if ($hostel) {
                                                        $hostel_number = $database -> query("SELECT `hostelNumber` FROM `enr_statements` ORDER BY `hostelNumber` DESC LIMIT 1");
                                                        if ($hostel_number -> num_rows != 0) {
                                                            $hostel_number = $hostel_number -> fetch_assoc()["hostelNumber"];
                                                            if (is_int($hostel_number))
                                                                $hostel_number = intval($hostel_number) + 1;
                                                            else
                                                                $hostel_number = 1;
                                                        } else
                                                            $hostel_number = 1;
                                                        $sql = [
                                                            "lastname" => $crypt -> encrypt($enrollee_data["lastname"]),
                                                            "firstname" => $crypt -> encrypt($enrollee_data["firstname"]),
                                                            "patronymic" => isset($enrollee_data["patronymic"]) ? $crypt -> encrypt($enrollee_data["patronymic"]) : NULL,
                                                            "sex" => intval($enrollee_data["sex"]),
                                                            "educationalType" => "fulltime",
                                                            "specialty" => intval($enrollee_data["specialty"]),
                                                            "address" => $crypt -> encrypt(json_encode([
                                                                "zipCode" => $enrollee_data["place-zip-code"],
                                                                "country" => $enrollee_data["place-country"],
                                                                "region" => $enrollee_data["place-region"],
                                                                "city" => $enrollee_data["place-city"],
                                                                "street" => $enrollee_data["place-street"],
                                                                "house" => $enrollee_data["place-house"],
                                                                "building" => isset($enrollee_data["place-building"]) ? isset($enrollee_data["place-building"]) : NULL,
                                                                "flat" => isset($enrollee_data["place-flat"]) ? isset($enrollee_data["place-flat"]) : NULL,
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
                                                            "hostel" => $enrollee_data["hostel"] == "true" ? 1 : 0,
                                                            "hostelRoom" => $enrollee_data["hostel"] == "true" ? intval($enrollee_data["hostel-type"]) : NULL,
                                                            "hostelNumber" => $enrollee_data["hostel"] == "true" ? $hostel_number : NULL,
                                                            "category" => $enrollee_data["category-of-citizen"] != "-1" ? intval($enrollee_data["category-of-citizen"]) : NULL,
                                                            "about" => isset($enrollee_data["about"]) ? $crypt -> encrypt($enrollee_data["about"]) : NULL,
                                                            "mother" => isset($enrollee_data["mother-lastname"]) ? $crypt -> encrypt(json_encode([
                                                                "firstname" => $enrollee_data["mother-firstname"],
                                                                "lastname" => $enrollee_data["mother-lastname"],
                                                                "patronymic" => isset($enrollee_data["mother-patronymic"]) ? $enrollee_data["mother-patronymic"] : NULL,
                                                                "jobName" => isset($enrollee_data["mother-job-name"]) ? $enrollee_data["mother-job-name"] : NULL,
                                                                "jobPosition" => isset($enrollee_data["mother-job-position"]) ? $enrollee_data["mother-job-position"] : NULL,
                                                                "jobTelephone" => isset($enrollee_data["mother-job-telephone"]) ? $enrollee_data["mother-job-telephone"] : NULL,
                                                                "telephone" => $enrollee_data["mother-telephone"],
                                                            ])) : NULL,
                                                            "father" => isset($enrollee_data["father-lastname"]) ? $crypt -> encrypt(json_encode([
                                                                "firstname" => $enrollee_data["father-firstname"],
                                                                "lastname" => $enrollee_data["father-lastname"],
                                                                "patronymic" => isset($enrollee_data["father-patronymic"]) ? $enrollee_data["father-patronymic"] : NULL,
                                                                "jobName" => isset($enrollee_data["father-job-name"]) ? $enrollee_data["father-job-name"] : NULL,
                                                                "jobPosition" => isset($enrollee_data["father-job-position"]) ? $enrollee_data["father-job-position"] : NULL,
                                                                "jobTelephone" => isset($enrollee_data["father-job-telephone"]) ? $enrollee_data["father-job-telephone"] : NULL,
                                                                "telephone" => $enrollee_data["father-telephone"],
                                                            ])) : NULL,
                                                            "representative" => isset($enrollee_data["representative-lastname"]) ? $crypt -> encrypt(json_encode([
                                                                "firstname" => $enrollee_data["representative-firstname"],
                                                                "lastname" => $enrollee_data["representative-lastname"],
                                                                "patronymic" => isset($enrollee_data["representative-patronymic"]) ? $enrollee_data["representative-patronymic"] : NULL,
                                                                "jobName" => isset($enrollee_data["representative-job-name"]) ? $enrollee_data["representative-job-name"] : NULL,
                                                                "jobPosition" => isset($enrollee_data["representative-job-position"]) ? $enrollee_data["representative-job-position"] : NULL,
                                                                "jobTelephone" => isset($enrollee_data["representative-job-telephone"]) ? $enrollee_data["representative-job-telephone"] : NULL,
                                                                "telephone" => $enrollee_data["representative-telephone"],
                                                                "who" => $enrollee_data["representative-who"],
                                                            ])) : NULL,
                                                            "attachedDocs" => $crypt -> encrypt(json_encode($attachedDocs)),
                                                            "isExtramural" => 0,
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
                                                            "status" => "HOSTEL_ROOM_IS_NOT_FOUND",
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