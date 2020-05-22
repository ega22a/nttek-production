<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["statement"])) {
            require __DIR__ . "/../../../../../libraries/users.php";
            $user = new user($_POST["token"]);
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                $_statement_id = intval($_POST["statement"]);
                require __DIR__ . "/../../../../../configurations/database/class.php";
                $_statement = $database -> query("SELECT * FROM `enr_statements` WHERE `id` = {$_statement_id} AND `usersId` IS NOT NULL;");
                if ($_statement -> num_rows == 1) {
                    $_statement = $_statement -> fetch_assoc();
                    require __DIR__ . "/../../../../../configurations/cipher-keys.php";
                    require __DIR__ . "/../../../php/docs.php";
                    $crypt = new CryptService($ciphers["database"]);
                    $sql = "";
                    require __DIR__ . "/../../../../../libraries/files.php";
                    $files = new files("");
                    $files_ids = !empty($_statement["attachedDocsIds"]) ? json_decode($crypt -> decrypt($_statement["attachedDocsIds"])) : [];
                    $check_files = $database -> query("SELECT `id`, `latinName` FROM `enr_attached_docs` WHERE `forExtramural` = " . (boolval($_statement["isExtramural"]) ? "1" : "0") . ";");
                    if ($check_files -> num_rows != 0) {
                        $folders = [];
                        $attachedDocs = [];
                        $check_files_ids = [];
                        while ($check_file = $check_files -> fetch_assoc()) {
                            foreach ($_FILES as $key => $value)
                                if (mb_strpos($key, $check_file["latinName"]) && $_POST["checkbox-{$check_file["latinName"]}"] == "true")
                                    $folders[$check_file["latinName"]][] = [
                                        "_FILE" => $value,
                                        "folder" => "{$check_file["latinName"]}",
                                        "name" => md5($_statement["email"]) . "-" . $check_file["latinName"] . "-" . explode("-counter-", $key)[1],
                                    ];
                            if (isset($_POST["checkbox-{$check_file["latinName"]}"]))
                                $check_files_ids[$check_file["id"]] = $_POST["checkbox-{$check_file["latinName"]}"] == "true" ? true : false;
                        }
                        if (!empty($folders) && !empty($_statement["attachedDocsIds"])) {
                            $attachedDocsIds = json_decode($crypt -> decrypt($_statement["attachedDocsIds"]));
                            $newFiles = [];
                            $erased_files = [];
                            foreach ($folders as $key => $value) {
                                $path = "/enrollment/enrolles/{$crypt -> decrypt($_statement["folder"])}";
                                if ($files -> setPath($path)) {
                                    $files -> createFolder("/{$key}");
                                    $files -> setPath($path . "/{$key}");
                                }
                                foreach ($value as $piece)
                                    $newFiles[] = $files -> upload($piece["_FILE"], $piece["name"], false, [1001, 1002]);
                                $filesIsOk = true;
                                foreach ($newFiles as $_sub_value)
                                    if (!is_numeric($_sub_value))
                                        $filesIsOk = false;
                                if ($filesIsOk)
                                    foreach ($attachedDocsIds as $_sub_key => $_sub_value) {
                                        $file = $files -> get(intval($_sub_value), 1001);
                                        $parsed_path = explode("/", explode("enrollment/enrolles/", $file["path"])[1]);
                                        if (mb_strpos($parsed_path[1], $key) !== false) {
                                            $files -> delete(intval($_sub_value));
                                            $erased_files[] = $_sub_value;
                                        }
                                    }
                                else {
                                    foreach ($newFiles as $_sub_value)
                                        if (is_numeric($_sub_value))
                                            $files -> delete(intval($_sub_value));
                                    echo json_encode([
                                        "status" => "ERRORS_IN_FILES",
                                    ]);
                                    exit;
                                }
                            }
                            $non_erased_files = [];
                            foreach ($attachedDocsIds as $value)
                                if (!in_array($value, $erased_files))
                                    $non_erased_files[] = $value;
                            $newFiles = array_merge($newFiles, $non_erased_files);
                            $newAttachedDocs = [];
                            foreach ($check_files_ids as $key => $value) {
                                if ($value)
                                    $newAttachedDocs[] = $key;
                                else {
                                    $_third_new_files = [];
                                    $what_delete = $database -> query("SELECT `latinName` FROM `enr_attached_docs` WHERE `id` = {$key};") -> fetch_assoc()["latinName"];
                                    foreach ($newFiles as $_sub_value) {
                                        $file = $files -> get(intval($_sub_value), 1001);
                                        $parsed_path = explode("/", explode("enrollment/enrolles/", $file["path"])[1]);
                                        if (mb_strpos($parsed_path[1], $what_delete) !== false)
                                            $files -> delete(intval($_sub_value));
                                        else
                                            $_third_new_files[] = $_sub_value;
                                    }
                                    $newFiles = $_third_new_files;
                                }
                            }
                            $sql .= "`attachedDocsIds` = '{$crypt -> encrypt(json_encode($newFiles))}', `attachedDocs` = '{$crypt -> encrypt(json_encode($newAttachedDocs))}', `withOriginalDiploma` = " . ($_POST["checkbox-original-diploma"] == "true" ? "1" : "0");
                            $database -> query("UPDATE `enr_statements` SET {$sql} WHERE `id` = {$_statement_id};");
                            if (boolval($_statement["isOnline"])) {
                                require __DIR__ . "/../../../../../configurations/email/class.php";
                                $key = [
                                    "specialty" => $database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$_statement["specialty"]}") -> fetch_assoc()["compositeKey"],
                                    "level" => $database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$_statement["degree"]}") -> fetch_assoc()["compositeKey"],
                                    "count" => $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$_statement["id"]}") -> fetch_assoc()["compositeKey"],
                                    "year" => Date("Y", $_statement["timestamp"]),
                                ];
                                $mail -> addAddress($crypt -> decrypt($_statement["email"]));
                                $college = json_decode(file_get_contents(__DIR__ . "/../../../../../configurations/json/about.json"));
                                $mail -> Subject = "Подача документов в {$college -> school -> name -> short} онлайн";
                                $body = "
                                    <h2>Подача документов в {$college -> school -> name -> short} онлайн</h2>
                                    <p>Здравствуйте, {$crypt -> decrypt($_statement["firstname"])} {$crypt -> decrypt($_statement["patronymic"])}!</p>
                                    <p>У вас изменился список прилагаемых файлов! В <a href=\"https://{$college -> address}/login\">личном кабинете</a> Вы можете ознакомиться со списком.</p>
                                    <p>Вашему личному делу был присвоен следующий номер: <b><code>{$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$_statement_id})</code></b>.</p>
                                    <p>Также, не забывайте, что зачисление в образовательное учреждение происходит при условии, что у вы подали оригинал документа об образовании.</p>
                                    <p>Если у Вас остались вопросы, то их можно задать, написав на следующий адрес электронной почты: <a href=\"mailto:{$college -> school -> enrollment -> email}\">{$college -> school -> enrollment -> email}</a>.</p>
                                    <hr>
                                    <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>
                                ";
                                $mail -> Body = $body;
                                $mail -> send();
                            }
                            echo json_encode([
                                "status" => "OK",
                            ]);
                        } elseif (empty($_statement["attachedDocsIds"]) && !empty($folders)) {
                            $newFiles = [];
                            $folderName = !empty($_statement["folder"]) ? $crypt -> decrypt($_statement["folder"]) : md5($_statement["email"] . time() . microtime());
                            if (empty($_statement["folder"])) {
                                $files -> createFolder("/enrollment/enrolles/{$folderName}");
                                $database -> query("UPDATE `enr_statements` SET `folder` = '{$crypt -> encrypt($folderName)}' WHERE `id` = {$_statement_id};");
                            }
                            foreach ($folders as $key => $value) {
                                $path = "/enrollment/enrolles/{$folderName}";
                                if ($files -> setPath($path)) {
                                    $files -> createFolder("/{$key}");
                                    $files -> setPath($path . "/{$key}");
                                }
                                foreach ($value as $piece)
                                    $newFiles[] = $files -> upload($piece["_FILE"], $piece["name"], false, [1001, 1002]);
                                $filesIsOk = true;
                                foreach ($newFiles as $_sub_value)
                                    if (!is_numeric($_sub_value))
                                        $filesIsOk = false;
                                if (!$filesIsOk) {
                                    $main_error = true;
                                    foreach ($newFiles as $_sub_value)
                                        if (is_numeric($_sub_value))
                                            $files -> delete(intval($_sub_value));
                                    echo json_encode([
                                        "status" => "ERRORS_IN_FILES",
                                    ]);
                                    exit;
                                }
                            }
                            $newAttachedDocs = [];
                            foreach ($check_files_ids as $key => $value)
                                if ($value)
                                    $newAttachedDocs[] = $key;
                            $sql .= "`attachedDocsIds` = '{$crypt -> encrypt(json_encode($newFiles))}', `attachedDocs` = '{$crypt -> encrypt(json_encode($newAttachedDocs))}', `withOriginalDiploma` = " . ($_POST["checkbox-original-diploma"] == "true" ? "1" : "0");
                            $database -> query("UPDATE `enr_statements` SET {$sql} WHERE `id` = {$_statement_id};");
                            echo json_encode([
                                "status" => "OK",
                            ]);
                        } elseif (empty($folders)) {
                            $attachedDocsIds = !empty($_statement["attachedDocsIds"]) ? json_decode($crypt -> decrypt($_statement["attachedDocsIds"])) : [];
                            $newAttachedDocs = [];
                            $erased_files = [];
                            foreach ($check_files_ids as $key => $value) {
                                if ($value)
                                    $newAttachedDocs[] = $key;
                                else {
                                    $_third_new_files = [];
                                    $what_delete = $database -> query("SELECT `latinName` FROM `enr_attached_docs` WHERE `id` = {$key};") -> fetch_assoc()["latinName"];
                                    foreach ($attachedDocsIds as $_sub_value) {
                                        $file = $files -> get(intval($_sub_value), 1001);
                                        $parsed_path = explode("/", explode("enrollment/enrolles/", $file["path"])[1]);
                                        if (mb_strpos($parsed_path[1], $what_delete) !== false) {
                                            $files -> delete(intval($_sub_value));
                                            $erased_files[] = $_sub_value;
                                        }
                                    }
                                    $non_erased_files = [];
                                    foreach ($attachedDocsIds as $value)
                                        if (!in_array($value, $erased_files))
                                            $non_erased_files[] = $value;
                                }
                            }
                            $sql .= "`attachedDocs` = '{$crypt -> encrypt(json_encode($newAttachedDocs))}', `attachedDocsIds` = '{$non_erased_files}', `withOriginalDiploma` = " . ($_POST["checkbox-original-diploma"] == "true" ? "1" : "0");
                            $database -> query("UPDATE `enr_statements` SET {$sql} WHERE `id` = {$_statement_id};");
                            if (boolval($_statement["isOnline"])) {
                                require __DIR__ . "/../../../../../configurations/email/class.php";
                                $key = [
                                    "specialty" => $database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$_statement["specialty"]}") -> fetch_assoc()["compositeKey"],
                                    "level" => $database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$_statement["degree"]}") -> fetch_assoc()["compositeKey"],
                                    "count" => $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$_statement["id"]}") -> fetch_assoc()["compositeKey"],
                                    "year" => Date("Y", $_statement["timestamp"]),
                                ];
                                $mail -> addAddress($crypt -> decrypt($_statement["email"]));
                                $college = json_decode(file_get_contents(__DIR__ . "/../../../../../configurations/json/about.json"));
                                $mail -> Subject = "Подача документов в {$college -> school -> name -> short} онлайн";
                                $body = "
                                    <h2>Подача документов в {$college -> school -> name -> short} онлайн</h2>
                                    <p>Здравствуйте, {$crypt -> decrypt($_statement["firstname"])} {$crypt -> decrypt($_statement["patronymic"])}!</p>
                                    <p>У вас изменился список прилагаемых файлов! В <a href=\"https://{$college -> address}/login\">личном кабинете</a> Вы можете ознакомиться со списком.</p>
                                    <p>Вашему личному делу был присвоен следующий номер: <b><code>{$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$_statement_id})</code></b>.</p>
                                    <p>Также, не забывайте, что зачисление в образовательное учреждение происходит при условии, что у вы подали оригинал документа об образовании.</p>
                                    <p>Если у Вас остались вопросы, то их можно задать, написав на следующий адрес электронной почты: <a href=\"mailto:{$college -> school -> enrollment -> email}\">{$college -> school -> enrollment -> email}</a>.</p>
                                    <hr>
                                    <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>
                                ";
                                $mail -> Body = $body;
                                $mail -> send();
                            }
                            echo json_encode([
                                "status" => "OK",
                            ]);
                        }
                    } else
                        echo json_encode([
                            "status" => "FILE_LIST_IS_EMPTY",
                        ]);
                } else
                    echo json_encode([
                        "status" => "STATEMENT_IS_NOT_FOUND",
                    ]);
                $database -> close();
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
        } else
            echo json_encode([
                "status" => "STATEMENT_ID_IS_EMPTY",
            ]);
    } else
        echo json_encode([
            "status" => "ACCESS_DENIED",
        ]);
?>
