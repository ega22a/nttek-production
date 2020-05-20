<?php
    header("Content-Type: application/json");
    if (isset($_POST["token"])) {
        if (isset($_POST["statement"])) {
            require __DIR__ . "/../../../../../libraries/users.php";
            $user = new user($_POST["token"]);
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                $statement_id = intval($_POST["statement"]);
                require __DIR__ . "/../../../../../configurations/database/class.php";
                $statement = $database -> query("SELECT * FROM `enr_statements` WHERE `id` = {$statement_id} AND `usersId` IS NOT NULL;");
                if ($statement -> num_rows == 1) {
                    $statement = $statement -> fetch_assoc();
                    require __DIR__ . "/../../../../../configurations/cipher-keys.php";
                    require_once __DIR__ . "/../../../../../configurations/main.php";
                    $crypt = new CryptService($ciphers["database"]);
                    $sql = "";
                    $granted = true;
                    if ($statement["educationalType"] == "fulltime") {
                        $parents = [
                            "mother" => !empty($statement["mother"]) ? json_decode($crypt -> decrypt($statement["mother"])) : NULL,
                            "father" => !empty($statement["father"]) ? json_decode($crypt -> decrypt($statement["father"])) : NULL,
                            "representative" => !empty($statement["representative"]) ? json_decode($crypt -> decrypt($statement["representative"])) : NULL,
                        ];
                        foreach ($parents as $key => $value) {
                            $concat = [];
                            if (!empty($value)) {
                                $concat = [
                                    "firstname" => isset($_POST["{$key}-firstname"]) ? $database -> real_escape_string($_POST["{$key}-firstname"]) : $value -> firstname,
                                    "lastname" => isset($_POST["{$key}-lastname"]) ? $database -> real_escape_string($_POST["{$key}-lastname"]) : $value -> lastname,
                                    "patronymic" => isset($_POST["{$key}-patronymic"]) ? $database -> real_escape_string($_POST["{$key}-patronymic"]) : $value -> patronymic,
                                    "jobName" => isset($_POST["{$key}-job-name"]) ? $database -> real_escape_string($_POST["{$key}-job-name"]) : $value -> jobName,
                                    "jobPosition" => isset($_POST["{$key}-job-position"]) ? $database -> real_escape_string($_POST["{$key}-job-position"]) : $value -> jobPosition,
                                    "jobTelephone" => isset($_POST["{$key}-job-telephone"]) ? $database -> real_escape_string($_POST["{$key}-job-telephone"]) : $value -> jobTelephone,
                                    "telephone" => isset($_POST["{$key}-telephone"]) ? $database -> real_escape_string($_POST["{$key}-telephone"]) : $value -> telephone,
                                ];
                                if ($key == "representative")
                                    $concat["who"] = isset($_POST["{$key}-who"]) ? $database -> real_escape_string($_POST["{$key}-who"]) : $value["who"];
                            } else {
                                $concat = [
                                    "firstname" => isset($_POST["{$key}-firstname"]) ? $database -> real_escape_string($_POST["{$key}-firstname"]) : NULL,
                                    "lastname" => isset($_POST["{$key}-lastname"]) ? $database -> real_escape_string($_POST["{$key}-lastname"]) : NULL,
                                    "patronymic" => isset($_POST["{$key}-patronymic"]) ? $database -> real_escape_string($_POST["{$key}-patronymic"]) : NULL,
                                    "jobName" => isset($_POST["{$key}-job-name"]) ? $database -> real_escape_string($_POST["{$key}-job-name"]) : NULL,
                                    "jobPosition" => isset($_POST["{$key}-job-position"]) ? $database -> real_escape_string($_POST["{$key}-job-position"]) : NULL,
                                    "jobTelephone" => isset($_POST["{$key}-job-telephone"]) ? $database -> real_escape_string($_POST["{$key}-job-telephone"]) : NULL,
                                    "telephone" => isset($_POST["{$key}-telephone"]) ? $database -> real_escape_string($_POST["{$key}-telephone"]) : NULL,
                                ];
                                if ($key == "representative")
                                    $concat["who"] = isset($_POST["{$key}-who"]) ? $database -> real_escape_string($_POST["{$key}-who"]) : NULL;
                            }
                            $counter = 0;
                            foreach ($concat as $sub_value)
                                if (empty($sub_value))
                                    $counter++;
                            if ($counter != count($concat))
                                $sql .= "`{$key}` = '{$crypt -> encrypt(json_encode($concat))}', ";
                            else
                                $sql .= "`{$key}` = NULL, ";
                        }
                    } elseif ($statement["educationalType"] == "extramural") {
                        if (isset($_POST["job-name"]))
                            if (!empty($_POST["job-name"]))
                                $sql .= "`work` = '{$crypt -> encrypt($database -> real_escape_string($_POST["job-name"]))}', ";
                            else
                                $sql .= "`work` = NULL, ";
                        if (isset($_POST["job-position"]))
                            if (!empty($_POST["job-position"]))
                                $sql .= "`position` = '{$crypt -> encrypt($database -> real_escape_string($_POST["job-position"]))}', ";
                            else
                                $sql .= "`position` = NULL, ";
                        if (isset($_POST["job-years"]))
                            if (!empty($_POST["job-years"]))
                                $sql .= "`workExpirence` = '{$crypt -> encrypt($database -> real_escape_string($_POST["job-years"]))}', ";
                            else
                                $sql .= "`workExpirence` = NULL, ";
                    }
                    if (isset($_POST["lastname"]))
                        if (!empty($_POST["lastname"]))
                            $sql .= "`lastname` = '{$crypt -> encrypt($database -> real_escape_string($_POST["lastname"]))}', ";
                        else
                            $granted = false;
                    if (isset($_POST["firstname"]))
                        if (!empty($_POST["firstname"]))
                            $sql .= "`firstname` = '{$crypt -> encrypt($database -> real_escape_string($_POST["firstname"]))}', ";
                        else
                            $granted = false;
                    if (isset($_POST["patronymic"]))
                        if (!empty($_POST["patronymic"]))
                            $sql .= "`patronymic` = '{$crypt -> encrypt($database -> real_escape_string($_POST["patronymic"]))}', ";
                        else
                            $sql .= "`patronymic` = NULL, ";
                    if (isset($_POST["sex"]))
                        if (!empty($_POST["sex"]))
                            $sql .= "`sex` = " . intval($_POST["sex"]) . ", ";
                        else
                            $granted = false;
                    if (isset($_POST["place-zip-code"]) || isset($_POST["place-country"]) || isset($_POST["place-region"]) || isset($_POST["place-city"]) || isset($_POST["place-street"]) || isset($_POST["place-house"]) || isset($_POST["place-building"]) || isset($_POST["place-flat"])) {
                        $address = json_decode($crypt -> decrypt($statement["address"]));
                        $sql .= "`address` = '" . $crypt -> encrypt(json_encode([
                                "zipCode" => !empty($_POST["place-zip-code"]) ? $database -> real_escape_string($_POST["place-zip-code"]) : $address -> zipCode,
                                "country" => !empty($_POST["place-country"]) ? $database -> real_escape_string($_POST["place-country"]) : $address -> country,
                                "region" => !empty($_POST["place-region"]) ? $database -> real_escape_string($_POST["place-region"]) : $address -> region,
                                "city" => !empty($_POST["place-city"]) ? $database -> real_escape_string($_POST["place-city"]) : $address -> city,
                                "street" => !empty($_POST["place-street"]) ? $database -> real_escape_string($_POST["place-street"]) : $address -> street,
                                "house" => !empty($_POST["place-house"]) ? $database -> real_escape_string($_POST["place-house"]) : $address -> house,
                                "building" => isset($_POST["place-building"]) ? (!empty($_POST["place-building"]) ? $database -> real_escape_string($_POST["place-building"]) : NULL) : $address -> building,
                                "flat" => isset($_POST["place-flat"]) ? (!empty($_POST["place-flat"]) ? $database -> real_escape_string($_POST["place-flat"]) : NULL) : $address -> flat,
                            ])) . "', ";
                    }
                    if (isset($_POST["telephone"]))
                        if (!empty($_POST["telephone"]))
                            $sql .= "`telephone` = '{$crypt -> encrypt($database -> real_escape_string($_POST["telephone"]))}', ";
                        else
                            $granted = false;
                    if (isset($_POST["email"]))
                        if (!empty($_POST["email"]))
                            $sql .= "`email` = '{$crypt -> encrypt($database -> real_escape_string($_POST["email"]))}', ";
                        else
                            $granted = false;
                    if (isset($_POST["birthday"]))
                        if (!empty($_POST["birthday"]))
                            $sql .= "`birthday` = '{$crypt -> encrypt($database -> real_escape_string($_POST["birthday"]))}', ";
                        else
                            $granted = false;
                    if (isset($_POST["birth-country"]) || isset($_POST["birth-region"]) || isset($_POST["birth-city"])) {
                        $birthplace = json_decode($crypt -> decrypt($statement["birthplace"]));
                        $sql .= "`birthplace` = '" . $crypt -> encrypt(json_encode([
                                "country" => !empty($_POST["birth-country"]) ? $database -> real_escape_string($_POST["birth-country"]) : $birthplace -> country,
                                "region" => !empty($_POST["birth-region"]) ? $database -> real_escape_string($_POST["birth-region"]) : $birthplace -> region,
                                "city" => !empty($_POST["birth-city"]) ? $database -> real_escape_string($_POST["birth-city"]) : $birthplace -> city,
                            ])) . "', ";
                    }
                    if (isset($_POST["passport-series"]) || isset($_POST["passport-series"]) || isset($_POST["passport-series"]) || isset($_POST["passport-series"]) || isset($_POST["passport-series"])) {
                        $passport = json_decode($crypt -> decrypt($statement["passport"]));
                        $sql .= "`passport` = '" . $crypt -> encrypt(json_encode([
                                "series" => !empty($_POST["passport-series"]) ? $database -> real_escape_string($_POST["passport-series"]) : $passport -> series,
                                "number" => !empty($_POST["passport-number"]) ? $database -> real_escape_string($_POST["passport-number"]) : $passport -> number,
                                "date" => !empty($_POST["passport-date"]) ? $database -> real_escape_string($_POST["passport-date"]) : $passport -> date,
                                "place" => !empty($_POST["passport-place"]) ? $database -> real_escape_string($_POST["passport-place"]) : $passport -> place,
                                "code" => !empty($_POST["passport-code"]) ? $database -> real_escape_string($_POST["passport-code"]) : $passport -> code,
                            ])) . "', ";
                    }
                    if (isset($_POST["previous-fullname"]))
                        if (!empty($_POST["previous-fullname"]))
                            $sql .= "`previousSchool` = '{$crypt -> encrypt($database -> real_escape_string($_POST["previous-fullname"]))}', ";
                        else
                            $granted = false;
                    if (isset($_POST["previous-date"]))
                        if (!empty($_POST["previous-date"]))
                            $sql .= "`previousSchoolDate` = '{$crypt -> encrypt($database -> real_escape_string($_POST["previous-date"]))}', ";
                        else
                            $granted = false;
                    if (isset($_POST["previous-level"]))
                        if ($database -> query("SELECT `id` FROM `enr_education_levels` WHERE `id` = " . intval($_POST["previous-level"]) . ";") -> num_rows == 1)
                            $sql .= "`degree` = " . intval($_POST["previous-level"]) . ", ";
                        else
                            $granted = false;
                    if (isset($_POST["previous-doc-type"]))
                        if ($database -> query("SELECT `id` FROM `enr_educational_docs` WHERE `id` = " . intval($_POST["previous-doc-type"]) . ";") -> num_rows == 1)
                            $sql .= "`previousSchoolDoc` = " . intval($_POST["previous-doc-type"]) . ", ";
                        else
                            $granted = false;
                    if (isset($_POST["previous-doc-series"]) || isset($_POST["previous-doc-number"]) || isset($_POST["previous-doc-date"])) {
                        $docData = json_decode($crypt -> decrypt($statement["previousSchoolDocData"]));
                        $sql .= "`previousSchoolDocData` = '" . $crypt -> encrypt(json_encode([
                                "series" => !empty($_POST["previous-doc-series"]) ? $database -> real_escape_string($_POST["previous-doc-series"]) : $docData -> series,
                                "number" => !empty($_POST["previous-doc-number"]) ? $database -> real_escape_string($_POST["previous-doc-number"]) : $docData -> number,
                                "date" => !empty($_POST["previous-doc-date"]) ? $database -> real_escape_string($_POST["previous-doc-date"]) : $docData -> date,
                            ])) . "', ";
                    }
                    if (isset($_POST["language"]))
                        if ($database -> query("SELECT `id` FROM `enr_languages` WHERE `id` = " . intval($_POST["language"]) . ";") -> num_rows == 1)
                            $sql .= "`language` = " . intval($_POST["language"]) . ", ";
                        else
                            $granted = false;
                    if (isset($_POST["category-of-citizen"])) {
                        if ($database -> query("SELECT `id` FROM `enr_category_of_citizen` WHERE `id` = " . intval($_POST["category-of-citizen"]) . ";") -> num_rows == 1)
                            $sql .= "`category` = " . intval($_POST["category-of-citizen"]) . ", ";
                        elseif ($_POST["category-of-citizen"] == "-1")
                            $sql .= "`category` = NULL, ";
                        else
                            $granted = false;
                    }
                    if (isset($_POST["home-telephone"]))
                        if (!empty($_POST["home-telephone"]))
                            $sql .= "`homeTelephone` = '{$crypt -> encrypt($database -> real_escape_string($_POST["home-telephone"]))}', ";
                        else
                            $sql .= "`homeTelephone` = NULL, ";
                    if (isset($_POST["pay"]))
                        if (!empty($_POST["pay"]))
                            if (in_array(intval($_POST["pay"]), [1, 2]))
                                $sql .= "`paysType` = {$_POST["pay"]}, ";
                            else
                                $granted = false;
                        else
                            $granted = false;
                    if (isset($_POST["about"]))
                        if (!empty($_POST["about"]) || $_POST["about"] != " ")
                            $sql .= "`about` = '{$crypt -> encrypt($database -> real_escape_string($_POST["about"]))}', ";
                        else
                            $sql .= "`homeTelephone` = ' ', ";
                    if (!empty($sql)) {
                        if (boolval($statement["isOnline"])) {
                            require __DIR__ . "/../../../../../libraries/files.php";
                            $files = new files("");
                            $files_ids = json_decode($crypt -> decrypt($statement["attachedDocsIds"]));
                            $newFiles = [];
                            foreach ($files_ids as $value) {
                                $file = $files -> get(intval($value), 1001);
                                $parsed_path = explode("/", explode("enrollment/enrolles/", $file["path"])[1]);
                                if (in_array($parsed_path[1], ["statement", "hostel"]))
                                    $files -> delete($value);
                                else
                                    $newFiles[] = $value;
                            }
                            $sql .= "`attachedDocsIds` = '{$crypt -> encrypt(json_encode($newFiles))}', `withStatement` = 0, ";
                        }
                        $sql = substr($sql, 0, -2);
                        $database -> query("UPDATE `enr_statements` SET {$sql} WHERE `id` = $statement_id;");
                        echo json_encode([
                            "status" => "OK",
                        ]);
                    } else
                        echo json_encode([
                            "status" => "NOTHING_TO_CHANGE",
                        ]);
                } else
                    echo json_encode([
                        "status" => "STATEMENT_IS_NOT_FOUND",
                    ]);
                $database -> close();
            } else
                echo json_encode([
                    "status" => "ACCESS_DENIED",
                ]);
        } else
            echo json_encode([
                "status" => "STATEMENT_ID_IS_EMPTY",
            ]);
    } else
        echo json_encode([
            "status" => "ACCESS_DENIED",
        ]);
?>
