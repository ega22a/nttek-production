<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $mail;
    if ($auth = parse_ini_file(__DIR__ . "/auth.ini")) {
        include __DIR__ . "/../../libraries/PHPMailer/src/Exception.php";
        include __DIR__ . "/../../libraries/PHPMailer/src/PHPMailer.php";
        include __DIR__ . "/../../libraries/PHPMailer/src/SMTP.php";
        try {
            $mail = new PHPMailer(true);
            $mail -> setLanguage("ru");
            $mail -> CharSet = "UTF-8";
            $mail -> IsSMTP();
            $mail -> SMTPAuth = true;
            $mail -> SMTPSecure = "tls";
            $mail -> Username = $auth["login"];
            $mail -> Password = $auth["password"];
            $mail -> Host = "ssl://" . $auth["host"];
            $mail -> Port = $auth["port"];
            $mail -> IsHTML(true);
            $mail -> SetFrom($auth["login"], 'АИС Ассистент');
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }
?>