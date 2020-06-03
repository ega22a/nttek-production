<?php
    define("CONFIG_PATH", __DIR__ . "/main.php");
    define("EMAIL", __DIR__ . "/email/class.php");
    define("DATABASE", __DIR__ . "/database/class.php");
    define("CIPHER_KEYS", __DIR__ . "/cipher-keys.php");
    define("GOOGLE_API_KEY", "AIzaSyBnMGKjEna2m2NyfIGCKFe-f6utGAs58fM");
    
    require(__DIR__ . "/../libraries/template-engine.php");

    function checkConfigurations() {
        return boolval(filesize(__DIR__ . "/email/auth.ini")) && boolval(filesize(__DIR__ . "/database/auth.ini")) && boolval(filesize(CIPHER_KEYS)) ? true : false;
    }
?>