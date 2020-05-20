<?php
    require __DIR__ . "/../configurations/define.php";
    if (checkConfigurations()) {
        $tengine = new template(__DIR__ . "/../global-templates/");
        $user;
        if (isset($_COOKIE["token"])) {
            require __DIR__ . "/../libraries/users.php";
            $user = new user($_COOKIE["token"]);
            if (!$user -> _isFound) {
                unset($_COOKIE['token']);
                setcookie('token', null, -1, '/');
                $user -> c();
                $user = "";
                header("Location: /", true, 302);
                exit;
            }
        }
        $c = new configuration();
        $tengine -> set ("config", $c);
        $tengine -> set("user", $user);
        $tengine -> display("header");
        $tengine -> display("header-menu");
        $tengine -> display("cabinet-body");
        $user -> c();
    } else
        header("Location: /modules/first-start/", true, 302);
?>