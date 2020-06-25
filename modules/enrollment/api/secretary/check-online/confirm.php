<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["id"])) {
            require __DIR__ . "/../../../../../libraries/users.php";
            $_user = new user($_POST["token"]);
            if ($_user -> check_level(1001) || $_user -> check_level(1002)) {
                require __DIR__ . "/../../../../../configurations/database/class.php";
                $id = intval($_POST["id"]);
                $enrollee = $database -> query("SELECT `id`, `firstname`, `lastname`, `patronymic`, `email`, `birthday`, `telephone` `sex`, `hostel`, `attachedDocs`, `compositeKey`, `specialty`, `degree`, `timestamp` FROM `enr_statements` WHERE `id` = {$id} AND `isOnline` = 1 AND `usersId` IS NULL;");
                if ($enrollee -> num_rows == 1) {
                    $enrollee = $enrollee -> fetch_assoc();
                    require __DIR__ . "/../../../../../configurations/cipher-keys.php";
                    require_once __DIR__ . "/../../../../../configurations/main.php";
                    require __DIR__ . "/../../../../../configurations/email/class.php";
                    require __DIR__ . "/../../../php/docs.php";
                    $crypt = new CryptService($ciphers["database"]);
                    switch (strval($_POST["type"])) {
                        case "budget":
                            if (isset($_POST["grades"])) {
                                $granted = true;
                                $grades = [];
                                foreach (str_split($_POST["grades"]) as $value)
                                    if (in_array(intval($value), [3, 4, 5]))
                                        $grades[] = intval($value);
                                    else
                                        $granted = false;
                                if ($granted) {
                                    if ($database -> query("SELECT `id` FROM `enr_statements` WHERE `id` = {$id} AND `averageMark` IS NULL;") -> num_rows == 1) {
                                        if (empty($enrollee["compositeKey"])) {
                                            $count = $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `specialty` = {$enrollee["specialty"]} ORDER BY `compositeKey` DESC LIMIT 1") -> fetch_assoc()["compositeKey"];
                                            if (empty($count))
                                                $database -> query("UPDATE `enr_statements` SET `compositeKey` = 1 WHERE `id` = {$enrollee["id"]}");
                                            else
                                                $database -> query("UPDATE `enr_statements` SET `compositeKey` = " . strval(intval($count) + 1) . " WHERE `id` = {$enrollee["id"]}");
                                        }
                                        $key = [
                                            "specialty" => $database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$enrollee["specialty"]}") -> fetch_assoc()["compositeKey"],
                                            "level" => $database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$enrollee["degree"]}") -> fetch_assoc()["compositeKey"],
                                            "count" => $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$enrollee["id"]}") -> fetch_assoc()["compositeKey"],
                                            "year" => Date("Y", $enrollee["timestamp"]),
                                        ];
                                        $average = round(array_sum($grades) / count($grades), 2);
                                        $database -> query("UPDATE `enr_statements` SET `averageMark` = {$average}, `isChecked` = 1 WHERE `id` = {$id};");
                                        if (empty($database -> error)) {
                                            $mail -> addAddress($crypt -> decrypt($enrollee["email"]));
                                            $college = json_decode(file_get_contents(__DIR__ . "/../../../../../configurations/json/about.json"));
                                            $mail -> Subject = "Подача документов в {$college -> school -> name -> short} онлайн";
                                            $_auth_enrollee = [
                                                "login" => create_random_string(6),
                                                "password" => create_random_string(8),
                                            ];
                                            $_login = hash("SHA256", $_auth_enrollee["login"]);
                                            while ($database -> query("SELECT `id` FROM `main_user_auth` WHERE `login` = '{$_login}';") -> num_rows != 0) {
                                                $_auth_enrollee["login"] = create_random_string(6);
                                                $_login = hash("SHA256", $_auth_enrollee["login"]);
                                            }
                                            $database -> query("INSERT INTO `main_users` (`firstname`, `lastname`, `patronymic`, `birthday`, `email`, `telephone`) VALUES ('{$enrollee["firstname"]}', '{$enrollee["lastname"]}', '{$enrollee["patronymic"]}', '{$enrollee["birthday"]}', '{$enrollee["email"]}', '{$enrollee["telephone"]}');");
                                            $t_id = $database -> insert_id;
                                            $database -> query("INSERT INTO `main_user_auth` (`login`, `password`, `levels`, `usersId`) VALUES ('$_login', '" . password_hash($_auth_enrollee["password"], PASSWORD_DEFAULT) . "', '{$crypt -> encrypt(json_encode([1003]))}', $t_id);");
                                            $database -> query("UPDATE `enr_statements` SET `usersId` = {$t_id} WHERE `id` = {$enrollee["id"]}");
                                            $body = "
                                                <h2>Подача документов в {$college -> school -> name -> short} онлайн</h2>
                                                <p>Здравствуйте, {$crypt -> decrypt($enrollee["firstname"])} {$crypt -> decrypt($enrollee["patronymic"])}!</p>
                                                <p>В ходе проверки вашего личного дела, а также приложенных документов, ваше личное дело было одобрено! В приложении к этому письму вы найдете Заявление. <b>ОБЯЗАТЕЛЬНО</b> распечатайте его, заполните, отсканируйте и приложите подписанное Заявление в <a href=\"https://{$college -> address}/login\">личном кабинете</a>.</p>
                                                <p>Ваши учетные данные для входа в систему:</p>
                                                <div style=\"margin-left: 25px;\">
                                                    <p>Логин: <b><code>{$_auth_enrollee["login"]}</code></b></p>
                                                    <p>Пароль: <b><code>{$_auth_enrollee["password"]}</code></b></p>
                                                </div>
                                                <p>НАСТОЯТЕЛЬНО РЕКОМЕНДУЕМ сменить пароль при первом входе.</p>
                                                <p>Вашему личному делу был присвоен следующий номер: <b><code>{$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$enrollee["id"]})</code></b>.</p>
                                                <p>Это письмо также подтверждает, что вы подали в приемную комиссию {$college -> school -> name -> short} следующие документы:</p>
                                                <ul>
                                            ";
                                            foreach (json_decode($crypt -> decrypt($enrollee["attachedDocs"])) as $value)
                                                $body .= "<li>" . $database -> query("SELECT `name` FROM `enr_attached_docs` WHERE `id` = $value;") -> fetch_assoc()["name"] . "</li>";
                                            $body .= "
                                                </ul>
                                                <p>Также, не забывайте, что зачисление в образовательное учреждение происходит при условии, что у вы подали оригинал документа об образовании.</p>
                                                <p>Если у Вас остались вопросы, то их можно задать, написав на следующий адрес электронной почты: <a href=\"mailto:{$college -> school -> enrollment -> email}\">{$college -> school -> enrollment -> email}</a>.</p>
                                                <hr>
                                                <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>
                                            ";
                                            $mail -> Body = $body;
                                            $mail -> addStringAttachment(statement($_user, $id), "statement.pdf");
                                            if (boolval($enrollee["hostel"]))
                                                $mail -> addStringAttachment(hostel($_user, $id), "hostel.pdf");
                                            $isExeption = false;
                                            try {
                                                $mail -> send();
                                            } catch (Exception $e) {
                                                echo json_decode([
                                                    "status" => $e,
                                                ]);
                                                $isExeption = true;
                                            } finally {
                                                if (!$isExeption)
                                                    echo json_encode([
                                                        "status" => "OK",
                                                        "key" => "{$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$enrollee["id"]})",
                                                    ]);
                                            }
                                        } else
                                            echo json_encode([
                                                "status" => "DB_ERROR",
                                            ]);
                                    } else
                                        echo json_encode([
                                            "status" => "ENROLLEE_HAVE_AVERAGE_GRADE_ALREADY",
                                        ]);
                                } else
                                    echo json_encode([
                                        "STATUS" => "NOT_GRANTED_GRADES",
                                    ]);
                            } else
                                echo json_encode([
                                    "status" => "GRADES_ARE_NOT_FOUND",
                                ]);
                        break;
                        case "contract":
                            if (empty($enrollee["compositeKey"])) {
                                $count = $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `specialty` = {$enrollee["specialty"]} ORDER BY `compositeKey` DESC LIMIT 1") -> fetch_assoc()["compositeKey"];
                                if (empty($count))
                                    $database -> query("UPDATE `enr_statements` SET `compositeKey` = 1 WHERE `id` = {$enrollee["id"]}");
                                else
                                    $database -> query("UPDATE `enr_statements` SET `compositeKey` = " . strval(intval($count) + 1) . " WHERE `id` = {$enrollee["id"]}");
                            }
                            $key = [
                                "specialty" => $database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$enrollee["specialty"]}") -> fetch_assoc()["compositeKey"],
                                "level" => $database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$enrollee["degree"]}") -> fetch_assoc()["compositeKey"],
                                "count" => $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$enrollee["id"]}") -> fetch_assoc()["compositeKey"],
                                "year" => Date("Y", $enrollee["timestamp"]),
                            ];
                            $database -> query("UPDATE `enr_statements` SET `isChecked` = 1 WHERE `id` = {$id};");
                            $mail -> addAddress($crypt -> decrypt($enrollee["email"]));
                            $college = json_decode(file_get_contents(__DIR__ . "/../../../../../configurations/json/about.json"));
                            $mail -> Subject = "Подача документов в {$college -> school -> name -> short} онлайн";
                            $_auth_enrollee = [
                                "login" => create_random_string(6),
                                "password" => create_random_string(8),
                            ];
                            $_login = hash("SHA256", $_auth_enrollee["login"]);
                            while ($database -> query("SELECT `id` FROM `main_user_auth` WHERE `login` = '{$_login}';") -> num_rows != 0) {
                                $_auth_enrollee["login"] = create_random_string(6);
                                $_login = hash("SHA256", $_auth_enrollee["login"]);
                            }
                            $database -> query("INSERT INTO `main_users` (`firstname`, `lastname`, `patronymic`, `birthday`, `email`, `telephone`) VALUES ('{$enrollee["firstname"]}', '{$enrollee["lastname"]}', '{$enrollee["patronymic"]}', '{$enrollee["birthday"]}', '{$enrollee["email"]}', '{$enrollee["telephone"]}');");
                            $t_id = $database -> insert_id;
                            $database -> query("INSERT INTO `main_user_auth` (`login`, `password`, `levels`, `usersId`) VALUES ('$_login', '" . password_hash($_auth_enrollee["password"], PASSWORD_DEFAULT) . "', '{$crypt -> encrypt(json_encode([1003]))}', $t_id);");
                            $database -> query("UPDATE `enr_statements` SET `usersId` = {$t_id} WHERE `id` = {$enrollee["id"]}");
                            $body = "
                                <h2>Подача документов в {$college -> school -> name -> short} онлайн</h2>
                                <p>Здравствуйте, {$crypt -> decrypt($enrollee["firstname"])} {$crypt -> decrypt($enrollee["patronymic"])}!</p>
                                <p>В ходе проверки вашего личного дела, а также приложенных документов, ваше личное дело было одобрено! В приложении к этому письму вы найдете Заявление. <b>ОБЯЗАТЕЛЬНО</b> распечатайте его, заполните, отсканируйте и приложите подписанное Заявление в <a href=\"https://{$college -> address}/login\">личном кабинете</a>.</p>
                                <p>Ваши учетные данные для входа в систему:</p>
                                <div style=\"margin-left: 25px;\">
                                    <p>Логин: <b><code>{$_auth_enrollee["login"]}</code></b></p>
                                    <p>Пароль: <b><code>{$_auth_enrollee["password"]}</code></b></p>
                                </div>
                                <p>НАСТОЯТЕЛЬНО РЕКОМЕНДУЕМ сменить пароль при первом входе.</p>
                                <p>Вашему личному делу был присвоен следующий номер: <b><code>{$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$enrollee["id"]})</code></b>.</p>
                                <p>Это письмо также подтверждает, что вы подали в приемную комиссию {$college -> school -> name -> short} следующие документы:</p>
                                <ul>
                            ";
                            foreach (json_decode($crypt -> decrypt($enrollee["attachedDocs"])) as $value)
                                $body .= "<li>" . $database -> query("SELECT `name` FROM `enr_attached_docs` WHERE `id` = $value;") -> fetch_assoc()["name"] . "</li>";
                            $body .= "
                                </ul>
                                <p>Также, не забывайте, что зачисление в образовательное учреждение происходит при условии, что у вы подали оригинал документа об образовании.</p>
                                <p>Если у Вас остались вопросы, то их можно задать, написав на следующий адрес электронной почты: <a href=\"mailto:{$college -> school -> enrollment -> email}\">{$college -> school -> enrollment -> email}</a>.</p>
                                <hr>
                                <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>
                            ";
                            $mail -> Body = $body;
                            $mail -> addStringAttachment(statement($_user, $id), "statement.pdf");
                            $isExeption = false;
                            try {
                                $mail -> send();
                            } catch (Exception $e) {
                                echo json_decode([
                                    "status" => $e,
                                ]);
                                $isExeption = true;
                            } finally {
                                if (!$isExeption)
                                    echo json_encode([
                                        "status" => "OK",
                                        "key" => "{$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$enrollee["id"]})",
                                    ]);
                            }
                        break;
                        default:
                            echo json_encode([
                                "status" => "WRONG_TYPE",
                            ]);
                        break;
                    }
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
