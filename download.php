<?php
    require __DIR__ . "/libraries/files.php";
    require __DIR__ . "/libraries/users.php";
    $token = NULL;
    if (isset($_POST["token"]))
        $token = $_POST["token"];
    elseif (isset($_GET["token"]))
        $token = $_GET["token"];
    elseif (isset($_COOKIE["token"]))
        $token = $_COOKIE["token"];
    $file = isset($_GET["id"]) ? $_GET["id"] : NULL;
    if (isset($file)) {
        $file = intval($file);
        $f = new files();
        if (!is_null($token)) {
            $user = new user($token);
            $granted = false;
            $id = -1;
            foreach ($user -> getDecrypted()["levels"] as $value)
                if (is_array($f -> get($file, intval($value)))) {
                    $granted = true;
                    $id = intval($value);
                }
            if ($granted) {
                $f -> download($file, $id);
            } else
                http_response_code(403);
            $user -> c();
        } else {
            $f -> download($file);
        }
    } else
        http_response_code(404);
?>