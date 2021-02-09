<?php
    require __DIR__  . "/../../configurations/define.php";
    if (checkConfigurations()) {
        $tengine = new template(__DIR__ . "/templates/");
        $user;
        if (isset($_COOKIE["token"])) {
            require __DIR__ . "/../../libraries/users.php";
            $user = new user($_COOKIE["token"]);
            if (!$user -> _isFound) {
                unset($_COOKIE['token']);
                setcookie('token', null, -1, '/');
                header("Location: /", true, 302);
            } else
                $tengine -> set("user", $user);
        }
        $tengine -> set("title", "Приемная кампания");
        $tengine -> display("../../../global-templates/header");
        $tengine -> display("../../../global-templates/header-menu");
        $tengine -> display("index");
        if (!empty($user))
            $user -> c();
    } else
        header("Location: /modules/first-start/", true, 302);
?>