<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../../../configurations/email/class.php";
    require __DIR__ . "/../../../../libraries/users.php";
    if (!empty($_POST["token"]) && !empty($_FILES["users"])) {
        $user = new user($_POST["token"]);
        if ($user -> _isFound && $user -> check_level(0)) {
            if ($_FILES["users"]["type"] == "text/csv" || $_FILES["users"]["type"] == "application/vnd.ms-excel") {
                if (($handle = fopen($_FILES["users"]["tmp_name"], "r")) !== false) {
                    $error = [];
                    $count = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        $count++;
                        $thumb = [
                            "lastname" => strval($data[0]),
                            "firstname" => strval($data[1]),
                            "patronymic" => strval($data[2]),
                            "birthday" => strval($data[3]),
                            "email" => strval($data[4]),
                            "telephone" => strval($data[5]),
                            "levels" => explode(";", strval($data[6])),
                            "login" => create_random_string(8),
                            "password" => create_random_string(16),
                        ];
                        if (preg_match("/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/", $thumb["birthday"]) == 0) {
                            $error[] = [
                                "line" => $count,
                                "error" => "BIRTHDAY_BOT_VALID",
                            ];
                            continue;
                        }
                        if (preg_match("/^9[0-9]{9}$/", $thumb["telephone"]) == 1)
                            $thumb["telephone"] = "+7 (9{$thumb["telephone"][1]}{$thumb["telephone"][2]}) {$thumb["telephone"][3]}{$thumb["telephone"][4]}{$thumb["telephone"][5]} {$thumb["telephone"][6]}{$thumb["telephone"][7]}-{$thumb["telephone"][8]}{$thumb["telephone"][9]}";
                        else {
                            $error[] = [
                                "line" => $count,
                                "error" => "TELEPHONE_NOT_VALID",
                            ];
                            continue;
                        }
                        if ($thumb["patronymic"] == " ")
                            unlink($thumb["patronymic"]);
                        while (!$user -> check_login($thumb["login"])) {
                            $thumb["login"] = create_random_string(8);
                        }
                        switch ($user -> register($thumb)) {
                            case true:
                                $about = json_decode(file_get_contents(__DIR__ . "/../../../../configurations/json/about.json"));
                                $mail -> addAddress($thumb["email"]);
                                $mail -> Subject = "Вы зарегестрированы в системе АИС {$about -> systemName}";
                                $mail -> Body = "
                                    <h3>Автоматизированная информационная система {$about -> systemName}</h3>
                                    <p>Уважаемый (ая), {$thumb["lastname"]} {$thumb["firstname"]}!</p>
                                    <p>Вы были зарегестрированы в АИС {$about -> systemName}. Система доступна по адресу: <a href=\"http://{$about -> address}\">http://{$about -> address}.</a></p>
                                    <p>Ваши аутентификационные данные:</p>
                                    <ul>
                                        <li>Логин: <code><b>{$thumb["login"]}</b></code></li>
                                        <li>Пароль: <code><b>{$thumb["password"]}</b></code></li>
                                    </ul>
                                    <p>Настоятельно рекомендуем сменить аутентификационные данные в целях предотвращения неправомерных действий.</p>
                                ";
                                $mail -> send();
                            	$mail -> ClearAllRecipients();
                            break;
                            case "ACCESS_DENIED":
                                $error[] = [
                                    "line" => $count,
                                    "error" => "ACCESS_DENIED",
                                ];
                                continue;
                            break;
                            case "SOME_DATA_IS_EMPTY":
                                $error[] = [
                                    "line" => $count,
                                    "error" => "SOME_DATA_IS_EMPTY",
                                ];
                                continue;
                            break;
                            case "TINY_PASSWORD":
                                $error[] = [
                                    "line" => $count,
                                    "error" => "TINY_PASSWORD",
                                ];
                                continue;
                            break;
                            case "LOGIN_IS_NOT_UNIQUE":
                                $error[] = [
                                    "line" => $count,
                                    "error" => "LOGIN_IS_NOT_UNIQUE",
                                ];
                                continue;
                            break;
                        }
                    }
                    if (count($error) == 0)
                        echo json_encode([
                            "status" => "OK",
                        ]);
                    else
                        echo json_encode([
                            "status" => "SOME_USERS_ARE_NOT_REGISTERED",
                            "list" => $error,
                        ]);
                    fclose($handle);
                } else {
                    fclose($handle);
                    echo([
                        "status" => "FILE_DOES_NOT_OPENED",
                    ]);
                }
            } else
            echo json_encode([
                "status" => "CSV_TABLE_EXPECTED",
            ]);
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $user -> c();
    } else
        echo json_encode([
            "status" => "SOME_DATA_IS_EMPTY",
        ]);
?>
