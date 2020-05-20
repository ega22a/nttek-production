<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../libraries/users.php";
        $user = new user($_POST["token"]);
        if ($user -> check_level(1003)) {
            require __DIR__ . "/../../../../configurations/database/class.php";
            $statement = $database -> query("SELECT `enr_statements`.* FROM `enr_statements` INNER JOIN `main_users` ON `main_users`.`id` = `enr_statements`.`usersId` INNER JOIN `main_user_auth` ON `main_users`.`id` = `main_user_auth`.`usersId` WHERE `main_user_auth`.`id` = {$user -> _authId} AND `enr_statements`.`withStatement` = 0 AND `enr_statements`.`isOnline` = 1;");
            if ($statement -> num_rows == 1) {
                $statement = $statement -> fetch_assoc();
                require __DIR__ . "/../../../../configurations/cipher-keys.php";
                require_once __DIR__ . "/../../../../configurations/main.php";
                $granted = true;
                $folders = [];
                $counter = 0;
                foreach ($_FILES as $key => $value) {
                    if (mb_strpos($key, "statement") !== false) {
                        $folders["statement"][] = [
                            "_FILE" => $value,
                            "folder" => "statement",
                            "name" => md5($statement["email"]) . "-statement-" . $counter
                        ];
                        $counter++;
                    }
                }
                if ($counter == 0)
                    $granted = false;
                if (boolval($statement["hostel"])) {
                    if (isset($_FILES["hostel"])) {
                        $folders["hostel"][] = [
                            "_FILE" => $_FILES["hostel"],
                            "folder" => "hostel",
                            "name" => md5($statement["email"]) . "-hostel-0"
                        ];
                    } else
                        $granted = false;
                }
                if ($granted) {
                    require __DIR__ . "/../../../../libraries/files.php";
                    $crypt = new CryptService($ciphers["database"]);
                    $path = "/enrollment/enrolles/{$crypt -> decrypt($statement["folder"])}";
                    $files = new files();
                    $files_ids = [];
                    foreach ($folders as $key => $value) {
                        if ($files -> setPath($path)) {
                            $files -> createFolder("/{$key}");
                            $files -> setPath($path . "/{$key}");
                            foreach ($value as $piece)
                                $files_ids[] = $files -> upload($piece["_FILE"], $piece["name"], false, [1001, 1002]);
                        }
                    }
                    $filesIsOk = true;
                    foreach ($files_ids as $value)
                        if (!is_numeric($value))
                            $filesIsOk = false;
                    if ($filesIsOk) {
                        $attachedDocsIds = json_decode($crypt -> decrypt($statement["attachedDocsIds"]));
                        $attachedDocsIds = array_merge($attachedDocsIds, $files_ids);
                        $attachedDocsIds = $crypt -> encrypt(json_encode($attachedDocsIds));
                        $database -> query("UPDATE `enr_statements` SET `withStatement` = 1, `attachedDocsIds` = '{$attachedDocsIds}' WHERE `id` = {$statement["id"]}");
                        echo json_encode([
                            "status" => "OK",
                        ]);
                    } else {
                        foreach ($files_ids as $value)
                            if (is_numeric($value))
                                $files -> delete($value);
                        echo json_encode([
                            "status" => "ERRORS_IN_FILES",
                        ]);
                    }
                } else
                    echo json_encode([
                        "status" => "SOME_FILES_ARE_EMPTY",
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
            "status" => "ACCESS_DENIED",
        ]);
?>
