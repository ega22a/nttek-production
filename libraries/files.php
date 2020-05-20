<?php
    class files {
        private $absolute = "";
        private $trueAbsolute = "";
        private $mimes = [];
        private $levels = [];

        public function __construct(string $path = "") {
            if (!empty($path))
                $this -> absolute = json_decode(file_get_contents(__DIR__ . "/../configurations/json/about.json")) -> absolutePath . $path;
            else
                $this -> absolute = json_decode(file_get_contents(__DIR__ . "/../configurations/json/about.json")) -> absolutePath;
            $this -> mimes = json_decode(file_get_contents(__DIR__ . "/../configurations/json/mimes.json"));
            $this -> levels = json_decode(file_get_contents(__DIR__ . "/../configurations/json/levels.json"));
            $this -> trueAbsolute = json_decode(file_get_contents(__DIR__ . "/../configurations/json/about.json")) -> absolutePath;
            $thumb = [];
            foreach ($this -> levels as $value)
                $thumb[] = $value -> level;
            $this -> levels = $thumb;
        }

        public function setPath(string $path = "") {
            if (!empty($path)) {
                $this -> absolute = $this -> trueAbsolute . $path;
                return true;
            } else
                return false;
        }

        public function upload(array $_file = [], string $_name = "", bool $_isCommon = true, array $_shared = []) {
            if (!empty($_file)) {
                if (!empty($_name)) {
                    $mime = [
                        "ok" => false,
                        "extension" => NULL,
                    ];
                    foreach ($this -> mimes as $value)
                        if ($value -> mime == $_file["type"])
                            $mime = [
                                "ok" => true,
                                "extension" => $value -> extension,
                            ];
                    if ($mime["ok"]) {
                        if ($_file["size"] > 2000 && $_file["size"] < 15000000) {
                            if ($_isCommon) {
                                $thumbname = md5(strval(time()) . $_name . strval(microtime())) . $mime["extension"];
                                if (move_uploaded_file($_file["tmp_name"], $this -> absolute . "/{$thumbname}")) {
                                    require __DIR__ . "/../configurations/database/class.php";
                                    $_name = strval($database -> real_escape_string($_name));
                                    $database -> query("INSERT INTO `main_files` (`name`, `mime`, `path`, `isCommon`) VALUES ('{$_name}', '{$_file["type"]}', '{$this -> absolute}/{$thumbname}', 1);");
                                    if (empty($database -> error))
                                        return $database -> insert_id;
                                    else {
                                        unlink($this -> absolute . "/{$thumbname}");
                                        return $database -> error;
                                    }
                                    $database -> close();
                                } else
                                    return "FILE_DOES_NOT_UPLOAD";
                            } else {
                                $levels_ok = true;
                                foreach ($_shared as $value)
                                    if (!in_array($value, $this -> levels))
                                        $levels_ok = false;
                                if ($levels_ok) {
                                    $thumbname = md5(strval(time()) . $_name . strval(microtime())) . $mime["extension"];
                                    if (move_uploaded_file($_file["tmp_name"], $this -> absolute . "/{$thumbname}")) {
                                        require __DIR__ . "/../configurations/database/class.php";
                                        $_name = strval($database -> real_escape_string($_name));
                                        $_isCommon = 1;
                                        $_shared = $database -> real_escape_string(json_encode($_shared));
                                        $database -> query("INSERT INTO `main_files` (`name`, `mime`, `path`, `isCommon`, `shared`) VALUES ('{$_name}', '{$_file["type"]}', '{$this -> absolute}/{$thumbname}', 0, '{$_shared}');");
                                        if (empty($database -> error))
                                            return $database -> insert_id;
                                        else {
                                            unlink($this -> absolute . "/{$thumbname}");
                                            return $database -> error;
                                        }
                                        $database -> close();
                                    } else
                                        return "FILE_DOES_NOT_UPLOAD";
                                } else
                                    return "LEVELS_DOES_NOT_CORRECT";
                            }
                        } else
                            return "WRONG_FILE_SIZE";
                    } else
                        return "NOT_GRANTED_MIME_TYPE";
                } else
                    return "EMPTY_FILE_NAME";
            } else
                return "EMPTY_FILE_DATA";
        }

        public function delete(int $_id) {
            if (!empty($_id)) {
                require __DIR__ . "/../configurations/database/class.php";
                $file = $database -> query("SELECT `path` FROM `main_files` WHERE `id` = {$_id};");
                if ($file -> num_rows != 0) {
                    $file = $file -> fetch_assoc()["path"];
                    $database -> query("DELETE FROM `main_files` WHERE `id` = {$_id};");
                    unlink($file);
                    return "OK";
                } else
                    return "FILE_IS_NOT_FOUND";
                $database -> close();
            } else
                return "ID_IS_EMPTY";
        }

        public function update(int $_id = 0, $_file = [], string $_name = "", $_isCommon = NULL, array $_shared = []) {
            if (!empty($_id)) {
                require __DIR__ . "/../configurations/database/class.php";
                $file = $database -> query("SELECT `path` FROM `main_files` WHERE `id` = {$_id};");
                if ($file -> num_rows != 0) {
                    $file = $file -> fetch_assoc()["path"];
                    $returned = [];
                    if (!empty($_file)) {
                        $mime = [
                            "ok" => false,
                            "extension" => NULL,
                        ];
                        foreach ($this -> mimes as $value)
                            if ($value -> mime == $_file["type"])
                                $mime = [
                                    "ok" => true,
                                    "extension" => $value -> extension,
                                ];
                        if ($mime["ok"]) {
                            if ($_file["size"] > 2000 && $_file["size"] < 15000000) {
                                $thumbname = md5(strval(time()) . $_name . strval(microtime())) . $mime["extension"];
                                if (move_uploaded_file($_file["tmp_name"], $this -> absolute . "/{$thumbname}")) {
                                    $database -> query("UPDATE `main_files` SET `path` = '{$this -> absolute}/{$thumbname}', `mime` = '{$_file["type"]}' WHERE `id` = {$_id};");
                                    if (!empty($database -> error))
                                        $returned[] =  $database -> error;
                                    unlink($file);
                                } else
                                    $returned[] = "FILE_DOES_NOT_UPLOAD";
                            } else
                                $returned[] = "WRONG_FILE_SIZE";
                        } else
                            $returned[] = "NOT_GRANTED_MIME_TYPE";
                    }
                    if (!empty($_name)) {
                        $_name = $database -> real_escape_string(strval($_name));
                        $database -> query("UPDATE `main_files` SET `name` = '$_name' WHERE `id` = {$_id};");
                        if (!empty($database -> error))
                            $returned[] = "NAME_IS_NOT_EDITED";
                    }
                    if (!empty($_isCommon)) {
                        if ($_isCommon) {
                            $database -> query("UPDATE `main_flies` SET `isCommon` = 1, `shared` = NULL WHERE `id` = {$_id};");
                            if (!empty($database -> error))
                                $returned[] = "COMMON_ATTRIBUTE_IS_NOT_SET";
                        } else {
                            if (!empty($_shared)) {
                                $levels_ok = true;
                                foreach ($_shared as $value)
                                    if (!in_array($value, $this -> levels))
                                        $levels_ok = false;
                                if ($levels_ok) {
                                    $_shared = json_encode($_shared);
                                    $database -> query("UPDATE `main_files` SET `isCommon` = 0, `levels` = '{$_shared}' WHERE `id` = {$_id};");
                                } else
                                    $returned[] = "LEVELS_DOES_NOT_CORRECT";
                            } else
                                $returned[] = "LEVELS_ARE_EMPTY";
                        }
                    }
                    if (!empty($returned))
                        return [
                            "status" => "ERRORS",
                            "errors" => $returned,
                        ];
                    else
                        return "OK";
                } else
                    return "FILE_IS_NOT_FOUND";
                $database -> close();
            } else
                return "ID_IS_EMPTY";
        }

        public function get(int $_id = 0, int $_level = -1) {
            if (!empty($_id)) {
                require __DIR__ . "/../configurations/database/class.php";
                $f = $database -> query("SELECT * FROM `main_files` WHERE `id` = {$_id};");
                if ($f -> num_rows != 0) {
                    $f = $f -> fetch_assoc();
                    if (!boolval($f["isCommon"])) {
                        if (in_array($_level, json_decode($f["shared"])))
                            return [
                                "id" => $f["id"],
                                "name" => $f["name"],
                                "mime" => $f["mime"],
                                "path" => $f["path"],
                            ];
                        else
                            return "ACCESS_DENIED";
                    } else
                        return [
                            "id" => $f["id"],
                            "name" => $f["name"],
                            "mime" => $f["mime"],
                            "path" => $f["path"],
                        ];
                } else
                    return "FILE_IS_NOT_FOUND";
                $database -> close();
            } else
                return "ID_IS_EMPTY";
        }
        public function download(int $_id = 0, int $_level = -1) {
            $f = $this -> get($_id, $_level);
            if (is_array($f)) {
                if (ob_get_level())
                    ob_end_clean();
                header("Content-Description: File Transfer");
                header("Content-Type: {$f["mime"]}");
                header("Content-Disposition: inline; filename=" . basename($f["path"]));
                header("Content-Transfer-Encoding: binary");
                header("Expires: 0");
                header("Cache-Control: must-revalidate");
                header("Pragma: public");
                header("Content-Length: " . filesize($f["path"]));
                if ($fd = fopen($f["path"], 'rb')) {
                    while (!feof($fd))
                        echo fread($fd, 1024);
                    fclose($fd);
                }
            } else
                switch ($f) {
                    case "ACCESS_DENIED":
                        http_response_code(403);
                    break;
                    case "FILE_IS_NOT_FOUND":
                        http_response_code(404);
                    break;
                    case "ID_IS_EMPTY":
                        http_response_code(500);
                    break;
                }
        }
        public function createFolder(string $_path = "") {
            if (!empty($_path)) {
                if (!file_exists($this -> absolute . $_path))
                    return mkdir($this -> absolute . $_path, 0777, true);
            } else
                return false;
        }
    }
?>