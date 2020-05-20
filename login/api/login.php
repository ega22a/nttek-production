<?php
    header("Content-type: application/json");
    require __DIR__ . "/../../libraries/users.php";
    $users = new user();
    if (!empty($_POST["login"]) && !empty($_POST["password"])) {
        $token = $users -> auth($_POST["login"], $_POST["password"]);
        $users -> c();
        echo json_encode([
            "status" => "NEEDLE",
            "message" => $token,
        ]);
    } else
        echo json_encode([
            "status" => "SOME_DATA_IS_EMPTY",
        ]);
?>