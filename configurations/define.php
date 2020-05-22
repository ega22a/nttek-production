<?php
    define("CONFIG_PATH", __DIR__ . "/main.php");
    define("EMAIL", __DIR__ . "/email/class.php");
    define("DATABASE", __DIR__ . "/database/class.php");
    define("CIPHER_KEYS", __DIR__ . "/cipher-keys.php");
    
    require(__DIR__ . "/../libraries/template-engine.php");

    function checkConfigurations() {
        return boolval(filesize(__DIR__ . "/email/auth.ini")) && boolval(filesize(__DIR__ . "/database/auth.ini")) && boolval(filesize(CIPHER_KEYS)) ? true : false;
    }
?>