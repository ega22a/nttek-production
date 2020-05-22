<?php
    class configuration {
        public function create(string $_path, array $_data) {
            if (!empty($_data)) {
                $_input = "";
                foreach ($_data as $key => $value)
                    $_input .= "$key = $value\n";
                return file_put_contents($_path, $_input) ? true : false;
            } else
                return false;
        }
        public function update(string $_path, array $_data) {
            if ($_file = parse_ini_file($_path)) {
                $_new_ini = "";
                foreach ($_file as $key => $value) {
                    if (array_key_exists($key, $_data)) {
                        $_new_ini .= "$key = $_data[$key]\n";
                        unset($_data[$key]);
                    } else
                        $_new_ini .= "$key = $value\n";
                }
                if (!empty($_data))
                    foreach ($_data as $key => $value)
                        $_new_ini .= "$key = $value\n";
                return file_put_contents($_path, $_new_ini) ? true : false;
            } else
                return false;
        }
        public function erase(string $_path) {
            return file_put_contents($_path, "") ? true : false;
        }
        public function get(string $_path) {
            return parse_ini_file($_path);
        }
    }

    class cryptService {
        private $_k;
        private static $encryptMethod = 'AES-256-CBC';
        private $key;
        private $iv;
        public function __construct(string $_k) {
            $this -> k = $_k;
            $this -> key = hash('sha256', $_k);
            $this -> iv = substr(hash('sha256', $_k), 0, 16);
        }
        public function decrypt(string $_string){
            return openssl_decrypt(base64_decode($_string), self::$encryptMethod, $this -> key, 0, $this -> iv);
        }
        public function encrypt(string $_string){
            return base64_encode(openssl_encrypt($_string, self::$encryptMethod, $this -> key, 0, $this -> iv));
        }
    }

    function create_random_string(int $_length = 6) {
        $_alphabet = str_split("qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM");
        $_return = "";
        for ($i = 0; $i < $_length; $i++)
            $_return .= $_alphabet[random_int(0, count($_alphabet))];
        return $_return;
    }
?>