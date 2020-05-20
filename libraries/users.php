<?php
    class user {
        private $_db;
        public $_authId;
        private $_encrypt;
        private $_cipher_key;
        public $_isFound = true;
        public function __construct(string $_token = "") {
            require __DIR__ . "/../configurations/database/class.php";
            require __DIR__ . "/../configurations/main.php";
            require __DIR__ . "/../configurations/cipher-keys.php";
            $this -> _encrypt = new cryptService($ciphers["database"]);
            $this -> _cipher_key = $ciphers["database"];
            $this -> _db = $database;
            if (!empty($_token)) {
                $_tkn = $this -> _encrypt -> decrypt($_token);
                $user = $this -> _db -> query("SELECT `id` FROM `main_user_auth` WHERE `token` = '$_tkn';");
                if ($user -> num_rows != 0)
                    $this -> _authId = $user -> fetch_assoc()["id"];
                else
                    $this -> _isFound = !$this -> _isFound;
            }
        }
        public function c() {
            $this -> _db -> close();
        }
        public function auth(string $login, string $password) {
            if (!empty($login) && !empty($password)) {
                $login = hash("SHA256", $login);
                $user = $this -> _db -> query("SELECT `id`, `password`, `token` FROM `main_user_auth` WHERE `login` = '$login';");
                if ($user -> num_rows == 1) {
                    $user = $user -> fetch_assoc();
                    if (password_verify($password, $user["password"])) {
                        $this -> _authId = $user["id"];
                        if (!empty($user["token"]))
                            return $this -> _encrypt -> encrypt($user["token"]);
                        else {
                            $thumb_token = bin2hex(random_bytes(256));
                            while ($this -> _db -> query("SELECT `id` FROM `main_user_auth` WHERE `token` = '$thumb_token';") -> num_rows != 0)
                                $thumb_token = bin2hex(random_bytes(256));
                            $this -> _db -> query("UPDATE `main_user_auth` SET `token` = '$thumb_token' WHERE `id` = {$this -> _authId};");
                            return $this -> _encrypt -> encrypt($thumb_token);
                        }
                    } else
                        return "PASSWORD_DO_NOT_MATCH";
                } else
                    return "USER_NOT_FOUND";
            } else
                return "EMPTY_LOGIN_OR_PASSWORD";
        }
        public function exit() {
            if (!empty($this -> _authId)) {
                $this -> _db -> query("UPDATE `main_user_auth` SET `token` = NULL WHERE `id` = {$this -> _authId};");
                $this -> _authId = NULL;
                return true;
            } else
                return false;
        }
        public function edit(array $data, int $userId = 0) {
            if (!empty($this -> _authId)) {
                if ($userId == 0)
                    $userId = $this -> _authId;
                $userId = intval($userId);
                $user = $this -> _db -> query("SELECT `main_users`.`id`, `lastname`, `firstname`, `patronymic`, `birthday`, `email`, `telephone`, `login`, `password`, `levels` FROM `main_users` INNER JOIN `main_user_auth` ON `main_user_auth`.`usersId` = `main_users`.`id` WHERE `main_user_auth`.`id` = {$userId};");
                if ($user -> num_rows != 0) {
                    $sql = [
                        "auth" => "",
                        "user" => "",
                    ];
                    $user = $user -> fetch_assoc();
                    if (!empty($data["login"])) {
                        $data["login"] = hash("SHA256", $data["login"]);
                        if ($this -> _db -> query("SELECT `id` FROM `main_user_auth` WHERE `login` = '{$data["login"]}';") -> num_rows != 0) {
                            return "LOGIN_IS_NOT_UNIQUE";
                            exit;
                        }
                        $sql["auth"] .= "`login` = '{$data["login"]}', ";
                    }
                    if (!empty($data["password"])) {
                        if (strlen($data["password"]) < 8) {
                            return "PASSWORD_IS_TINY";
                            exit;
                        }
                        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
                        $sql["auth"] .= "`password` = '{$data["password"]}', ";
                    }
                    if (!empty($data["levels"]) && $this -> _authId != 1) {
                        if (!is_array($data["levels"])) {
                            return "LEVELS_MUST_BE_ARRAY";
                            exit;
                        }
                        $data["levels"] = $this -> _encrypt -> encrypt(json_encode($data["levels"]));
                        $sql["auth"] .= "`levels` = '{$data["levels"]}', ";
                    }
                    if (!empty($data["lastname"])) {
                        $data["lastname"] = $this -> _encrypt -> encrypt($data["lastname"]);
                        $sql["user"] .= "`lastname` = '{$data["lastname"]}', ";
                    }
                    if (!empty($data["firstname"])) {
                        $data["firstname"] = $this -> _encrypt -> encrypt($data["firstname"]);
                        $sql["user"] .= "`firstname` = '{$data["firstname"]}', ";
                    }
                    if (!empty($data["patronymic"])) {
                        $data["patronymic"] = $this -> _encrypt -> encrypt($data["patronymic"]);
                        $sql["user"] .= "`patronymic` = '{$data["patronymic"]}', ";
                    }
                    if (!empty($data["birthday"])) {
                        $data["birthday"] = $this -> _encrypt -> encrypt($data["birthday"]);
                        $sql["user"] .= "`birthday` = '{$data["birthday"]}', ";
                    }
                    if (!empty($data["email"])) {
                        $data["email"] = $this -> _encrypt -> encrypt($data["email"]);
                        $sql["user"] .= "`email` = '{$data["email"]}', ";
                    }
                    if (!empty($data["telephone"])) {
                        $data["telephone"] = $this -> _encrypt -> encrypt($data["telephone"]);
                        $sql["user"] .= "`telephone` = '{$data["telephone"]}', ";
                    }
                    if (!empty($sql["auth"])) {
                        $sql["auth"] = substr($sql["auth"], 0, -2);
                        $this -> _db -> query("UPDATE `main_user_auth` SET {$sql["auth"]} WHERE `id` = {$userId};");
                    }
                    if (!empty($sql["user"])) {
                        $sql["user"] = substr($sql["user"], 0, -2);
                        $this -> _db -> query("UPDATE `main_users` SET {$sql["user"]} WHERE `id` = {$user["id"]};");
                    }
                    return "OK";
                } else
                    return "USER_IS_NOT_FOUND";
            } else
                return false;
        }
        public function check_level(int $level) {
            if (!empty($this -> _authId)) {
                $levels = json_decode($this -> _encrypt -> decrypt($this -> _db -> query("SELECT `levels` FROM `main_user_auth` WHERE `id` = {$this -> _authId};") -> fetch_assoc()["levels"]));
                return in_array($level, $levels);
            } else
                return false;
        }
        public function getDecrypted() {
            if (!empty($this -> _authId)) {
                $user = $this -> _db -> query("SELECT `firstname`, `lastname`, `patronymic`, `birthday`, `email`, `telephone`, `levels` FROM `main_users` INNER JOIN `main_user_auth` ON `main_users`.`id` = `main_user_auth`.`usersId` WHERE `main_user_auth`.`id` = {$this -> _authId};");
                $user = $user -> fetch_assoc();
                $thumb = [
                    "firstname" => $this -> _encrypt -> decrypt($user["firstname"]),
                    "lastname" => $this -> _encrypt -> decrypt($user["lastname"]),
                    "patronymic" => $this -> _encrypt -> decrypt($user["patronymic"]),
                    "birthday" => $this -> _encrypt -> decrypt($user["birthday"]),
                    "email" => $this -> _encrypt -> decrypt($user["email"]),
                    "telephone" => $this -> _encrypt -> decrypt($user["telephone"]),
                    "levels" => json_decode($this -> _encrypt -> decrypt($user["levels"])),
                ];
                return $thumb;
            } else
                return false;
        }
        public function register(array $data) {
            if (!empty($this -> _authId)) {
                if ($this -> check_level(0)) {
                    if (!empty($data["login"]) && !empty($data["password"]) && !empty($data["levels"]) && !empty($data["firstname"]) && !empty($data["lastname"]) && !empty($data["birthday"]) && !empty($data["email"]) && !empty($data["telephone"])) {
                        if (strlen($data["password"]) > 8) {
                            $login = hash("SHA256", $data["login"]);
                            if ($this -> _db -> query("SELECT `id` FROM `main_user_auth` WHERE `login` = '$login';") -> num_rows == 0) {
                                $valid = [];
                                foreach (json_decode(file_get_contents(__DIR__ . "/../configurations/json/levels.json")) as $value)
                                    $valid[] = $value -> level;
                                $levels = [];
                                foreach ($data["levels"] as $value) {
                                    if (in_array($value, $valid))
                                        $levels[] = intval($value);
                                    else {
                                        return "LEVEL_OUT_OF_RANGE";
                                        exit;
                                    }
                                }
                                $thumb = [
                                    "login" => $login,
                                    "password" => password_hash($data["password"], PASSWORD_DEFAULT),
                                    "levels" => $this -> _encrypt -> encrypt(json_encode($levels)),
                                    "firstname" => $this -> _encrypt -> encrypt($data["firstname"]),
                                    "lastname" => $this -> _encrypt -> encrypt($data["lastname"]),
                                    "patronymic" => $this -> _encrypt -> encrypt($data["patronymic"]),
                                    "birthday" => $this -> _encrypt -> encrypt($data["birthday"]),
                                    "email" => $this -> _encrypt -> encrypt($data["email"]),
                                    "telephone" => $this -> _encrypt -> encrypt($data["telephone"]),
                                ];
                                $this -> _db -> query("INSERT INTO `main_users` (`firstname`, `lastname`, `patronymic`, `birthday`, `email`, `telephone`) VALUES ('$thumb[firstname]', '$thumb[lastname]', '$thumb[patronymic]', '$thumb[birthday]', '$thumb[email]', '$thumb[telephone]');");
                                $t_id = $this -> _db -> insert_id;
                                $this -> _db -> query("INSERT INTO `main_user_auth` (`login`, `password`, `levels`, `usersId`) VALUES ('$thumb[login]', '$thumb[password]', '$thumb[levels]', $t_id);");
                                return true;
                            } else
                                return "LOGIN_IS_NOT_UNIQUE";
                        } else
                            return "TINY_PASSWORD";
                    } else
                        return "SOME_DATA_IS_EMPTY";
                } else
                    return "ACCESS_DENIED";
            } else
                return false;
        }
        public function delete($id) {
            if (!empty($this -> _authId)) {
                if ($this -> check_level(0)) {
                    $parsed = intval($id);
                    if ($parsed != 1)
                        $this -> _db -> multi_query("DELETE FROM `main_user_auth` WHERE `usersId` = $parsed; DELETE FROM `main_users` WHERE `id` = $parsed;");
                    return true;
                } else
                    return false;
            } else
                return false;
        }

        public function get_all_users() {
            if (!empty($this -> _authId)) {
                if ($this -> check_level(0)) {
                    $users = $this -> _db -> query("SELECT `main_users`.`id`, `firstname`, `lastname`, `patronymic`, `birthday`, `email`, `telephone`, `levels` FROM `main_users` INNER JOIN `main_user_auth` ON `main_users`.`id` = `main_user_auth`.`usersId`;");
                    $return = [];
                    while ($row = $users -> fetch_assoc()) {
                        $return[] = [
                            "id" => $row["id"],
                            "firstname" => $this -> _encrypt -> decrypt($row["firstname"]),
                            "lastname" => $this -> _encrypt -> decrypt($row["lastname"]),
                            "patronymic" => $this -> _encrypt -> decrypt($row["patronymic"]),
                            "birthday" => $this -> _encrypt -> decrypt($row["birthday"]),
                            "email" => $this -> _encrypt -> decrypt($row["email"]),
                            "telephone" => $this -> _encrypt -> decrypt($row["telephone"]),
                            "levels" => json_decode($this -> _encrypt -> decrypt($row["levels"])),
                        ];
                    }
                    return $return;
                } else
                    return false;
            } else
                return false;
        }

        public function check_login(string $_login) {
            if (!empty($this -> _authId)) {
                if ($this -> check_level(0)) {
                    $login = hash("SHA256", $data["login"]);
                    if ($this -> _db -> query("SELECT `id` FROM `main_user_auth` WHERE `login` = '$login';") -> num_rows == 0)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;
        }
    }
?>
