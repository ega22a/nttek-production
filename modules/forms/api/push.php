<?php
    header("Content-Type: application/json");
    if (isset($_POST["id"]) && isset($_POST["payload"])) {
        $id = intval($_POST["id"]);
        $payload = json_decode($_POST["payload"]);
        require __DIR__ . "/../../../configurations/database/class.php";
        $vanilla_form = $database -> query("SELECT * FROM `frm_forms` WHERE `id` = {$id};");
        if ($vanilla_form -> num_rows != 0) {
            $vanilla_form = $vanilla_form -> fetch_assoc();
            $decode_ids = [];
            $users_form = [];
            $email = "";
            foreach (json_decode($vanilla_form["form"]) as $value) {
                switch ($value -> type) {
                    case "radio":
                        $decode_ids[$value -> id] = [
                            "label" => $value -> label,
                            "data" => $value -> data,
                        ];
                    break;
                    default:
                        $decode_ids[$value -> id] = $value -> label;
                    break;
                }
            }
            foreach ($payload as $value) {
                switch ($value -> type) {
                    default:
                        $users_form[] = [
                            "type" => $value -> type,
                            "name" => $decode_ids[$value -> id],
                            "value" => htmlspecialchars($value -> value),
                        ];
                    break;
                    case "radio":
                        if ($value -> value)
                            $users_form[] = [
                                "type" => $value -> type,
                                "name" => $decode_ids[explode("-radio-", $value -> id)[0]]["label"],
                                "value" => htmlspecialchars($decode_ids[explode("-radio-", $value -> id)[0]]["data"][explode("-radio-", $value -> id)[1]]),
                            ];
                    break;
                    case "email":
                        $email = $value -> value;
                    break;
                }
            }
            $database -> query("INSERT INTO `frm_storage` (`data`, `formId`, `timestamp`) VALUES ('" . json_encode($users_form) . "', {$id}, " . time() . ");");
            if (!empty($email) || !empty($vanilla_form["email"])) {
                require __DIR__ . "/../../../configurations/email/class.php";
                $about = json_decode(file_get_contents(__DIR__ . "/../../../configurations/json/about.json"));
                if (!empty($email)) {
                    $mail -> addAddress($email);
                    $mail -> Subject = "Заполнение формы через АИС {$about -> systemName}";
                    $insert = "";
                    foreach ($users_form as $value)
                        $insert .= "
                            <tr>
                                <td>{$value["name"]}</td>
                                <td>{$value["value"]}</td>
                            </tr>
                        ";
                    $mail -> Body = "
                        <h3>Автоматизированная информационная система {$about -> systemName}</h3>
                        <p>Здравствуйте! Вы заполнили форму образовательного учреждения, где организован сбор адреса электронной почты. Система высылает вам заполненную вами форму:</p>
                        <table border='1'>
                            <tr>
                                <th>Вопрос</th>
                                <th>Ваш ответ</th>
                            </tr>
                            {$insert}
                        </table>
                        <p>На ваше обращение поступит ответ, ожидайте.</p>
                        <hr>
                        <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>
                    ";
                    $mail -> send();
                    $mail -> ClearAllRecipients();
                }
                if (!empty($vanilla_form["email"])) {
                    $mail -> addAddress($vanilla_form["email"]);
                    $mail -> Subject = "Заполненная форма {$vanilla_form["name"]} в АИС {$about -> systemName}";
                    $insert = "";
                    foreach ($users_form as $value)
                        $insert .= "
                            <tr>
                                <td>{$value["name"]}</td>
                                <td>{$value["value"]}</td>
                            </tr>
                        ";
                    $mail -> Body = "
                        <h3>Автоматизированная информационная система {$about -> systemName}</h3>
                        <p>Была заполнена форма через АИС {$about -> systemName}. Заполненные данные:</p>
                        <table border='1'>
                            <tr>
                                <th>Вопрос</th>
                                <th>Ответ</th>
                            </tr>
                            {$insert}
                        </table>
                        <p>" . (!empty($email) ? "Адрес электронной почты заполнителя: <a href=\"mailto:{$email}\">{$email}</a>" : "") . "</p>
                        <hr>
                        <sub>Это письмо было сгенерировано автоматически. На него не нужно отвечать!</sub>
                    ";
                    $mail -> send();
                    $mail -> ClearAllRecipients();
                }
                echo json_encode([
                    "status" => "OK",
                ]);
            }
        } else
            echo json_encode([
                "status" => "FORM_IS_NOT_FOUND",
            ]);
    } else
        echo json_encode([
            "status" => "SOME_DATA_IS_EMPTY",
        ]);
?>
