<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../../../libraries/users.php";
    if (!empty($_POST["token"]) && !empty($_POST["id"]) && !empty($_POST["data"])) {
        $users = new user($_POST["token"]);
        if ($users -> _isFound && $users -> check_level(0)) {
            $data = json_decode($_POST["data"]);
            $thumb = [];
            if (isset($data -> lastname))
                $thumb["lastname"] = $data -> lastname;
            if (isset($data -> firstname))
                $thumb["firstname"] = $data -> firstname;
            if (isset($data -> patronymic))
                $thumb["patronymic"] = $data -> patronymic;
            if (isset($data -> birthday))
                $thumb["birthday"] = $data -> birthday;
            if (isset($data -> email))
                $thumb["email"] = $data -> email;
            if (isset($data -> telephone))
                $thumb["telephone"] = $data -> telephone;
            if (isset($data -> login))
                $thumb["login"] = $data -> login;
            if (isset($data -> password))
                $thumb["password"] = $data -> password;
            if (isset($data -> levels))
                $thumb["levels"] = $data -> levels;
            echo json_encode([
                "status" => $users -> edit($thumb, intval($_POST["id"])),
            ]);
        } else
            echo json_encode([
                "status" => "ADMIN_IS_NOT_FOUND",
            ]);
        $users -> c();
    } else
        echo json_encode([
            "status" => "SOME_DATA_IS_EMPTY",
        ]);
?>