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
            switch ($_GET["type"]) {
                case "extramural":
                    if (time() >= $json -> school -> enrollment -> startDate && time() <= $json -> school -> enrollment -> endTime -> extramural)
                        $tengine -> display("extramural");
                    else {
                        $tengine -> set("endTime", $json -> school -> enrollment -> endTime -> extramural);
                        $tengine -> set("startTime", $json -> school -> enrollment -> startDate);
                        $tengine -> display("time");
                    }
                break;
                case "fulltime":
                default:
                    if (time() >= $json -> school -> enrollment -> startDate && time() <= $json -> school -> enrollment -> endTime -> fulltime)
                        $tengine -> display("fulltime");
                    else {
                        $tengine -> set("endTime", $json -> school -> enrollment -> endTime -> fulltime);
                        $tengine -> set("startTime", $json -> school -> enrollment -> startDate);
                        $tengine -> display("time");
                    }
                break;
            }
        }
    } else
        header("Location: /modules/first-start/", true, 302);
?>