<?php
    require __DIR__  . "/../configurations/define.php";
    if (checkConfigurations()) {
        if (!isset($_COOKIE["token"])) {
            $tengine = new template(__DIR__ . "/../global-templates/");
            $tengine -> display("header");
            $tengine -> display("header-menu");
            $tengine -> display("login-body");
        } else
            header("Location: /", true, 302);
    } else
        header("Location: /modules/first-start/", true, 302);
?>