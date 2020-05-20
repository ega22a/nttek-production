<?php
    require __DIR__  . "/../../../configurations/define.php";
    if (checkConfigurations()) {
        $tengine = new template(__DIR__ . "/../templates/secretary/");
        $user;
        if (isset($_COOKIE["token"]) && isset($_GET["id"])) {
            require __DIR__ . "/../../../libraries/users.php";
            $user = new user($_COOKIE["token"]);
            require DATABASE;
            if (!$user -> _isFound) {
                unset($_COOKIE['token']);
                setcookie('token', null, -1, '/');
                header("Location: /", true, 302);
            }
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                require CIPHER_KEYS;
                $id = intval($database -> real_escape_string($_GET["id"]));
                $statement = $database -> query("SELECT * FROM `enr_statements` WHERE `id` = {$id};");
                if ($statement -> num_rows == 1) {
                    $tengine -> set("user", $user);
                    $tengine -> set("database", $database);
                    $tengine -> set("crypt", new CryptService($ciphers["database"]));
                    $tengine -> set("statement", $statement -> fetch_assoc());
                    $tengine -> display("../../../../global-templates/header");
                    $tengine -> display("../../../../global-templates/header-menu");
                    $tengine -> display("s-edit");
                } else
                    header("Location: /", true, 302);
            } else
                header("Location: /", true, 302);
            $user -> c();
            $database -> close();
        } else
            header("Location: /", true, 302);
    } else
        header("Location: /modules/first-start/", true, 302);
?>
