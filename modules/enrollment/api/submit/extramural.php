<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../../../configurations/database/class.php";
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
        require __DIR__ . "/../../../../configurations/main.php";
        require __DIR__ . "/../../../../configurations/cipher-keys.php";
        $crypt = new cryptService($ciphers["database"]);
        if ($database -> query("SELECT `id` FROM `enr_statements` WHERE `email` = '{$crypt -> encrypt($enrollee_data["email"])}';") -> num_rows == 0) {
            require __DIR__ . "/../../../../configurations/email/class.php";
            require __DIR__ . "/../../../../libraries/files.php";
            require __DIR__ . "/../../../../libraries/petrovich/Petrovich.php";
            $uniqueFolder = md5($enrollee_data["lastname"] . $enrollee_data["email"] . time());
            $file = new files("");
            $check_files = $database -> query("SELECT `id`, `latinName`, `isNessesary`, `forOnline` FROM `enr_attached_docs` WHERE `forExtramural` = 1 AND `forOnline` = 1;");
            if ($check_files -> num_rows != 0) {
                $granted = true;
                $folders = [];
                $attachedDocs = [];
                while ($check_file = $check_files -> fetch_assoc()) {
                    $counter = 0;
                    foreach ($_FILES as $key => $value)
                        if (mb_strpos($key, $check_file["latinName"])) {
                            $folders[$check_file["latinName"]][] = [
                                "_FILE" => $value,
                                "folder" => "{$check_file["latinName"]}",
                                "name" => md5($enrollee_data["email"]) . "-" . $check_file["latinName"] . "-" . explode("-counter-", $key)[1],
                            ];
                            if ($counter == 0)
                                $attachedDocs[] = $check_file["id"];
                            $counter++;
                        }
                    if ($check_file["isNessesary"] == 1 && ($counter == 0 || $counter > 10))
                        $granted = false;
                }
                if ($granted) {
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
                                                    "folder" => $crypt -> encrypt($uniqueFolder),
                                                    "isExtramural" => 1,
                                                    "isOnline" => 1,
                                                    "isChecked" => 0,
                                                    "timestamp" => time()
                                                ];
                                                $files_ids = [];
                                                foreach ($folders as $key => $value) {
                                                    $path = "/enrollment/enrolles/{$uniqueFolder}";
                                                    if ($file -> setPath($path)) {
                                                        $file -> createFolder("/{$key}");
                                                        $file -> setPath($path . "/{$key}");
                                                    }
                                                    else
                                                        break;
                                                    foreach ($value as $piece)
                                                        $files_ids[] = $file -> upload($piece["_FILE"], $piece["name"], false, [1001, 1002]);
                                                }
                                                $filesIsOk = true;
                                                foreach ($files_ids as $value)
                                                    if (!is_numeric($value))
                                                        $filesIsOk = false;
                                                if ($filesIsOk) {
                                                    $sql["attachedDocsIds"] = $crypt -> encrypt(json_encode($files_ids));
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
                                                    if (empty($database -> error)) {
                                                        $college = json_decode(file_get_contents(__DIR__ . "/../../../../configurations/json/about.json")) -> school;
                                                        $mail -> addAddress($enrollee_data["email"]);
                                                        $mail -> Subject = "Подача документов в {$college -> name -> short} онлайн";
                                                        $mail -> Body = "
                                                            <h2>Подача документов в {$college -> name -> short} онлайн</h2>
                                                            <p>Вашему заявлению был присвоен номер: <b><code>{$database -> insert_id}</code></b></p>
                                                            <p>Здравствуйте, {$enrollee_data["firstname"]} {$enrollee_data["patronymic"]}! Вы подали документы в наше образовательное учреждение через сеть Интернет. Теперь Вам нужно дождаться, когда Ваша заявка будет рассмотрена. После рассмотрения заявки Вам придет письмо с подтверждением или же с отказом. Если письмо придет с отказом, то будет указана причина.</p>
                                                            <p>Обращаем Ваше внимание на следующие пункты:</p>
                                                            <ul>
                                                                <li>Подача заявления через сеть Интернет <b>НЕ</b> гарантирует поступление!</li>
                                                                <li>Если Ваше заявление будет одобрено, то нужно будет принести оригинал документа об образовании до <b>{$college -> enrollment -> date}</b>!</li>
                                                                <li>В одобрительном письме Вы получите Заявление. <b>Его нужно будет обязательно распечатать, подписать и приложить подписанное Заявление в личном кабинете. Только после этих действий Вы будете участвовать в Приемной кампании.</b></li>
                                                                <li><b>Заявление обязательно нужно будет сохранить и принести вместе с оригиналом документа об образовании!</b></li>
                                                            </ul>
                                                            <p>Если у Вас остались вопросы, то их можно задать, написав на следующий адрес электронной почты: <a href=\"mailto:{$college -> enrollment -> email}\">{$college -> enrollment -> email}</a>.</p>
                                                            <hr>
                                                            <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>";
                                                        $mail -> send();
                                                        echo json_encode([
                                                            "status" => "OK",
                                                        ]);
                                                    } else {
                                                        foreach ($files_ids as $value)
                                                            if (is_numeric($value))
                                                                $file -> delete($value);
                                                        echo json_encode([
                                                            "status" => "ERRORS_IN_DB",
                                                        ]);
                                                    }
                                                } else {
                                                    foreach ($files_ids as $value)
                                                        if (is_numeric($value))
                                                            $file -> delete($value);
                                                    echo json_encode([
                                                        "status" => "ERRORS_IN_FILES",
                                                        "where" => $files_ids,
                                                    ]);
                                                }
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
                        "status" => "REQUIRED_FILES_ARE_EMPTY",
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
?>
