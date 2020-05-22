<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../../libraries/users.php";
    if (!empty($_POST["token"]) && !empty($_POST["type"]) && !empty($_POST["content"])) {
        $users = new user($_POST["token"]);
        if ($users -> _isFound) {
            switch (strval($_POST["type"])) {
                case "email":
                    echo json_encode([
                        "status" => $users -> edit(["email" => $_POST["content"]]),
                    ]);
                break;
                case "telephone":
                    echo json_encode([
                        "status" => $users -> edit(["telephone" => $_POST["content"]]),
                    ]);
                break;
                case "login":
                    echo json_encode([
                        "status" => $users -> edit(["login" => $_POST["content"]]),
                    ]);
                break;
                case "password":
                    echo json_encode([
                        "status" => $users -> edit(["password" => $_POST["content"]]),
                    ]);
                break;
            }
        } else
            echo json_encode([
                "status" => "USER_IS_NOT_FOUND",
            ]);
        $users -> c();
    } else
        echo json_encode([
            "status" => "SOME_DATA_IS_EMPTY",
        ]);
?>