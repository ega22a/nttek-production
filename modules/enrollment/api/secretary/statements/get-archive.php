<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["id"])) {
            require __DIR__ . "/../../../../../libraries/users.php";
            $_user = new user($_POST["token"]);
            if ($_user -> check_level(1001) || $_user -> check_level(1002)) {
                require __DIR__ . "/../../../../../configurations/database/class.php";
                $id = intval($_POST["id"]);
                $enrollee = $database -> query("SELECT `id`, `firstname`, `lastname`, `patronymic`, `attachedDocsIds`, `pathToZip`, `hostel` FROM `enr_statements` WHERE `id` = {$id} AND `isChecked` = 1 AND `usersId` IS NOT NULL");
                if ($enrollee -> num_rows == 1) {
                    $enrollee = $enrollee -> fetch_assoc();
                    require __DIR__ . "/../../../../../configurations/cipher-keys.php";
                    require_once __DIR__ . "/../../../../../configurations/main.php";
                    $crypt = new CryptService($ciphers["database"]);
                    $thumb = [
                        "name" => $crypt -> decrypt($enrollee["lastname"]) . "_" . $crypt -> decrypt($enrollee["firstname"]) . (!empty($enrollee["patronymic"]) ? "_" . $crypt -> decrypt($enrollee["patronymic"]) : ""),
                    ];
                    require __DIR__ . "/../../../../../libraries/files.php";
                    require __DIR__ . "/../../../php/docs.php";
                    $statement_name = tempnam("/tmp", "pdf");
                    $archive = new ZipArchive();
                    $name_of_archive = tempnam("/tmp", "zip");
                    if ($archive -> open($name_of_archive, ZIPARCHIVE::OVERWRITE) == true) {
                        file_put_contents($statement_name, statement($_user, $id));
                        $archive -> addFile($statement_name, "Заявление на обучение.pdf");
                        if (!empty($enrollee["attachedDocsIds"])) {
                            $thumb["files"] = json_decode($crypt -> decrypt($enrollee["attachedDocsIds"]));
                            $files = new files();
                            foreach ($thumb["files"] as $value) {
                                $file = $files -> get(intval($value), 1001);
                                $parsed_path = explode("/", explode("enrollment/enrolles/", $file["path"])[1]);
                                $translatedName = $database -> query("SELECT `name` FROM `enr_attached_docs` WHERE `latinName` = '{$parsed_path[1]}';");
                                if ($translatedName -> num_rows == 1)
                                    $translatedName = $translatedName -> fetch_assoc()["name"];
                                elseif ($translatedName -> num_rows == 0) {
                                    if ($parsed_path[1] == "statement")
                                        $translatedName = "Скан подписанного заявления";
                                    elseif ($parsed_path[1] == "hostel")
                                        $translatedName = "Скан заявления на общежитие";
                                }
                                $archive -> addFile($file["path"], "{$translatedName}/{$parsed_path[2]}");
                            }
                        }
                        if (boolval($enrollee["hostel"])) {
                            $hostel_name = tempnam("/tmp", "pdf");
                            file_put_contents($hostel_name, hostel($_user, $id));
                            $archive -> addFile($hostel_name, "Заявление на общежитие.pdf");
                        }
                        $receipt_name = tempnam("/tmp", "pdf");
                        file_put_contents($receipt_name, receipt($_user, $id));
                        $archive -> addFile($receipt_name, "Расписка.pdf");
                        $archive -> close();
                        if (!empty($enrollee["idOfZip"])) {
                            $files -> delete(intval($enrollee["idOfZip"]));
                        }
                        $files -> setPath("/enrollment/enrolles/zips");
                        $zipId = $files -> upload(
                            [
                            "name" => $thumb["name"],
                            "type" => "application/zip",
                            "size" => 3000,
                            "tmp_name" => $name_of_archive
                            ],
                            $thumb["name"],
                            false,
                            [1001, 1002]
                        );
                        $database -> query("UPDATE INTO `enr_statements` SET `idOfZip` = {$zipId} WHERE `id` = {$id};");
                        echo json_encode([
                            "status" => "OK",
                            "archive" => $zipId,
                            "name" => $thumb["name"],
                        ]);
                        unlink($name_of_archive);
                        unlink($statement_name);
                    } else
                        echo json_encode([
                            "status" => "UNABLE_TO_CREATE_ARCHIVE",
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
