<?php
	header("Content-Type: application/json");
	if ($_GET["secret"] == "q1w2e3r4t5y6u7i8o9p0") {
		require __DIR__ . "/../configurations/cipher-keys.php";
		require __DIR__ . "/../configurations/main.php";
		$crypt = new CryptService($ciphers["database"]);
		echo json_encode([
			"status" => "OK",
			"answer" => isset($_GET["question"]) ? (isset($_GET["crypt"]) ? ($crypt -> encrypt($_GET["question"])) : ($crypt -> decrypt($_GET["question"]))) : "",
		]);
	} else
		echo json_encode([
			"status" => "ACCESS_DENIED",
		]);
?>
