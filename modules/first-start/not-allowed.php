<?php
    require __DIR__ . "/configuration.php";
    if (checkConfigurations())
        header("Location: /", true, 302);
    else {
        if (!in_array(CLIENT_IP, ALLOWED_IPS)) {
            $tengine = new template(__DIR__ . "/templates/");
            $tengine -> display("not-allowed");
            unset($tengine);
        } else
            header("Location: /modules/first-start/", true, 302); 
    }
?>