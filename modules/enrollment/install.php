<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../configurations/define.php";
    if (checkConfigurations()) {
        $user;
        if (isset($_COOKIE["token"])) {
            require __DIR__ . "/../../libraries/users.php";
            $user = new user($_COOKIE["token"]);
            if (!$user -> _isFound) {
                unset($_COOKIE['token']);
                setcookie('token', null, -1, '/');
                $user -> c();
                $user = "";
                header("Location: /", true, 302);
            } elseif ($user -> check_level(0)) {
                require DATABASE;
                $check = $database -> query("SHOW TABLES LIKE 'enr_statements';"); 
                if ($check -> num_rows == 0) {
                    $database -> multi_query(file_get_contents(__DIR__ . "/sql/create-db.sql"));
                    echo json_encode([
                        "status" => empty($database -> error) ? "OK" : $database -> error,
                    ]);
                } else
                    echo json_encode([
                        "status" => "TABLES_EXSISTS",
                    ]);
                $database -> close();
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
        $user -> c();
    } else
        header("Location: /modules/first-start/", true, 302);
?>