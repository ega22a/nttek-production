<?php
    header("Content-Type: application/json");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require __DIR__ . "/../configuration.php";
    if (checkConfigurations())
        echo json_encode([
            "status" => "ACCESS_DENIED",
        ]);
    else {
        if (in_array(CLIENT_IP, ALLOWED_IPS)) {
            if (!empty($_POST["login"]) && !empty($_POST["password"]) && !empty($_POST["host"]) && !empty($_POST["port"]) && !empty($_POST["to"])) {
                include __DIR__ . "/../../../libraries/PHPMailer/src/Exception.php";
                include __DIR__ . "/../../../libraries/PHPMailer/src/PHPMailer.php";
                include __DIR__ . "/../../../libraries/PHPMailer/src/SMTP.php";
                $code = random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9);
                $mail;
                try {
                    $mail = new PHPMailer(true);
                    $mail -> setLanguage("ru");
                    $mail -> CharSet = "UTF-8";
                    $mail -> IsSMTP();
                    $mail -> SMTPAuth = true;
                    $mail -> SMTPSecure = "tls";
                    $mail -> Username = $_POST["login"];
                    $mail -> Password = $_POST["password"];
                    $mail -> Host = "ssl://" . $_POST["host"];
                    $mail -> Port = $_POST["port"];
                    $mail -> IsHTML(true);
                    $mail -> SetFrom($_POST["login"], 'Робот настройки Ассистента');
                    $mail -> addAddress($_POST["to"]);
                    $mail -> Subject = 'Успешная настройка PHPMailer и POSTFIX';
                    $mail -> Body = "Здравствуйте! Код проверки системы: <b><code>$code</code></b>";
                    $mail -> send();
                    echo json_encode([
                        "status" => "OK",
                        "code" => "$code",
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => "ERROR",
                        "message" => $e -> getMessage(),
                    ]);
                }
            } else
                echo json_encode([
                    "status" => "SOME_DATA_IS_EMPTY",
                ]);
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
    }
?>