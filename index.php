<?php
    require __DIR__  . "/configurations/define.php";
    if (checkConfigurations()) {
        $tengine = new template(__DIR__ . "/global-templates/");
        $user;
        if (isset($_COOKIE["token"])) {
            require __DIR__ . "/libraries/users.php";
            $user = new user($_COOKIE["token"]);
            $about = [];
            if (!$user -> _isFound) {
                unset($_COOKIE['token']);
                setcookie('token', null, -1, '/');
                $user -> c();
                $user = "";
            } else
                $about = $user -> getDecrypted();
        }
        $tengine -> set("user", $user);
        $tengine -> display("header");
        $tengine -> display("header-menu");
        $tengine -> display("index-body");
    } else
        header("Location: /modules/first-start/", true, 302);
?>