<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["id"])) {
            if (isset($_POST["message"])) {
                require __DIR__ . "/../../../../../libraries/users.php";
                $_user = new user($_POST["token"]);
                if ($_user -> check_level(1001) || $_user -> check_level(1002)) {
                    require __DIR__ . "/../../../../../configurations/database/class.php";
                    $id = intval($_POST["id"]);
                    $enrollee = $database -> query("SELECT `id`, `attachedDocsIds`, `email`, `firstname`, `patronymic`, `sex` FROM `enr_statements` WHERE `id` = {$id} AND `isOnline` = 1 AND `usersId` IS NULL;");
                    if ($enrollee -> num_rows == 1) {
                        $enrollee = $enrollee -> fetch_assoc();
                        require __DIR__ . "/../../../../../configurations/cipher-keys.php";
                        require_once __DIR__ . "/../../../../../configurations/main.php";
                        $crypt = new CryptService($ciphers["database"]);
                        require __DIR__ . "/../../../../../libraries/files.php";
                        $files = new files();
                        foreach (json_decode($crypt -> decrypt($enrollee["attachedDocsIds"])) as $value)
                            $files -> delete(intval($value));
                        $database -> query("DELETE FROM `enr_statements` WHERE `id` = {$id}");
                        require __DIR__ . "/../../../../../configurations/email/class.php";
                        $college = json_decode(file_get_contents(__DIR__ . "/../../../../../configurations/json/about.json")) -> school;
                        $mail -> addAddress($crypt -> decrypt($enrollee["email"]));
                        $mail -> Subject = "Подача документов в {$college -> name -> short} онлайн";
                        $mail -> Body = "
                            <h2>Подача документов в {$college -> name -> short} онлайн</h2>
                            <p>Здравствуйте, {$crypt -> decrypt($enrollee["firstname"])} {$crypt -> decrypt($enrollee["patronymic"])}!</p>
                            <p>В ходе проверки вашего заявления, а также копий приложенных документов были выявленны несовпадения и (или) ошибки. Конкретизирующее письмо от ответственного секретаря Приемной комиссии:</p>
                            <p style=\"margin-left: 25px;\"><i>{$_POST["message"]}</i></p>
                            <p>Если у Вас остались вопросы, то их можно задать, написав на следующий адрес электронной почты: <a href=\"mailto:{$college -> enrollment -> email}\">{$college -> enrollment -> email}</a>.</p>
                            <p><strong>ВАМ НУЖНО ОФОРМИТЬ ОНЛАЙН-ЗАЯВЛЕНИЕ ЗАНОВО!</strong></p>
                            <hr>
                            <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>";
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
                                ]);
                        }
                    } else
                        echo json_encode([
                            "status" => "ENROLLEE_IS_NOT_FOUND",
                        ]);
                    $database -> close();
                } else
                    echo json_encode([
                        "status" => "MESSAGE_IS_EMPTY",
                    ]);
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