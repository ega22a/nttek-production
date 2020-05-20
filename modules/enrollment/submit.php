<?php
    require __DIR__  . "/../../configurations/define.php";
    if (checkConfigurations()) {
        $tengine = new template(__DIR__ . "/templates/submit/");
        $user;
        if (isset($_COOKIE["token"])) {
            header("Location: /", true, 302); 
        } else {
            require DATABASE;
            $tengine -> set("database", $database);
            $tengine -> display("../../../../global-templates/header");
            $tengine -> display("../../../../global-templates/header-menu");
            switch ($_GET["type"]) {
                case "extramural":
                    $tengine -> display("extramural");
                break;
                case "fulltime":
                default:
                    $tengine -> display("fulltime");
                break;
            }
        }
    } else
        header("Location: /modules/first-start/", true, 302);
?>