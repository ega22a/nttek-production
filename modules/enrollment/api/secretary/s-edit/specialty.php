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
                    if (isset($_POST["specialty"])) {
                        if ($database -> query("SELECT `id` FROM `enr_specialties` WHERE `id` = " . intval($_POST["specialty"]) . ";") -> num_rows == 1 && intval($_POST["specialty"]) != $_statement["specialty"]) {
                            if (boolval($_statement["isOnline"])) {
                                require __DIR__ . "/../../../../../libraries/files.php";
                                $files = new files("");
                                $files_ids = json_decode($crypt -> decrypt($_statement["attachedDocsIds"]));
                                $newFiles = [];
                                foreach ($files_ids as $value) {
                                    $file = $files -> get(intval($value), 1001);
                                    $parsed_path = explode("/", explode("enrollment/enrolles/", $file["path"])[1]);
                                    if (in_array($parsed_path[1], ["statement", "hostel"]))
                                        $files -> delete($value);
                                    else
                                        $newFiles[] = $value;
                                }
                                $sql .= "`attachedDocsIds` = '{$crypt -> encrypt(json_encode($newFiles))}', `withStatement` = 0, ";
                            }
                            $sql .= "`specialty` = " . intval($_POST["specialty"]) . ", `compositeKey` = NULL";
                            $database -> query("UPDATE `enr_statements` SET {$sql} WHERE `id` = {$_statement_id};");
                            $count = $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `specialty` = " . intval($_POST["specialty"]) . " ORDER BY `compositeKey` DESC LIMIT 1") -> fetch_assoc()["compositeKey"];
                            if (empty($count))
                                $database -> query("UPDATE `enr_statements` SET `compositeKey` = 1 WHERE `id` = {$_statement_id}");
                            else
                                $database -> query("UPDATE `enr_statements` SET `compositeKey` = " . strval(intval($count) + 1) . " WHERE `id` = {$_statement_id}");
                            $docs = [
                                "statement" => statement($user, $_statement_id),
                                "receipt" => receipt($user, $_statement_id),
                                "hostel" => hostel($user, $_statement_id),
                            ];
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
                                    <p>Ваше обращение по переходу на другую специальность одобрено! В приложении к этому письму вы найдете Заявление. <b>ОБЯЗАТЕЛЬНО</b> распечатайте его, заполните, отсканируйте и приложите подписанное Заявление в <a href=\"https://{$college -> address}/login\">личном кабинете</a>.</p>
                                    <p>Вашему личному делу был присвоен следующий номер: <b><code>{$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$_statement_id})</code></b>.</p>
                                    <p>Также, не забывайте, что зачисление в образовательное учреждение происходит при условии, что у вы подали оригинал документа об образовании.</p>
                                    <p>Если у Вас остались вопросы, то их можно задать, написав на следующий адрес электронной почты: <a href=\"mailto:{$college -> school -> enrollment -> email}\">{$college -> school -> enrollment -> email}</a>.</p>
                                    <hr>
                                    <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>
                                ";
                                $mail -> Body = $body;
                                $mail -> addStringAttachment($docs["statement"], "statement.pdf");
                                if (boolval($_statement["hostel"]))
                                    $mail -> addStringAttachment($docs["hostel"], "hostel.pdf");
                                $mail -> send();
                            }
                            echo json_encode([
                                "status" => "OK",
                                "statement" => base64_encode($docs["statement"]),
                                "receipt" => base64_encode($docs["receipt"]),
                            ]);
                        }
                        else
                            echo json_encode([
                                "status" => "SPECIALTY_IS_NOT_FOUND",
                            ]);
                    } else
                        echo json_encode([
                            "status" => "SPECIALTY_IS_EMPTY",
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
