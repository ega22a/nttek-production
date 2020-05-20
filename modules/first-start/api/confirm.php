<?php
    header("Content-Type: application/json");
    function rand_string(int $lenght = 128) {
        return bin2hex(random_bytes($lenght));
    }
    require __DIR__ . "/../configuration.php";
    require __DIR__ . "/../../../configurations/main.php";
    if (checkConfigurations())
        http_response_code(404);
    else {
        if (in_array(CLIENT_IP, ALLOWED_IPS)) {
            if (!empty($_POST["admin"]) && !empty($_POST["email"]) && !empty($_POST["database"])) {
                $counter = 0;
                foreach ($_POST as $first_value)
                    foreach ($first_value as $second_value)
                        if (empty($second_value))
                            $counter++;
                if ($counter == 0) {
                    $confCreater = new configuration();
                    $ciphers_array = [
                        "cookies" => rand_string(512),
                        "database" => rand_string(512),
                        "signature" => rand_string(1024),
                    ];
                    $crypt = new cryptService($ciphers_array["database"]);
                    if ($confCreater -> create(__DIR__ . "/../../../configurations/database/auth.ini", $_POST["database"]) && $confCreater -> create(__DIR__ . "/../../../configurations/email/auth.ini", $_POST["email"]) && file_put_contents(__DIR__ . "/../../../configurations/cipher-keys.php", "<?php\n    \$ciphers = [\n        \"cookies\" => \"$ciphers_array[cookies]\",\n        \"database\" => \"$ciphers_array[database]\",\n        \"signature\" => \"$ciphers_array[signature]\",\n    ];\n?>")) {
                        $db = new mysqli($_POST["database"]["host"], $_POST["database"]["login"], $_POST["database"]["password"], $_POST["database"]["database"]);
                        $user = [
                            "login" => hash("SHA256", $_POST["admin"]["login"]),
                            "password" => password_hash($_POST["admin"]["password"], PASSWORD_DEFAULT),
                            "lastname" => $crypt -> encrypt($_POST["admin"]["lastname"]),
                            "firstname" => $crypt -> encrypt($_POST["admin"]["firstname"]),
                            "patronymic" => !empty($_POST["admin"]["patronymic"]) ? $crypt -> encrypt($_POST["admin"]["patronymic"]) : "",
                            "email" => $crypt -> encrypt($_POST["admin"]["email"]),
                            "telephone" => $crypt -> encrypt($_POST["admin"]["telephone"]),
                            "birthday" => $crypt -> encrypt($_POST["admin"]["birthday"]),
                            "level" => $crypt -> encrypt(json_encode([0])),
                        ];
                        $db -> query("INSERT INTO `main_users` (`firstname`, `lastname`, `patronymic`, `email`, `telephone`, `birthday`) VALUES ('$user[firstname]', '$user[lastname]', '$user[patronymic]', '$user[email]', '$user[telephone]', '$user[birthday]');");
                        $id = $db -> insert_id;
                        $db -> query("INSERT INTO `main_user_auth` (`login`, `password`, `levels`, `usersId`) VALUES ('$user[login]', '$user[password]', '$user[level]', $id);");
                        $db -> close();
                        echo json_encode([
                            "status" => "OK",
                        ]);
                    } else
                        echo json_encode([
                            "status" => "FAILED_TO_CREATE_INI",

                        ]);
                } else
                    echo json_encode([
                        "status" => "SOME_DATA_IS_EMPTY",
                        "nesting" => 1,
                    ]);
            } else
                echo json_encode([
                    "status" => "SOME_DATA_IS_EMPTY",
                    "nesting" => 0,
                ]);
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
    }
?>