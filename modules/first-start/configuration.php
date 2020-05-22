<?php
    require __DIR__ . "/../../configurations/define.php";
    define("ALLOWED_IPS", ["127.0.0.1", "::1", "31.25.29.6"]);
    define("CLIENT_IP", $_SERVER["REMOTE_ADDR"]);
?>
