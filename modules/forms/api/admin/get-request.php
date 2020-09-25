<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        require __DIR__ . "/../../../../libraries/users.php";
        $user = new user($_POST["token"]);
        if ($user -> check_level(2001)) {
            require __DIR__ . "/../../../../configurations/database/class.php";
            
            $database -> close();
        } else
            echo json_encode([
                "status" => "ACCESS_DENIED",
            ]);
    } else
        echo json_encode([
            "status" => "ACCESS_DENIED",
        ]);
?>
