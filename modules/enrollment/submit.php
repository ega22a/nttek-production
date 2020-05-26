<?php
    require __DIR__  . "/../../configurations/define.php";
    if (checkConfigurations()) {
        $tengine = new template(__DIR__ . "/templates/submit/");
        $user;
        if (isset($_COOKIE["token"])) {
            header("Location: /", true, 302); 
        } else {
            $json = json_decode(file_get_contents(__DIR__  . "/../../configurations/json/about.json"));
            require DATABASE;
            $tengine -> set("database", $database);
            $tengine -> display("../../../../global-templates/header");
            $tengine -> display("../../../../global-templates/header-menu");
            if (time() >= $json -> school -> enrollment -> startDate && time() <= strtotime($json -> school -> enrollment -> date))
                switch ($_GET["type"]) {
                    case "extramural":
                        $tengine -> display("extramural");
                    break;
                    case "fulltime":
                    default:
                        $tengine -> display("fulltime");
                    break;
                }
            else {
                $tengine -> set("time", $json -> school -> enrollment);
                $tengine -> display("time");
            }
        }
    } else
        header("Location: /modules/first-start/", true, 302);
?>