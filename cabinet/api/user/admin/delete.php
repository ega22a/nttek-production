<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../../../libraries/users.php";
    if (!empty($_POST["token"]) && !empty($_POST["id"])) {
        $users = new user($_POST["token"]);
        if ($users -> _isFound && $users -> check_level(0))
            echo json_encode(
                [
                    "status" => $users -> delete(strval($_POST["id"]))
                ]);
        else
            echo json_encode([
                "status" => "ADMIN_IS_NOT_FOUND",
            ]);
        $users -> c();
    } else
        echo json_encode([
            "status" => "SOME_DATA_IS_EMPTY",
        ]);
?>