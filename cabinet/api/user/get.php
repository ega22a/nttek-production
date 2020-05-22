<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../../libraries/users.php";
    if (!empty($_POST["token"])) {
        $users = new user($_POST["token"]);
        if ($users -> _isFound)
            echo json_encode([
                "status" => "OK",
                "user" => $users -> getDecrypted(),
            ]);
        else
            echo json_encode([
                "status" => "USER_IS_NOT_FOUND",
            ]);
        $users -> c();
    } else
        echo json_encode([
            "status" => "SOME_DATA_IS_EMPTY",
        ]);
?>