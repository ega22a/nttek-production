<?php
    require __DIR__ . "/configuration.php";
    if (checkConfigurations())
        header("Location: /", true, 302);
    else {
        if (in_array(CLIENT_IP, ALLOWED_IPS)) {
            $tengine = new template(__DIR__ . "/templates/");
            $tengine -> display("header");
            switch ($_GET["step"]) {
                default:
                case "1":
                    $tengine -> display("step-1");
                break;
                case "2":
                    $tengine -> display("step-2");
                break;
                case "3":
                    $tengine -> display("step-3");
                break;
            }
        } else
            header("Location: /modules/first-start/not-allowed", true, 302);
    }
?>