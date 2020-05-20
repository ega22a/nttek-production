<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["id"])) {
            require __DIR__ . "/../../../../../libraries/users.php";
            $_user = new user($_POST["token"]);
            if ($_user -> check_level(1001) || $_user -> check_level(1002)) {
                require __DIR__ . "/../../../../../configurations/database/class.php";
                $id = intval($_POST["id"]);
                $enrollee = $database -> query("SELECT `id`, `usersId`, `attachedDocsIds`, `folder` FROM `enr_statements` WHERE `id` = {$id} AND `usersId` IS NOT NULL;");
                if ($enrollee -> num_rows == 1) {
                    require __DIR__ . "/../../../../../configurations/cipher-keys.php";
                    require_once __DIR__ . "/../../../../../configurations/main.php";
                    $crypt = new CryptService($ciphers["database"]);
                    $enrollee = $enrollee -> fetch_assoc();
                    if (!empty($enrollee["attachedDocsIds"])) {
                        require __DIR__ . "/../../../../../libraries/files.php";
                        $files = new files();
                        foreach (json_decode($crypt -> decrypt($enrollee["attachedDocsIds"])) as $value)
                            $files -> delete(intval($value));
                        $absolute_path = json_decode(file_get_contents(__DIR__ . "/../../../../../configurations/json/about.json")) -> absolutePath;
                        foreach (scandir("{$absolute_path}/{$crypt -> decrypt($enrollee["folder"])}") as $value)
                            if (!in_array($value, [".", ".."]))
                                rmdir("{$absolute_path}/{$crypt -> decrypt($enrollee["folder"])}/{$value}");
                        rmdir("{$absolute_path}/{$crypt -> decrypt($enrollee["folder"])}");
                    }
                    $database -> query("DELETE FROM `enr_statements` WHERE `id` = {$id};");
                    $database -> query("DELETE FROM `main_user_auth` WHERE `usersId` = {$enrollee["usersId"]};");
                    $database -> query("DELETE FROM `main_users` WHERE `id` = {$enrollee["usersId"]};");
                    echo json_encode([
                        "status" => "OK",
                    ]);
                } else
                    echo json_encode([
                        "status" => "ENROLLEE_IS_NOT_FOUND",
                    ]);
                $database -> close();
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
        } else
            echo json_encode([
                "status" => "ID_IS_EMPTY",
            ]);
    } else
        echo json_encode([
            "status" => "ACCESS_DENIED",
        ])
?>
