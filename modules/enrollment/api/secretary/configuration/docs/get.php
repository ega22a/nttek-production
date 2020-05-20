<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["type"])) {
            require __DIR__ . "/../../../../../../libraries/users.php";
            $_user = new user($_POST["token"]);
            if ($_user -> check_level(1001)) {
                require __DIR__ . "/../../../../php/docs.php";
                switch ($_POST["type"]) {
                    case "operational":
                        if (isset($_POST["enrollee"])) {
                            echo json_encode([
                                "status" => "OK",
                                "doc" => base64_encode(operationalSummary($_user, $_POST["enrollee"])),
                            ]);
                        } else
                            echo json_encode([
                                "status" => "ENROLLEE_IS_EMPTY",
                            ]);
                    break;
                    case "enrollee":
                        if (isset($_POST["enrollee"])) {
                            echo json_encode([
                                "status" => "OK",
                                "doc" => base64_encode(listOfEnrollees($_user, $_POST["enrollee"])),
                            ]);
                        } else
                            echo json_encode([
                                "status" => "ENROLLEE_IS_EMPTY",
                            ]);
                    break;
                    case "analysis":
                        echo json_encode([
                            "status" => "OK",
                            "doc" => base64_encode(analysisOfNames($_user)),
                        ]);
                    break;
                    case "hostel":
                        echo json_encode([
                            "status" => "OK",
                            "doc" => base64_encode(listOfHostel($_user)),
                        ]);
                    break;
                    default:
                        echo json_encode([
                            "status" => "TYPE_IS_WRONG",
                        ]);
                    break;
                }
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
        } else
            echo json_encode([
                "status" => "ID_IS_EMPTY",
            ]);
    }
?>
