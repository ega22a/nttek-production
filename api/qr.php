<?php
    require __DIR__ . "/../libraries/phpqrcode/qrlib.php";
    QRCode::png(strval($_GET["text"]), false, "", 5);
?>