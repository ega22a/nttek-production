<?php
    require __DIR__ . "/../../../libraries/fpdf/fpdf.php";
    require __DIR__ . "/../../../libraries/petrovich/Petrovich.php";

    function statement($user = [], int $id = -1) {
        if (!empty($user) && $id != -1) {
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                if ($id != -1) {
                    require __DIR__ . "/../../../configurations/database/class.php";
                    $enrolleeData = $database -> query("SELECT * FROM `enr_statements` WHERE `id` = {$id};");
                    if ($enrolleeData -> num_rows == 1) {
                        $enrolleeData = $enrolleeData -> fetch_assoc();
                        require_once __DIR__ . "/../../../configurations/main.php";
                        require __DIR__ . "/../../../configurations/cipher-keys.php";
                        $crypt = new CryptService($ciphers["database"]);
                        $json = json_decode(file_get_contents(__DIR__ . "/../../../configurations/json/about.json"));
                        $petrovich = new Petrovich();
                        $enrolleeName = [
                            "lastname" => $crypt -> decrypt($enrolleeData["lastname"]),
                            "firstname" => mb_substr($crypt -> decrypt($enrolleeData["firstname"]), 0, 1) . ". ",
                            "patronymic" => !empty($enrolleeData["patronymic"]) ? mb_substr($crypt -> decrypt($enrolleeData["patronymic"]), 0, 1) . ". " : "",
                        ];
                        class pdf extends FPDF {
                            public $enrollee = [];

                            function footer() {
                                // 190 - width
                                $this -> SetY(-15);
                                $this -> SetX(10);
                                $this -> SetFont("PTSerif", "", 10);
                                $this -> Cell(90, 4, $this -> cyrilic("Страница"), 0, 0, "R");
                                $this -> SetFont("PTSerif", "B", 10);
                                $this -> Cell(3, 4, $this -> PageNo(), 0, 0, "C");
                                $this -> SetFont("PTSerif", "", 10);
                                $this -> Cell(5, 4, $this -> cyrilic("из"), 0, 0, "C");
                                $this -> SetFont("PTSerif", "B", 10);
                                $this -> Cell(2, 4, "{nb}", 0, 0);
                                $this -> SetFont("PTSerif", "", 7);
                                $this -> Ln(-4);
                                $this -> Cell(126, 3, "");
                                $this -> Cell(30, 4, $this -> cyrilic("(подпись)"), 0, 0, "C");
                                $this -> Cell(4, 4, "", 0, 0, "C");
                                $this -> Cell(30, 4, $this -> cyrilic("(расшифровка)"), 0, 0, "C");
                                $now["day"] = date("d");
                                $now["year"] = date("y");
                                switch (date("n")) {
                                    case "1":
                                        $now["month"] = $this-> cyrilic("января");
                                    break;
                                    case "2":
                                        $now["month"] = $this-> cyrilic("февраля");
                                    break;
                                    case "3":
                                        $now["month"] = $this-> cyrilic("марта");
                                    break;
                                    case "4":
                                        $now["month"] = $this-> cyrilic("апреля");
                                    break;
                                    case "5":
                                        $now["month"] = $this-> cyrilic("мая");
                                    break;
                                    case "6":
                                        $now["month"] = $this-> cyrilic("июня");
                                    break;
                                    case "7":
                                        $now["month"] = $this-> cyrilic("июля");
                                    break;
                                    case "8":
                                        $now["month"] = $this-> cyrilic("августа");
                                    break;
                                    case "9":
                                        $now["month"] = $this-> cyrilic("сентября");
                                    break;
                                    case "10":
                                        $now["month"] = $this-> cyrilic("октября");
                                    break;
                                    case "11":
                                        $now["month"] = $this-> cyrilic("ноября");
                                    break;
                                    case "12":
                                        $now["month"] = $this-> cyrilic("декабря");
                                    break;
                                }
                                $this -> Ln(-4);
                                $this -> SetFont("PTSerif", "", 10);
                                $this -> Cell(3, 4, $this -> cyrilic("«"));
                                $this -> Cell(5, 4, $now["day"], "B", 0, "C");
                                $this -> Cell(3, 4, $this -> cyrilic("»"));
                                $this -> Cell(20, 4, $now["month"], "B", 0, "C");
                                $this -> Cell(5, 4, "20");
                                $this -> Cell(5, 4, $now["year"], "B", 0, "C");
                                $this -> Cell(4, 4, $this -> cyrilic("г."));
                                $this -> Cell(81, 4, "");
                                $this -> Cell(30, 4, "", "B");
                                $this -> Cell(4, 4, "/", 0, 0, "C");
                                $this -> Cell(30, 4, $this -> cyrilic("{$this -> enrollee["firstname"]}{$this -> enrollee["patronymic"]}{$this -> enrollee["lastname"]}"), "B");
                            }
                            function setList($list) {
                                if (is_array($list))
                                    foreach ($list as $key => $value)
                                        $this -> MultiCell(190, 5, $key + 1 != count($list) ? "    - {$this -> cyrilic($value)};" : "    - {$this -> cyrilic($value)}.", 0, "L");
                            }
                            function createTable($table) {
                                if (is_array($table))
                                    foreach ($table as $key => $value) {
                                        $this -> Cell(10, 5, "");
                                        $y = $this -> GetY();
                                        $this -> MultiCell(175, 5, $this -> cyrilic($value), 1, "L");
                                        $sub_y = $this -> GetY();
                                        $this -> SetY($y);
                                        $this -> Cell(10, $sub_y - $y, strval($key + 1) . ".", 1);
                                        $this -> Cell(175, 5, "");
                                        $this -> Cell(5, $sub_y - $y, "V", 1, 0, "C");
                                        $this -> SetY($sub_y);
                                    }
                            }

                            function setEnrollee($_enr) {
                                $this -> enrollee = $_enr;
                            }
                        }
                        $pdf = new pdf();
                        $pdf -> setEnrollee($enrolleeName);
                        $pdf -> AddFont("PTSerif", "", "PTSerif-Regular.php");
                        $pdf -> AddFont("PTSerif", "B", "PTSerif-Bold.php");
                        $pdf -> AddFont("PTSerif", "I", "PTSerif-Italic.php");
                        $pdf -> AddFont("PTSerif", "BI", "PTSerif-BoldItalic.php");
                        $pdf -> AliasNbPages();
                        $pdf -> AddPage();
                        $pdf -> SetFont("PTSerif", "", 10);
                        $thumb = $user -> getDecrypted();
                        $who = [
                            "firstname" => mb_substr($thumb["firstname"], 0, 1) . ". ",
                            "lastname" => $thumb["lastname"],
                            "patronymic" => $thumb["patronymic"] != " " ? mb_substr($thumb["patronymic"], 0, 1) . ". " : "",
                        ];
                        $pdf -> Cell(35, 5, $pdf -> cyrilic("Заявление принял:"));
                        $pdf -> Cell(20, 5, "", "B");
                        $pdf -> Cell(4, 5, "/", 0, 0, "C");
                        $pdf -> Cell(34, 5, $pdf -> cyrilic("{$who["firstname"]}{$who["patronymic"]}{$who["lastname"]}"), "B");
                        $pdf -> Cell(4, 5, "");
                        $y = $pdf -> GetY();
                        $petrovich -> setSex($json -> school -> principal -> sex);
                        $json -> school -> principal -> firstname = mb_substr($json -> school -> principal -> firstname, 0, 1);
                        $json -> school -> principal -> patronymic = mb_substr($json -> school -> principal -> patronymic, 0, 1);
                        $pdf -> MultiCell(93, 5, $pdf -> cyrilic("Директору {$json -> school -> name -> halfShort -> genitive} {$petrovich -> lastname($json -> school -> principal -> lastname, Petrovich::CASE_GENITIVE)} {$json -> school -> principal -> firstname}. {$json -> school -> principal -> patronymic}."));
                        $y = $pdf -> GetY() - $y - 5;
                        $pdf -> SetY($pdf -> GetY() - $y);
                        $pdf -> SetFont("PTSerif", "", 7);
                        $pdf -> Cell(35, 5, "");
                        $pdf -> Cell(20, 5, $pdf -> cyrilic("(подпись)"), 0, 0, "C");
                        $pdf -> Cell(4, 5, "", 0, 0, "C");
                        $pdf -> Cell(34, 5, $pdf -> cyrilic("(расшифровка)"), 0, 0, "C");
                        $pdf -> SetFont("PTSerif", "", 10);
                        $pdf -> SetY($pdf -> GetY() + $y);
                        $pdf -> Cell(35, 5, $pdf -> cyrilic("Время создания:"));
                        $pdf -> Cell(58, 5, date("d.m.Y H:i:s"), "B", 0, "C");
                        $pdf -> Cell(4, 5, "");
                        $pdf -> Cell(6, 5, $pdf -> cyrilic("от"));
                        $petrovich -> setSex(intval($enrolleeData["sex"]));
                        $patronymic = !empty($enrolleeData["patronymic"]) ? $petrovich -> middlename($crypt -> decrypt($enrolleeData["patronymic"]), Petrovich::CASE_GENITIVE) : "";
                        $pdf -> Cell(87, 5, $pdf -> cyrilic("{$petrovich -> lastname($crypt -> decrypt($enrolleeData["lastname"]), Petrovich::CASE_GENITIVE)} {$petrovich -> firstname($crypt -> decrypt($enrolleeData["firstname"]), Petrovich::CASE_GENITIVE)} {$patronymic}"), "B");
                        $pdf -> Ln();
                        $pdf -> Cell(30, 5, $pdf -> cyrilic("Зачислить на"));
                        $pdf -> Cell(23, 5, "", "B");
                        $pdf -> Cell(40, 5, $pdf -> cyrilic("курс по специальности"));
                        $pdf -> Cell(10, 5, "");
                        $pdf -> SetFont("PTSerif", "", 7);
                        $pdf -> Cell(87, 5, $pdf -> cyrilic("(фамилия, имя, отчество (при наличии))"), 0, 0, "C");
                        $pdf -> SetFont("PTSerif", "", 10);
                        $pdf -> Ln();
                        $pdf -> Cell(93, 5, "", "B");
                        $pdf -> Cell(4, 5, "");
                        $pdf -> Cell(45, 5, $pdf -> cyrilic((intval($enrolleeData["sex"]) == 1 ? "проживающего" : "проживающей") . " по адресу:"));
                        $address = json_decode($crypt -> decrypt($enrolleeData["address"]));
                        $pdf -> Cell(48, 5, $pdf -> cyrilic("{$address -> zipCode}, {$address -> country},"), "B");
                        $pdf -> Ln();
                        $pdf -> Cell(93, 5, "", "B");
                        $pdf -> Cell(4, 5, "");
                        $addressLine = "{$address -> region}, {$address -> city}, ул. {$address -> street}, д. {$address -> house}";
                        $addressLine .= !empty($address -> building) ? ", стр. {$address -> building}" : "";
                        $addressLine .= !empty($address -> flat) ? ", кв. {$address -> flat}" : "";
                        $pdf -> MultiCell(93, 5, $pdf -> cyrilic($addressLine), "B");
                        $pdf -> Cell(20, 5, $pdf -> cyrilic("Приказ №"));
                        $pdf -> Cell(20, 5, "", "B");
                        $pdf -> Cell(8, 5, $pdf -> cyrilic("от"), 0, 0, "C");
                        $pdf -> Cell(3, 5, $pdf -> cyrilic("«"));
                        $pdf -> Cell(5, 5, "", "B");
                        $pdf -> Cell(3, 5, $pdf -> cyrilic("»"));
                        $pdf -> Cell(20, 5, "", "B");
                        $pdf -> Cell(5, 5, "20");
                        $pdf -> Cell(5, 5, "", "B");
                        $pdf -> Cell(4, 5, $pdf -> cyrilic("г."));
                        $pdf -> Cell(4, 5, "");
                        $pdf -> SetFont("PTSerif", "", 7);
                        $pdf -> Cell(87, 5, $pdf -> cyrilic("(индекс, адрес фактического проживания)"), 0, 0, "C");
                        $pdf -> SetFont("PTSerif", "", 10);
                        $pdf -> Ln();
                        $pdf -> Cell(20, 5, $pdf -> cyrilic("Директор"));
                        $pdf -> Cell(39, 5, "", "B");
                        $pdf -> Cell(4, 5, "/", 0, 0, "C");
                        $pdf -> Cell(30, 5, $pdf -> cyrilic("{$json -> school -> principal -> firstname}. {$json -> school -> principal -> patronymic}. {$json -> school -> principal -> lastname}"), "B", 0, "C");
                        $pdf -> Cell(4, 5, "");
                        $pdf -> Cell(93, 5, $pdf -> cyrilic("Контактные телефоны (домашний и (или) сотовый:"));
                        $pdf -> Ln();
                        $pdf -> SetFont("PTSerif", "", 7);
                        $pdf -> Cell(20, 5, "");
                        $pdf -> Cell(39, 5, $pdf -> cyrilic("(подпись)"), 0, 0, "C");
                        $pdf -> Cell(4, 5, "");
                        $pdf -> Cell(30, 5, $pdf -> cyrilic("(расшифровка)"), 0, 0, "C");
                        $pdf -> SetFont("PTSerif", "", 10);
                        $pdf -> Cell(4, 5, "");
                        $telephones = [
                            "home" => !empty($enrolleeData["homeTelephone"]) ? "{$crypt -> decrypt($enrolleeData["homeTelephone"])}, " : "",
                            "mobile" => $crypt -> decrypt($enrolleeData["telephone"]),
                        ];
                        $pdf -> Cell(93, 5, "{$telephones["home"]}{$telephones["mobile"]}" , "B");
                        $pdf -> Ln();
                        $pdf -> Cell(97, 5, "");
                        $pdf -> Cell(93, 5, $pdf -> cyrilic("Адрес электронной почты (при наличии):"));
                        $pdf -> Ln();
                        $pdf -> Cell(97, 5, "");
                        $pdf -> Cell(93, 5, "{$crypt -> decrypt($enrolleeData["email"])}", "B");
                        $pdf -> Ln(10);
                        $pdf -> SetFont("PTSerif", "B", 10);
                        $pdf -> Cell(190, 5, $pdf -> cyrilic("З А Я В Л Е Н И Е"), 0, 0, "C");
                        $pdf -> SetFont("PTSerif", "", 10);
                        $pdf -> Ln(5);
                        $pdf -> Cell(41, 5, $pdf -> cyrilic("Прошу принять меня на"));
                        if ($enrolleeData["educationalType"] == "fulltime") {
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(13, 5, $pdf -> cyrilic("очную"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(135, 5, $pdf -> cyrilic("форму обучения по специальности (профессии) среднего профессионального"));
                            $pdf -> Ln();
                            $pdf -> Cell(25, 5, $pdf -> cyrilic("образования:"));
                            $specialty = $database -> query("SELECT `fullname` FROM `enr_specialties` WHERE `id` = {$enrolleeData["specialty"]};") -> fetch_assoc()["fullname"];
                            $pdf -> MultiCell(165, 5, $pdf -> cyrilic(explode("@", $specialty)[0]), "B", "C");
                            $pdf -> Cell(25, 5, "");
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(165, 5, $pdf -> cyrilic("(код, наименование специальности)"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Ln(5);
                            $pdf -> Cell(90, 5, $pdf -> cyrilic("за счёт средств бюджета Свердловской области"), 0, 0, "C");
                            if (intval($enrolleeData["paysType"]) == 1)
                                $pdf -> Cell(5, 5, "V", 1, 0, "C");
                            else
                                $pdf -> Cell(5, 5, "X", 1, 0, "C");
                            $pdf -> Cell(90, 5, $pdf -> cyrilic("с полным возмещением затрат на обучение"), 0, 0, "C");
                            if (intval($enrolleeData["paysType"]) == 2)
                                $pdf -> Cell(5, 5, "V", 1, 0, "C");
                            else
                                $pdf -> Cell(5, 5, "X", 1, 0, "C");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(68, 5, $pdf -> cyrilic("О себе сообщаю следующие данные:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $birthday = explode("-", $crypt -> decrypt($enrolleeData["birthday"]));
                            $pdf -> Cell(45, 5, "{$birthday[2]}.{$birthday[1]}.{$birthday[0]}", "B", 0, "C");
                            $pdf -> Cell(2, 5, "");
                            $y = $pdf -> GetY();
                            $birthplace = json_decode($crypt -> decrypt($enrolleeData["birthplace"]));
                            $pdf -> MultiCell(75, 5, $pdf -> cyrilic("{$birthplace -> country}, {$birthplace -> region}, {$birthplace -> city}"), "B");
                            $sec_y = $pdf -> GetY();
                            $pdf -> SetY($y + 5);
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(68, 5, "");
                            $pdf -> Cell(45, 5, $pdf -> cyrilic("(число, месяц, год рождения)"), 0, 0, "C");
                            $pdf -> SetY($sec_y);
                            $pdf -> Cell(115, 5, "");
                            $pdf -> Cell(75, 5, $pdf -> cyrilic("(место рождения: республика (край, область), район, город (село))"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln();
                            $pdf -> Cell(18, 5, $pdf -> cyrilic("Паспорт:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(28, 5, $pdf -> cyrilic("серия и номер:"), 0, 0, "C");
                            $passport = json_decode($crypt -> decrypt($enrolleeData["passport"]));
                            $pdf -> Cell(30, 5, "{$passport -> series} {$passport -> number}", "B", 0, "C");
                            $pdf -> Cell(26, 5, $pdf -> cyrilic("дата выдачи:"), 0, 0, "C");
                            $passport -> date = explode("-", $passport -> date);
                            $pdf -> Cell(30, 5, "{$passport -> date[2]}.{$passport -> date[1]}.{$passport -> date[0]}", "B", 0, "C");
                            $pdf -> Cell(58, 5, $pdf -> cyrilic("кем выдан, код подразделения:"), 0, 0, "C");
                            $pdf -> Ln();
                            $pdf -> MultiCell(190, 5, $pdf -> cyrilic("{$passport -> place}, {$passport -> code}"), "B", "L");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln();
                            $pdf -> Cell(72, 5, $pdf -> cyrilic("Сведения о предыдущем образовании:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $y = $pdf -> GetY();
                            $pdf -> MultiCell(86, 5, $pdf -> cyrilic(stripslashes($crypt -> decrypt($enrolleeData["previousSchool"]))), "B");
                            $sec_y = $pdf -> GetY();
                            $pdf -> SetY($y);
                            $pdf -> Cell(160, 5, "");
                            $pdf -> Cell(30, 5, $crypt -> decrypt($enrolleeData["previousSchoolDate"]), "B", 0, "C");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(160, 5, "");
                            $pdf -> Cell(30, 5, $pdf -> cyrilic("(год окончания)"), 0, 0, "C");
                            $pdf -> SetY($sec_y);
                            $pdf -> Cell(72, 5, "");
                            $pdf -> Cell(86, 5, $pdf -> cyrilic("(полное наименование образовательного учреждения)"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln();
                            $pdf -> Cell(72, 5, $pdf -> cyrilic("Документ об образовании:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $y = $pdf -> GetY();
                            $degree = $database -> query("SELECT `name` FROM `enr_education_levels` WHERE `id` = {$enrolleeData["degree"]}") -> fetch_assoc()["name"];
                            $pdf -> MultiCell(76, 5, $pdf -> cyrilic($degree), "B", "C");
                            $sec_y = $pdf -> GetY();
                            $pdf -> SetY($y);
                            $pdf -> Cell(150, 5, "");
                            $docType = $database -> query("SELECT `name` FROM `enr_educational_docs` WHERE `id` = {$enrolleeData["previousSchoolDoc"]}") -> fetch_assoc()["name"];
                            $pdf -> MultiCell(40, 5, $pdf -> cyrilic($docType), "B", "C");
                            $ssec_y = $pdf -> GetY();
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> SetY($ssec_y);
                            $pdf -> Cell(150, 5, "");
                            $pdf -> Cell(40, 5, $pdf -> cyrilic("(тип документа)"), 0, 0, "C");
                            $pdf -> SetY($sec_y);
                            $pdf -> Cell(72, 5, "");
                            $pdf -> Cell(76, 5, $pdf -> cyrilic("(уровень образования)"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> SetY($ssec_y);
                            $pdf -> Ln();
                            $edicationalDoc = json_decode($crypt -> decrypt($enrolleeData["previousSchoolDocData"]));
                            $pdf -> Cell(72, 5, $pdf -> cyrilic("Серия, номер документа об образовании:"));
                            $pdf -> Cell(53, 5, $pdf -> cyrilic("{$edicationalDoc -> series} {$edicationalDoc -> number}"), "B", 0, "C");
                            $pdf -> Cell(25, 5, $pdf -> cyrilic("дата выдачи:"), 0, 0, "C");
                            $edicationalDoc -> date = explode("-", $edicationalDoc -> date);
                            $pdf -> Cell(40, 5, "{$edicationalDoc -> date[2]}.{$edicationalDoc -> date[1]}.{$edicationalDoc -> date[0]}", "B", 0, "C");
                            $pdf -> Ln();
                            $pdf -> Cell(37, 5, $pdf -> cyrilic("Иностранный язык:"));
                            $foreign = $database -> query("SELECT `name` FROM `enr_languages` WHERE `id` = {$enrolleeData["language"]}") -> fetch_assoc()["name"];
                            $pdf -> Cell(40, 5, $pdf -> cyrilic($foreign), "B", 0, "C");
                            $pdf -> Cell(2, 5, "");
                            $pdf -> Cell(27, 5, $pdf -> cyrilic("В общежитии:"));
                            if (intval($enrolleeData["hostel"]) == 1)
                                $pdf -> Cell(40, 5, $pdf -> cyrilic("Нуждаюсь"), "B", 0, "C");
                            elseif (intval($enrolleeData["hostel"]) == 0)
                                $pdf -> Cell(40, 5, $pdf -> cyrilic("Не нуждаюсь"), "B", 0, "C");
                            $pdf -> Ln();
                            $pdf -> Cell(41, 5, $pdf -> cyrilic("Отношусь к категории:"));
                            if (!empty($enrolleeData["category"])) {
                                $category = $database -> query("SELECT `name` FROM `enr_category_of_citizen` WHERE `id` = {$enrolleeData["category"]};") -> fetch_assoc()["name"];
                                $pdf -> MultiCell(80, 5, $pdf -> cyrilic($category), "B", "C");
                            } else
                                $pdf -> MultiCell(80, 5, $pdf -> cyrilic("Ни к одной из перечисленных"), "B", "C");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln();
                            $pdf -> Cell(20, 5, $pdf -> cyrilic("О себе:"));
                            $pdf -> Cell(3, 5, "");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> MultiCell(167, 5, $pdf -> cyrilic($crypt -> decrypt($enrolleeData["about"])), "B", "C");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln();
                            $pdf -> Cell(190, 5, $pdf -> cyrilic("Сведения о родителях (законных представителях):"));
                            $pdf -> Ln();
                            if (!empty($enrolleeData["mother"])) {
                                $mother = json_decode($crypt -> decrypt($enrolleeData["mother"]));
                                $mother -> patronymic = !empty($mother -> patronymic) ? " {$mother -> patronymic}" : "";
                                $job = !empty($mother -> jobName) ? "{$mother -> jobName}, {$mother -> jobPosition}, {$mother -> jobTelephone}, " : "";
                                $pdf -> Cell(13, 5, $pdf -> cyrilic("Мать:"));
                                $pdf -> SetFont("PTSerif", "", 10);
                                $pdf -> MultiCell(177, 5, $pdf -> cyrilic("{$mother -> lastname} {$mother -> firstname}{$mother -> patronymic}, {$job}{$mother -> telephone}"), "B");
                                $pdf -> SetFont("PTSerif", "", 7);
                                $pdf -> Cell(13, 5, "");
                                $pdf -> Cell(177, 5, $pdf -> cyrilic("(фамилия, имя, отчество (при наличии), место работы, должность, рабочий телефон, контактные телефоны)"), 0, 0, "C");
                                $pdf -> SetFont("PTSerif", "B", 10);
                                $pdf -> Ln();
                            }
                            if (!empty($enrolleeData["father"])) {
                                $father = json_decode($crypt -> decrypt($enrolleeData["father"]));
                                $father -> patronymic = !empty($father -> patronymic) ? " {$father -> patronymic}" : "";
                                $job = !empty($father -> jobName) ? "{$father -> jobName}, {$father -> jobPosition}, {$father -> jobTelephone}, " : "";
                                $pdf -> Cell(13, 5, $pdf -> cyrilic("Отец:"));
                                $pdf -> SetFont("PTSerif", "", 10);
                                $pdf -> MultiCell(177, 5, $pdf -> cyrilic("{$father -> lastname} {$father -> firstname}{$father -> patronymic}, {$job}{$father -> telephone}"), "B");
                                $pdf -> SetFont("PTSerif", "", 7);
                                $pdf -> Cell(13, 5, "");
                                $pdf -> Cell(177, 5, $pdf -> cyrilic("(фамилия, имя, отчество (при наличии), место работы, должность, рабочий телефон, контактные телефоны)"), 0, 0, "C");
                                $pdf -> SetFont("PTSerif", "B", 10);
                                $pdf -> Ln();
                            }
                            if (!empty($enrolleeData["representative"])) {
                                $representative = json_decode($crypt -> decrypt($enrolleeData["representative"]));
                                $representative -> patronymic = !empty($representative -> patronymic) ? " {$representative -> patronymic}" : "";
                                $job = !empty($representative -> jobName) ? "{$representative -> jobName}, {$representative -> jobPosition}, {$representative -> jobTelephone}, " : "";
                                $pdf -> SetFont("PTSerif", "", 10);
                                $pdf -> MultiCell(190, 5, $pdf -> cyrilic("{$representative -> lastname} {$representative -> firstname}{$representative -> patronymic}, {$representative -> who}, {$job}{$representative -> telephone}"), "B");
                                $pdf -> SetFont("PTSerif", "", 7);
                                $pdf -> Cell(13, 5, "");
                                $pdf -> Cell(177, 5, $pdf -> cyrilic("(фамилия, имя, отчество (при наличии), кем приходится, место работы, должность, рабочий телефон, контактные телефоны)"), 0, 0, "C");
                                $pdf -> SetFont("PTSerif", "B", 10);
                                $pdf -> Ln();
                            }
                            $pdf -> Ln();
                            $pdf -> Cell(108, 5, $pdf -> cyrilic("Среднее профессиональное образование получаю впервые"));
                            $pdf -> Cell(39, 5, "", "B");
                            $pdf -> Cell(4, 5, "/", 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("{$enrolleeName["firstname"]}{$enrolleeName["patronymic"]}{$enrolleeName["lastname"]}"), "B");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(108, 5, "");
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("(подпись)"), 0, 0, "C");
                            $pdf -> Cell(4, 5, "");
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("(расшифровка)"), 0, 0, "C");
                            $pdf -> AddPage();
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(190, 5, $pdf -> cyrilic("Я " . (intval($enrolleeData["sex"]) == 1 ? "ознакомлен" : "ознакомлена") . " со следующими копиями документов:"));
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 10);
                            $viewedDocs = [];
                            $thumb = $database -> query("SELECT `name` FROM `enr_docs_for_review`;");
                            while ($row = $thumb -> fetch_assoc())
                                $viewedDocs[] = $row["name"];
                            $pdf -> setList($viewedDocs);
                            $pdf -> Ln();
                            $pdf -> Cell(108, 5, "");
                            $pdf -> Cell(39, 5, "", "B");
                            $pdf -> Cell(4, 5, "/", 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("{$enrolleeName["firstname"]}{$enrolleeName["patronymic"]}{$enrolleeName["lastname"]}"), "B");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(108, 5, "");
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("(подпись)"), 0, 0, "C");
                            $pdf -> Cell(4, 5, "");
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("(расшифровка)"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln(10);
                            $pdf -> Cell(38.5, 5, "");
                            $pdf -> Cell(113, 5, $pdf -> cyrilic("Согласно правилам приёма, прилагаю следующие документы:"), "B", 0, "C");
                            $pdf -> Ln(10);
                            $attachedDocs = json_decode($crypt -> decrypt($enrolleeData["attachedDocs"]));
                            $attachedDocsNames = ["Заявление о приеме на очную форму обучения"];
                            if ($enrolleeData["withOriginalDiploma"] == "1")
                                $attachedDocsNames[] = "Оригинал документа об образовании";
                            foreach ($attachedDocs as $value)
                                $attachedDocsNames[] = $database -> query("SELECT `name` FROM `enr_attached_docs` WHERE `id` = {$value}") -> fetch_assoc()["name"];
                            $pdf -> createTable($attachedDocsNames);
                            $pdf -> Ln();
                            $pdf -> MultiCell(190, 5, $pdf -> cyrilic("Ознакомлен с наличием/отсутствием аккредитации по выбранной специальности"), 0, "L");
                            $pdf -> Ln(10);
                            $pdf -> Cell(15, 5, "");
                            $pdf -> Cell(160, 5, $pdf -> cyrilic("Поступающие, предоставившие в Приёмную комиссию заведомо подложные документы,"), "B", 0, "C");
                            $pdf -> Ln();
                            $pdf -> Cell(17.5, 5, "");
                            $pdf -> Cell(155, 5, $pdf -> cyrilic("несут ответственность, предусмотренную законодательством Российской Федерации."), "B", 0, "C");
                            return $pdf -> Output("S");
                        } elseif ($enrolleeData["educationalType"] == "extramural") {
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(16, 5, $pdf -> cyrilic("заочную"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(28, 5, $pdf -> cyrilic("форму обучения"));
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(83, 5, $pdf -> cyrilic("(с применением дистанционных технологий)"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(5, 5, $pdf -> cyrilic("по"));
                            $pdf -> Ln();
                            $pdf -> Cell(190, 5, $pdf -> cyrilic("специальности среднего профессионального образования:"));
                            $pdf -> Ln();
                            $specialty = $database -> query("SELECT `fullname` FROM `enr_specialties` WHERE `id` = {$enrolleeData["specialty"]};") -> fetch_assoc()["fullname"];
                            $pdf -> MultiCell(190, 5, $pdf -> cyrilic(explode("@", $specialty)[0]), "B", "C");
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(190, 5, $pdf -> cyrilic("(код, наименование специальности)"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Ln(5);
                            $pdf -> Cell(90, 5, $pdf -> cyrilic("за счёт средств бюджета Свердловской области"), 0, 0, "C");
                            if (intval($enrolleeData["paysType"]) == 1)
                                $pdf -> Cell(5, 5, "V", 1, 0, "C");
                            else
                                $pdf -> Cell(5, 5, "X", 1, 0, "C");
                            $pdf -> Cell(90, 5, $pdf -> cyrilic("с полным возмещением затрат на обучение"), 0, 0, "C");
                            if (intval($enrolleeData["paysType"]) == 2)
                                $pdf -> Cell(5, 5, "V", 1, 0, "C");
                            else
                                $pdf -> Cell(5, 5, "X", 1, 0, "C");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(68, 5, $pdf -> cyrilic("О себе сообщаю следующие данные:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $birthday = explode("-", $crypt -> decrypt($enrolleeData["birthday"]));
                            $pdf -> Cell(45, 5, "{$birthday[2]}.{$birthday[1]}.{$birthday[0]}", "B", 0, "C");
                            $pdf -> Cell(2, 5, "");
                            $y = $pdf -> GetY();
                            $birthplace = json_decode($crypt -> decrypt($enrolleeData["birthplace"]));
                            $pdf -> MultiCell(75, 5, $pdf -> cyrilic("{$birthplace -> country}, {$birthplace -> region}, {$birthplace -> city}"), "B");
                            $sec_y = $pdf -> GetY();
                            $pdf -> SetY($y + 5);
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(68, 5, "");
                            $pdf -> Cell(45, 5, $pdf -> cyrilic("(число, месяц, год рождения)"), 0, 0, "C");
                            $pdf -> SetY($sec_y);
                            $pdf -> Cell(115, 5, "");
                            $pdf -> Cell(75, 5, $pdf -> cyrilic("(место рождения: республика (край, область), район, город (село))"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln();
                            $pdf -> Cell(18, 5, $pdf -> cyrilic("Паспорт:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(28, 5, $pdf -> cyrilic("серия и номер:"), 0, 0, "C");
                            $passport = json_decode($crypt -> decrypt($enrolleeData["passport"]));
                            $pdf -> Cell(30, 5, "{$passport -> series} {$passport -> number}", "B", 0, "C");
                            $pdf -> Cell(26, 5, $pdf -> cyrilic("дата выдачи:"), 0, 0, "C");
                            $passport -> date = explode("-", $passport -> date);
                            $pdf -> Cell(30, 5, "{$passport -> date[2]}.{$passport -> date[1]}.{$passport -> date[0]}", "B", 0, "C");
                            $pdf -> Cell(58, 5, $pdf -> cyrilic("кем выдан, код подразделения:"), 0, 0, "C");
                            $pdf -> Ln();
                            $pdf -> MultiCell(190, 5, $pdf -> cyrilic("{$passport -> place}, {$passport -> code}"), "B", "L");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln();
                            $pdf -> Cell(72, 5, $pdf -> cyrilic("Сведения о предыдущем образовании:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $y = $pdf -> GetY();
                            $pdf -> MultiCell(86, 5, $pdf -> cyrilic($crypt -> decrypt($enrolleeData["previousSchool"])), "B");
                            $sec_y = $pdf -> GetY();
                            $pdf -> SetY($y);
                            $pdf -> Cell(160, 5, "");
                            $pdf -> Cell(30, 5, $crypt -> decrypt($enrolleeData["previousSchoolDate"]), "B", 0, "C");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(160, 5, "");
                            $pdf -> Cell(30, 5, $pdf -> cyrilic("(год окончания)"), 0, 0, "C");
                            $pdf -> SetY($sec_y);
                            $pdf -> Cell(72, 5, "");
                            $pdf -> Cell(86, 5, $pdf -> cyrilic("(полное наименование образовательного учреждения)"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln();
                            $pdf -> Cell(72, 5, $pdf -> cyrilic("Документ об образовании:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $y = $pdf -> GetY();
                            $degree = $database -> query("SELECT `name` FROM `enr_education_levels` WHERE `id` = {$enrolleeData["degree"]}") -> fetch_assoc()["name"];
                            $pdf -> MultiCell(76, 5, $pdf -> cyrilic($degree), "B", "C");
                            $sec_y = $pdf -> GetY();
                            $pdf -> SetY($y);
                            $pdf -> Cell(150, 5, "");
                            $docType = $database -> query("SELECT `name` FROM `enr_educational_docs` WHERE `id` = {$enrolleeData["previousSchoolDoc"]}") -> fetch_assoc()["name"];
                            $pdf -> MultiCell(40, 5, $pdf -> cyrilic($docType), "B", "C");
                            $ssec_y = $pdf -> GetY();
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> SetY($ssec_y);
                            $pdf -> Cell(150, 5, "");
                            $pdf -> Cell(40, 5, $pdf -> cyrilic("(тип документа)"), 0, 0, "C");
                            $pdf -> SetY($sec_y);
                            $pdf -> Cell(72, 5, "");
                            $pdf -> Cell(76, 5, $pdf -> cyrilic("(уровень образования)"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> SetY($ssec_y);
                            $pdf -> Ln();
                            $edicationalDoc = json_decode($crypt -> decrypt($enrolleeData["previousSchoolDocData"]));
                            $pdf -> Cell(72, 5, $pdf -> cyrilic("Серия, номер документа об образовании:"));
                            $pdf -> Cell(53, 5, $pdf -> cyrilic("{$edicationalDoc -> series} {$edicationalDoc -> number}"), "B", 0, "C");
                            $pdf -> Cell(25, 5, $pdf -> cyrilic("дата выдачи:"), 0, 0, "C");
                            $edicationalDoc -> date = explode("-", $edicationalDoc -> date);
                            $pdf -> Cell(40, 5, "{$edicationalDoc -> date[2]}.{$edicationalDoc -> date[1]}.{$edicationalDoc -> date[0]}", "B", 0, "C");
                            $pdf -> Ln();
                            $pdf -> Cell(37, 5, $pdf -> cyrilic("Иностранный язык:"));
                            $foreign = $database -> query("SELECT `name` FROM `enr_languages` WHERE `id` = {$enrolleeData["language"]}") -> fetch_assoc()["name"];
                            $pdf -> Cell(40, 5, $pdf -> cyrilic($foreign), "B", 0, "C");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(41, 5, $pdf -> cyrilic("Отношусь к категории:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            if (!empty($enrolleeData["category"])) {
                                $category = $database -> query("SELECT `name` FROM `enr_category_of_citizen` WHERE `id` = {$enrolleeData["category"]};") -> fetch_assoc()["name"];
                                $pdf -> MultiCell(80, 5, $pdf -> cyrilic($category), "B", "C");
                            } else
                                $pdf -> MultiCell(80, 5, $pdf -> cyrilic("Ни к одной из перечисленных"), "B", "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Ln(10);
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(48, 5, $pdf -> cyrilic("Место работы:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(142, 5, $pdf -> cyrilic(isset($enrolleeData["work"]) ? $crypt -> decrypt($enrolleeData["work"]) : ""), "B");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(48, 5, $pdf -> cyrilic("Должность:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(142, 5, $pdf -> cyrilic(isset($enrolleeData["position"]) ? $crypt -> decrypt($enrolleeData["position"]) : ""), "B");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(48, 5, $pdf -> cyrilic("Стаж работы в отрасли:"));
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(142, 5, $pdf -> cyrilic(isset($enrolleeData["workExpirence"]) ? $crypt -> decrypt($enrolleeData["workExpirence"]) : ""), "B");
                            $pdf -> Ln();
                            $pdf -> Ln(10);
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(108, 5, $pdf -> cyrilic("Среднее профессиональное образование получаю впервые"));
                            $pdf -> Cell(39, 5, "", "B");
                            $pdf -> Cell(4, 5, "/", 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("{$enrolleeName["firstname"]}{$enrolleeName["patronymic"]}{$enrolleeName["lastname"]}"), "B");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(108, 5, "");
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("(подпись)"), 0, 0, "C");
                            $pdf -> Cell(4, 5, "");
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("(расшифровка)"), 0, 0, "C");
                            $pdf -> AddPage();
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Cell(190, 5, $pdf -> cyrilic("Я " . (intval($enrolleeData["sex"]) == 1 ? "ознакомлен" : "ознакомлена") . " со следующими копиями документов:"));
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 10);
                            $viewedDocs = [];
                            $thumb = $database -> query("SELECT `name` FROM `enr_docs_for_review`;");
                            while ($row = $thumb -> fetch_assoc())
                                $viewedDocs[] = $row["name"];
                            $pdf -> setList($viewedDocs);
                            $pdf -> Ln();
                            $pdf -> Cell(108, 5, "");
                            $pdf -> Cell(39, 5, "", "B");
                            $pdf -> Cell(4, 5, "/", 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "", 10);
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("{$enrolleeName["firstname"]}{$enrolleeName["patronymic"]}{$enrolleeName["lastname"]}"), "B");
                            $pdf -> Ln();
                            $pdf -> SetFont("PTSerif", "", 7);
                            $pdf -> Cell(108, 5, "");
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("(подпись)"), 0, 0, "C");
                            $pdf -> Cell(4, 5, "");
                            $pdf -> Cell(39, 5, $pdf -> cyrilic("(расшифровка)"), 0, 0, "C");
                            $pdf -> SetFont("PTSerif", "B", 10);
                            $pdf -> Ln(10);
                            $pdf -> Cell(38.5, 5, "");
                            $pdf -> Cell(113, 5, $pdf -> cyrilic("Согласно правилам приёма, прилагаю следующие документы:"), "B", 0, "C");
                            $pdf -> Ln(10);
                            $attachedDocs = json_decode($crypt -> decrypt($enrolleeData["attachedDocs"]));
                            $attachedDocsNames = ["Заявление о приеме на заочную форму обучения"];
                            if ($enrolleeData["withOriginalDiploma"] == "1")
                                $attachedDocsNames[] = "Оригинал документа об образовании";
                            foreach ($attachedDocs as $value)
                                $attachedDocsNames[] = $database -> query("SELECT `name` FROM `enr_attached_docs` WHERE `id` = {$value}") -> fetch_assoc()["name"];
                            $pdf -> createTable($attachedDocsNames);
                            $pdf -> Ln();
                            $pdf -> MultiCell(190, 5, $pdf -> cyrilic("Ознакомлен с наличием/отсутствием аккредитации по выбранной специальности"), 0, "L");
                            $pdf -> Ln(10);
                            $pdf -> Cell(15, 5, "");
                            $pdf -> Cell(160, 5, $pdf -> cyrilic("Поступающие, предоставившие в Приёмную комиссию заведомо подложные документы,"), "B", 0, "C");
                            $pdf -> Ln();
                            $pdf -> Cell(17.5, 5, "");
                            $pdf -> Cell(155, 5, $pdf -> cyrilic("несут ответственность, предусмотренную законодательством Российской Федерации."), "B", 0, "C");
                            return $pdf -> Output("S");
                        } else
                            return false;
                    } else
                        return false;
                    $database -> close();
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }

    function receipt($user = [], int $id = -1, $_auth = []) {
        if (!empty($user) && $id != -1) {
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                require __DIR__ . "/../../../configurations/database/class.php";
                $enrolleeData = $database -> query("SELECT * FROM `enr_statements` WHERE `id` = {$id}");
                if ($enrolleeData -> num_rows == 1) {
                    $enrolleeData = $enrolleeData -> fetch_assoc();
                    require_once __DIR__ . "/../../../configurations/main.php";
                    require __DIR__ . "/../../../configurations/cipher-keys.php";
                    $crypt = new CryptService($ciphers["database"]);
                    $json = json_decode(file_get_contents(__DIR__ . "/../../../configurations/json/about.json"));
                    $petrovich = new Petrovich();
                    class receiptpdf extends fpdf {
                        public $who = [];

                        function secretary($thumb) {
                            $this -> who = [
                                "firstname" => mb_substr($thumb["firstname"], 0, 1) . ". ",
                                "lastname" => $thumb["lastname"],
                                "patronymic" => $thumb["patronymic"] != " " ? mb_substr($thumb["patronymic"], 0, 1) . ". " : "",
                            ];
                        }

                        function footer() {
                            $this -> SetY(-10);
                            $this -> SetX(10);
                            $this -> SetFont("PTSerif", "", 7);
                            $this -> Cell(66, 2, "");
                            $this -> Cell(30, 2, $this -> cyrilic("М.П."), 0, 0, "C");
                            $this -> Ln(-4);
                            $this -> Cell(66, 4, "");
                            $this -> Cell(30, 4, $this -> cyrilic("(подпись)"), 0, 0, "C");
                            $this -> Cell(4, 4, "", 0, 0, "C");
                            $this -> Cell(30, 4, $this -> cyrilic("(расшифровка)"), 0, 0, "C");
                            $now["day"] = date("d");
                            $now["year"] = date("y");
                            switch (date("n")) {
                                case "1":
                                    $now["month"] = $this-> cyrilic("января");
                                break;
                                case "2":
                                    $now["month"] = $this-> cyrilic("февраля");
                                break;
                                case "3":
                                    $now["month"] = $this-> cyrilic("марта");
                                break;
                                case "4":
                                    $now["month"] = $this-> cyrilic("апреля");
                                break;
                                case "5":
                                    $now["month"] = $this-> cyrilic("мая");
                                break;
                                case "6":
                                    $now["month"] = $this-> cyrilic("июня");
                                break;
                                case "7":
                                    $now["month"] = $this-> cyrilic("июля");
                                break;
                                case "8":
                                    $now["month"] = $this-> cyrilic("августа");
                                break;
                                case "9":
                                    $now["month"] = $this-> cyrilic("сентября");
                                break;
                                case "10":
                                    $now["month"] = $this-> cyrilic("октября");
                                break;
                                case "11":
                                    $now["month"] = $this-> cyrilic("ноября");
                                break;
                                case "12":
                                    $now["month"] = $this-> cyrilic("декабря");
                                break;
                            }
                            $this -> Ln(-4);
                            $this -> SetFont("PTSerif", "", 10);
                            $this -> Cell(3, 4, $this -> cyrilic("«"));
                            $this -> Cell(5, 4, $now["day"], "B", 0, "C");
                            $this -> Cell(3, 4, $this -> cyrilic("»"));
                            $this -> Cell(20, 4, $now["month"], "B", 0, "C");
                            $this -> Cell(5, 4, "20");
                            $this -> Cell(5, 4, $now["year"], "B", 0, "C");
                            $this -> Cell(4, 4, $this -> cyrilic("г."));
                            $this -> Cell(21, 4, "");
                            $this -> Cell(30, 4, "", "B");
                            $this -> Cell(4, 4, "/", 0, 0, "C");
                            $this -> Cell(30, 4, $this -> cyrilic("{$this -> who["lastname"]} {$this -> who["firstname"]}{$this -> who["patronymic"]}"), "B", 0, "C");
                        }

                        function setList($_data) {
                            foreach ($_data as $key => $value) {
                                $this -> Cell(10, 5, strval($key + 1) . ".");
                                $this -> MultiCell(120, 5, $key + 1 != count($_data) ? $this -> cyrilic($value . ";") : $this -> cyrilic($value . "."));
                            }
                        }
                    }
                    # width 130
                    $pdf = new receiptpdf("P", "mm", "A4");
                    $pdf -> AddFont("PTSerif", "", "PTSerif-Regular.php");
                    $pdf -> AddFont("PTSerif", "B", "PTSerif-Bold.php");
                    $pdf -> AddFont("PTSerif", "I", "PTSerif-Italic.php");
                    $pdf -> AddFont("PTSerif", "BI", "PTSerif-BoldItalic.php");
                    $pdf -> AddFont("PTMono", "", "PTMono-Regular.php");
                    $pdf -> SetFont("PTSerif", "B", 10);
                    $pdf -> secretary($user -> getDecrypted());
                    $pdf -> AddPage();
                    if (empty($enrolleeData["compositeKey"])) {
                        $count = $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `specialty` = {$enrolleeData["specialty"]} ORDER BY `compositeKey` DESC LIMIT 1") -> fetch_assoc()["compositeKey"];
                        if (empty($count))
                            $database -> query("UPDATE `enr_statements` SET `compositeKey` = 1 WHERE `id` = {$enrolleeData["id"]}");
                        else
                            $database -> query("UPDATE `enr_statements` SET `compositeKey` = " . strval(intval($count) + 1) . " WHERE `id` = {$enrolleeData["id"]}");
                    }
                    if (!boolval($enrolleeData["isChecked"]))
                        $database -> query("UPDATE `enr_statements` SET `isChecked` = 1 WHERE `id` = {$enrolleeData["id"]}");
                    $key = [
                        "specialty" => $database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$enrolleeData["specialty"]}") -> fetch_assoc()["compositeKey"],
                        "level" => $database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$enrolleeData["degree"]}") -> fetch_assoc()["compositeKey"],
                        "count" => $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$enrolleeData["id"]}") -> fetch_assoc()["compositeKey"],
                        "year" => Date("Y", $enrolleeData["timestamp"]),
                    ];
                    $some_y = $pdf -> GetY();
                    $pdf -> Image("https://{$json -> address}/api/qr?text=https://{$json -> address}/login", 115, 5, 30, 30, "PNG");
                    $pdf -> SetY($some_y);
                    $pdf -> Cell(100, 5, $pdf -> cyrilic("Р А С П И С К А № {$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$enrolleeData["id"]})"), 0, 0, "C");
                    $pdf -> Ln();
                    $pdf -> Cell(53.5, 5, $pdf -> cyrilic("о приёме документов ("), 0, 0, "R");
                    $pdf -> SetX($pdf -> GetX() - 1);
                    if ($enrolleeData["educationalType"] == "fulltime")
                        $pdf -> Cell(36, 5, $pdf -> cyrilic("дневное отделение"), "B");
                    elseif ($enrolleeData["educationalType"] == "extramural")
                        $pdf -> Cell(36, 5, $pdf -> cyrilic("заочное отделение"), "B");
                    $pdf -> SetX($pdf -> GetX() - 1);
                    $pdf -> Cell(2, 5, ")");
                    $pdf -> Ln();
                    $pdf -> SetFont("PTSerif", "", 10);
                    $pdf -> Cell(100, 5, $pdf -> cyrilic("Настоящая расписка подтверждает, что абитуриент"));
                    $pdf -> Ln();
                    $pdf -> Cell(100, 5, $pdf -> cyrilic("{$crypt -> decrypt($enrolleeData["lastname"])} {$crypt -> decrypt($enrolleeData["firstname"])} {$crypt -> decrypt($enrolleeData["patronymic"])}"), "B", 0, "C");
                    $pdf -> Ln();
                    $pdf -> SetFont("PTSerif", "", 7);
                    $pdf -> Cell(100, 5, $pdf -> cyrilic("(фамилия, имя, отчество (при наличии))"), 0, 0, "C");
                    $pdf -> Ln();
                    $pdf -> SetFont("PTSerif", "", 10);
                    $pdf -> MultiCell(130, 5, $pdf -> cyrilic(($enrolleeData["sex"] == "1" ? "подал" : "подала") . " в Приемную комиссию {$json -> school -> name -> halfShort -> genitive} следующие документы:"));
                    $attachedDocs = json_decode($crypt -> decrypt($enrolleeData["attachedDocs"]));
                    $attachedDocsNames = ["Заявление о приеме на " . ($enrolleeData["educationalType"] == "fulltime" ? "очную" : "заочную") . " форму обучения"];
                    if ($enrolleeData["withOriginalDiploma"] == "1")
                        $attachedDocsNames[] = "Оригинал документа об образовании";
                    foreach ($attachedDocs as $value)
                        $attachedDocsNames[] = $database -> query("SELECT `name` FROM `enr_attached_docs` WHERE `id` = {$value}") -> fetch_assoc()["name"];
                    $pdf -> setList($attachedDocsNames);
                    $pdf -> Ln(5);
                    $pdf -> SetFont("PTSerif", "B", 10);
                    $pdf -> Cell(130, 5, $pdf -> cyrilic("УВАЖАЕМЫЙ АБИТУРИЕНТ!"), 0, 0, "C");
                    $pdf -> SetFont("PTSerif", "", 10);
                    $pdf -> Ln();
                    $pdf -> MultiCell(130, 5, $pdf -> cyrilic("    Обращаем Ваше внимание на то, что эта расписка является удостоверяющим документом в Приемной комиссии {$json -> school -> name -> short}. Выдача или принятие документов в Приемной комиссии возможна только при предъявлении данной Расписки или документа, удостоверяющего личность (паспорт). Вся информация отражена на сайте Образовательной организации."));
                    $pdf -> Ln();
                    $pdf -> SetFont("PTSerif", "B", 10);
                    $y = $pdf -> GetY();
                    if (!boolval($enrolleeData["isOnline"]) && empty($enrolleeData["usersId"])) {
                        $_auth_enrollee = [
                            "login" => create_random_string(6),
                            "password" => create_random_string(8),
                        ];
                        $_login = hash("SHA256", $_auth_enrollee["login"]);
                        while ($database -> query("SELECT `id` FROM `main_user_auth` WHERE `login` = '{$_login}';") -> num_rows != 0) {
                            $_auth_enrollee["login"] = create_random_string(6);
                            $_login = hash("SHA256", $_auth_enrollee["login"]);
                        }
                        $database -> query("INSERT INTO `main_users` (`firstname`, `lastname`, `patronymic`, `birthday`, `email`, `telephone`) VALUES ('{$enrolleeData["firstname"]}', '{$enrolleeData["lastname"]}', '{$enrolleeData["patronymic"]}', '{$enrolleeData["birthday"]}', '{$enrolleeData["email"]}', '{$enrolleeData["telephone"]}');");
                        $t_id = $database -> insert_id;
                        $database -> query("INSERT INTO `main_user_auth` (`login`, `password`, `levels`, `usersId`) VALUES ('$_login', '" . password_hash($_auth_enrollee["password"], PASSWORD_DEFAULT) . "', '{$crypt -> encrypt(json_encode([1003]))}', $t_id);");
                        $database -> query("UPDATE `enr_statements` SET `usersId` = {$t_id} WHERE `id` = {$enrolleeData["id"]}");
                        $pdf -> Cell(130, 5, $pdf -> cyrilic("Данные для личного кабинета"), 0, 0, "C");
                        $pdf -> SetFont("PTSerif", "", 10);
                        $pdf -> Ln(10);
                        $y = $pdf -> GetY();
                        $pdf -> Cell(20, 5, $pdf -> cyrilic("Логин:"));
                        $pdf -> SetFont("PTMono", "", 10);
                        $pdf -> Cell(80, 5, $_auth_enrollee["login"]);
                        $pdf -> SetFont("PTSerif", "", 10);
                        $pdf -> Ln();
                        $pdf -> Cell(20, 5, $pdf -> cyrilic("Пароль:"));
                        $pdf -> SetFont("PTMono", "", 10);
                        $pdf -> Cell(80, 5, $_auth_enrollee["password"]);
                    }
                    $pdf -> SetFont("PTSerif", "", 10);
                    $pdf -> Ln();
                    $pdf -> Cell(20, 5, $pdf -> cyrilic("Сайт:"));
                    $pdf -> SetFont("PTMono", "", 10);
                    $pdf -> Cell(80, 5, "https://{$json -> address}");
                    $pdf -> SetFont("PTSerif", "", 10);
                    $pdf -> Ln();
                    $pdf -> Cell(20, 5, $pdf -> cyrilic("Телефон:"));
                    $pdf -> SetFont("PTMono", "", 10);
                    $pdf -> Cell(80, 5, "{$json -> school -> telephones -> enrollment}");
                    $pdf -> SetFont("PTSerif", "", 10);
                    return $pdf -> Output("S");
                }
                $database -> close();
            } else
                return false;
        } else
            return false;
    }
    function hostel($user = [], int $id = -1) {
        if (!empty($user) && $id != -1) {
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                require __DIR__ . "/../../../configurations/database/class.php";
                $enrolleeData = $database -> query("SELECT * FROM `enr_statements` WHERE `id` = {$id} AND `hostel` = 1;");
                if ($enrolleeData -> num_rows == 1) {
                    $enrolleeData = $enrolleeData -> fetch_assoc();
                    if (boolval($enrolleeData["hostel"])) {
                        require_once __DIR__ . "/../../../configurations/main.php";
                        require __DIR__ . "/../../../configurations/cipher-keys.php";
                        $crypt = new CryptService($ciphers["database"]);
                        $json = json_decode(file_get_contents(__DIR__ . "/../../../configurations/json/about.json"));
                        $petrovich = new Petrovich();
                        class hostelpdf extends fpdf {
                            public $enrollee = [];

                            function footer() {
                                $json = json_decode(file_get_contents(__DIR__ . "/../../../configurations/json/about.json"));
                                $this -> SetY(-15);
                                $this -> SetX(10);
                                $this -> SetFont("PTSerif", "", 7);
                                $this -> Cell(106, 3, "");
                                $this -> Cell(40, 4, $this -> cyrilic("(подпись)"), 0, 0, "C");
                                $this -> Cell(4, 4, "", 0, 0, "C");
                                $this -> Cell(40, 4, $this -> cyrilic("(расшифровка)"), 0, 0, "C");
                                $now["day"] = date("d");
                                $now["year"] = date("y");
                                switch (date("n")) {
                                    case "1":
                                        $now["month"] = $this-> cyrilic("января");
                                    break;
                                    case "2":
                                        $now["month"] = $this-> cyrilic("февраля");
                                    break;
                                    case "3":
                                        $now["month"] = $this-> cyrilic("марта");
                                    break;
                                    case "4":
                                        $now["month"] = $this-> cyrilic("апреля");
                                    break;
                                    case "5":
                                        $now["month"] = $this-> cyrilic("мая");
                                    break;
                                    case "6":
                                        $now["month"] = $this-> cyrilic("июня");
                                    break;
                                    case "7":
                                        $now["month"] = $this-> cyrilic("июля");
                                    break;
                                    case "8":
                                        $now["month"] = $this-> cyrilic("августа");
                                    break;
                                    case "9":
                                        $now["month"] = $this-> cyrilic("сентября");
                                    break;
                                    case "10":
                                        $now["month"] = $this-> cyrilic("октября");
                                    break;
                                    case "11":
                                        $now["month"] = $this-> cyrilic("ноября");
                                    break;
                                    case "12":
                                        $now["month"] = $this-> cyrilic("декабря");
                                    break;
                                }
                                $this -> Ln(-4);
                                $this -> SetFont("PTSerif", "", 13);
                                $this -> Cell(4, 4, $this -> cyrilic("«"));
                                $this -> Cell(6, 4, $now["day"], "B", 0, "C");
                                $this -> Cell(4, 4, $this -> cyrilic("»"));
                                $this -> Cell(24, 4, $now["month"], "B", 0, "C");
                                $this -> Cell(6.5, 4, "20");
                                $this -> Cell(5, 4, $now["year"], "B", 0, "C");
                                $this -> Cell(4, 4, $this -> cyrilic("г."));
                                $this -> Cell(52.5, 4, "");
                                $this -> Cell(40, 4, "", "B");
                                $this -> Cell(4, 4, "/", 0, 0, "C");
                                $this -> enrollee["firstname"] = mb_substr($this -> enrollee["firstname"], 0, 1) . ". ";
                                $this -> enrollee["patronymic"] = !empty($this -> enrollee["patronymic"]) ? mb_substr($this -> enrollee["patronymic"], 0, 1) . ". " : "";
                                $this -> Cell(40, 4, $this -> cyrilic("{$this -> enrollee["firstname"]}{$this -> enrollee["patronymic"]}{$this -> enrollee["lastname"]}"), "B");
                                $this -> Ln(-4);
                            }

                            function setList($_data) {
                                foreach ($_data as $key => $value) {
                                    $this -> Cell(10, 5, strval($key + 1) . ".");
                                    $this -> MultiCell(180, 5, $key + 1 != count($_data) ? $this -> cyrilic($value . ";") : $this -> cyrilic($value . "."));
                                }
                            }

                            function setName($_enr) {
                                $this -> enrollee = $_enr;
                            }
                        }
                        # width 190
                        $pdf = new hostelpdf();
                        $pdf -> AddFont("PTSerif", "", "PTSerif-Regular.php");
                        $pdf -> AddFont("PTSerif", "B", "PTSerif-Bold.php");
                        $pdf -> AddFont("PTSerif", "I", "PTSerif-Italic.php");
                        $pdf -> AddFont("PTSerif", "BI", "PTSerif-BoldItalic.php");
                        $pdf -> AddFont("PTMono", "", "PTMono-Regular.php");
                        $pdf -> setName([
                            "firstname" => $crypt -> decrypt($enrolleeData["firstname"]),
                            "lastname" => $crypt -> decrypt($enrolleeData["lastname"]),
                            "patronymic" => !empty($enrolleeData["patronymic"]) ? $crypt -> decrypt($enrolleeData["patronymic"]) : NULL,
                        ]);
                        $pdf -> AliasNbPages();
                        $pdf -> AddPage();
                        $pdf -> SetFont("PTSerif", "", 13);
                        $pdf -> Cell(97, 5, "");
                        $petrovich -> setSex($json -> school -> principal -> sex);
                        $json -> school -> principal -> firstname = mb_substr($json -> school -> principal -> firstname, 0, 1);
                        $json -> school -> principal -> patronymic = mb_substr($json -> school -> principal -> patronymic, 0, 1);
                        $pdf -> MultiCell(93, 5, $pdf -> cyrilic("Директору {$json -> school -> name -> halfShort -> genitive} {$petrovich -> lastname($json -> school -> principal -> lastname, Petrovich::CASE_GENITIVE)} {$json -> school -> principal -> firstname}. {$json -> school -> principal -> patronymic}."));
                        $pdf -> Cell(97, 5, "");
                        $pdf -> Cell(8, 5, $pdf -> cyrilic("от"));
                        $petrovich -> setSex(intval($enrolleeData["sex"]));
                        $pdf -> MultiCell(85, 5, $pdf -> cyrilic("{$petrovich -> lastname($crypt -> decrypt($enrolleeData["lastname"]), Petrovich::CASE_GENITIVE)} {$petrovich -> lastname($crypt -> decrypt($enrolleeData["firstname"]), Petrovich::CASE_GENITIVE)} " . (!empty($crypt -> decrypt($enrolleeData["patronymic"])) ? $petrovich -> middlename($crypt -> decrypt($enrolleeData["patronymic"]), Petrovich::CASE_GENITIVE) : "")), "B");
                        $pdf -> Cell(97, 5, "");
                        $pdf -> Cell(93, 5, $pdf -> cyrilic("Домашний и (или) мобильный телефон:"));
                        $pdf -> Ln();
                        $pdf -> Cell(97, 5, "");
                        $pdf -> MultiCell(93, 5, $pdf -> cyrilic((!empty($enrolleeData["homeTelephone"]) ? "{$crypt -> decrypt($enrolleeData["homeTelephone"])}, " : "") . "{$crypt -> decrypt($enrolleeData["telephone"])}"), "B");
                        $pdf -> Cell(97, 5, "");
                        $pdf -> Cell(93, 5, $pdf -> cyrilic("Адрес электронной почты (при наличии):"));
                        $pdf -> Ln();
                        $pdf -> Cell(97, 5, "");
                        $pdf -> MultiCell(93, 5, $pdf -> cyrilic("{$crypt -> decrypt($enrolleeData["email"])}"), "B");
                        $pdf -> Ln();
                        $pdf -> SetFont("PTSerif", "B", 13);
                        if (empty($enrolleeData["hostelNumber"])) {
                            $count = $database -> query("SELECT `hostelNumber` FROM `enr_statements` WHERE `educationalType` = 'fulltime' AND `hostel` = 1 ORDER BY `hostelNumber` DESC LIMIT 1;") -> fetch_assoc()["hostelNumber"];
                            if (empty($count)) {
                                $database -> query("UPDATE `enr_statements` SET `hostelNumber` = 1 WHERE `id` = {$enrolleeData["id"]};");
                                $enrolleeData["hostelNumber"] = 1;
                            } else {
                                $database -> query("UPDATE `enr_statements` SET `hostelNumber` = " . strval(intval($count) + 1) . " WHERE `id` = {$enrolleeData["id"]};");
                                $enrolleeData["hostelNumber"] = intval($count) + 1;
                            }
                        }
                        $pdf -> Cell(190, 5, $pdf -> cyrilic("З А Я В Л Е Н И Е № {$enrolleeData["hostelNumber"]}"), 0, 0, "C");
                        $pdf -> Ln();
                        $pdf -> SetFont("PTSerif", "", 13);
                        $room = $database -> query("SELECT `name` FROM `enr_hostel_rooms` WHERE `id` = {$enrolleeData["hostelRoom"]}") -> fetch_assoc()["name"];
                        $pdf -> MultiCell(190, 5, $pdf -> cyrilic("    Прошу предоставить мне место в студенческом общежитии в комнате типа «{$room}», так как являюсь иногородним студентом."));
                        $pdf -> Ln();
                        $pdf -> Cell(190, 5, $pdf -> cyrilic("О себе сообщаю следующие данные:"));
                        $pdf -> Ln();
                        $pdf -> Cell(40, 5, $pdf -> cyrilic("Дата рождения:"));
                        $birthdate = explode("-", $crypt -> decrypt($enrolleeData["birthday"]));
                        switch ($birthdate[1]) {
                            case "1":
                                $birthdate[1] = "января";
                            break;
                            case "2":
                                $birthdate[1] = "февраля";
                            break;
                            case "3":
                                $birthdate[1] = "марта";
                            break;
                            case "4":
                                $birthdate[1] = "апреля";
                            break;
                            case "5":
                                $birthdate[1] = "мая";
                            break;
                            case "6":
                                $birthdate[1] = "июня";
                            break;
                            case "7":
                                $birthdate[1] = "июля";
                            break;
                            case "8":
                                $birthdate[1] = "августа";
                            break;
                            case "9":
                                $birthdate[1] = "сентября";
                            break;
                            case "10":
                                $birthdate[1] = "октября";
                            break;
                            case "11":
                                $birthdate[1] = "ноября";
                            break;
                            case "12":
                                $birthdate[1] = "декабря";
                            break;
                        }
                        $pdf -> Cell(150, 5, $pdf -> cyrilic("{$birthdate[2]} {$birthdate[1]} {$birthdate[0]} г.р."), "B", 0, "C");
                        $pdf -> Ln();
                        $passport = json_decode($crypt -> decrypt($enrolleeData["passport"]));
                        $pdf -> Cell(40, 5, $pdf -> cyrilic("Паспорт:"));
                        $pdf -> Cell(35, 5, $pdf -> cyrilic("серия и номер:"));
                        $pdf -> Cell(40, 5, $pdf -> cyrilic("{$passport -> series} {$passport -> number}"), "B", 0, "C");
                        $pdf -> Cell(35, 5, $pdf -> cyrilic("дата выдачи:"));
                        $passport -> date = explode("-", $passport -> date);
                        $pdf -> Cell(40, 5, $pdf -> cyrilic("{$passport -> date[2]}.{$passport -> date[1]}.{$passport -> date[0]}"), "B", 0, "C");
                        $pdf -> Ln();
                        $pdf -> Cell(65, 5, $pdf -> cyrilic("выдан, код подразделения:"));
                        $pdf -> MultiCell(125, 5, $pdf -> cyrilic("{$passport -> place}, {$passport -> code}"), "B");
                        $address = json_decode($crypt -> decrypt($enrolleeData["address"]));
                        $addressLine = "{$address -> region}, {$address -> city}, ул. {$address -> street}, д. {$address -> house}";
                        $addressLine .= !empty($address -> building) ? ", стр. {$address -> building}" : "";
                        $addressLine .= !empty($address -> flat) ? ", кв. {$address -> flat}" : "";
                        $pdf -> Cell(65, 5, $pdf -> cyrilic("Домашний адрес:"));
                        $pdf -> MultiCell(125, 5, $pdf -> cyrilic("{$address -> zipCode}, {$address -> country}, {$addressLine}"), "B");
                        $pdf -> Cell(65, 5, "");
                        $pdf -> SetFont("PTSerif", "", 7);
                        $pdf -> Cell(125, 5, $pdf -> cyrilic("(индекс, адрес прописки)"), 0, 0, "C");
                        $pdf -> SetFont("PTSerif", "", 13);
                        $pdf -> Ln(10);
                        $pdf -> SetFont("PTSerif", "B", 13);
                        $pdf -> Cell(28, 5, $pdf -> cyrilic("ОБЯЗУЮСЬ:"), "B", 0, "C");
                        $pdf -> SetFont("PTSerif", "", 13);
                        $pdf -> Ln(10);
                        $pdf -> setList([
                            "Выполнять правила внутреннего распорядка в общежитии",
                            "Соблюдать правила, установленные Федеральным законом № 87-ФЗ «Об ограничении курения»",
                            "Соблюдать правила, установленные Федеральным законом № 15-ФЗ «Об охране здоровья граждан от воздействия окружающего табачного дыма и последствий потребления табака»",
                            "Выполнять требования органов студенческого самоуправления",
                        ]);
                        $pdf -> Ln(10);
                        $pdf -> SetFont("PTSerif", "I", 13);
                        $pdf -> MultiCell(190, 5, $pdf -> cyrilic("В случае нарушения вышеприведённых ОБЯЗАТЕЛЬСТВ расторгнуть договор о проживании в студенческом общежитии."));
                        $pdf -> Ln();
                        $pdf -> SetFont("PTSerif", "B", 13);
                        $pdf -> MultiCell(190, 5, $pdf -> cyrilic("Заключенное Заявление на проживание в студенческом общежитии НЕ ЯВЛЯЕТСЯ гарантией на предоставление места в студентческом общежитии."));
                        return $pdf -> Output("S");
                    } else
                        return false;
                } else
                    return false;
                $database -> close();

            } else
                return false;
        } else
            return false;
    }

    function operationalSummary($user = [], string $type = "all") {
        if (!empty($user)) {
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                require __DIR__ . "/../../../configurations/database/class.php";
                require __DIR__ . "/../../../libraries/fpdf/scripts/pdf-mc-tables.php";
                class operationalSummaryPdf extends PDF_MC_Table {
                    function header() {
                        $this -> SetFont("PTSerif", "B", 12);
                        $this -> MultiCell(190, 4, $this -> cyrilic("ОПЕРАТИВНАЯ СВОДКА ПРИЕМНОЙ КАМПАНИИ " . Date("Y", time()) . " ГОДА"), 0, "C");
                        $this -> SetFont("PTSerif", "", 12);
                        $this -> MultiCell(190, 4, $this -> cyrilic("Дата создания оперативной сводки: " . Date("d.m.Y", time()) . "."), 0, "R");
                        $this -> Ln(8);
                    }
                }
                $pdf = new operationalSummaryPdf();
                $pdf -> AddFont("PTSerif", "", "PTSerif-Regular.php");
                $pdf -> AddFont("PTSerif", "B", "PTSerif-Bold.php");
                $pdf -> AddFont("PTSerif", "I", "PTSerif-Italic.php");
                $pdf -> AddFont("PTSerif", "BI", "PTSerif-BoldItalic.php");
                $pdf -> AddFont("PTMono", "", "PTMono-Regular.php");
                $pdf -> AliasNbPages();
                $pdf -> AddPage();
                $pdf -> SetFont("PTSerif", "", 12);
                if ($type == "all" || $type == "fulltime") {
                    $pdf -> Cell(190, 5, $pdf -> cyrilic("ОЧНОЕ ОТДЕЛЕНИЕ"), 0, 0, "C");
                    $pdf -> Ln(8);
                    $levels = $database -> query("SELECT `id`, `name` FROM `enr_education_levels`;");
                    while ($level = $levels -> fetch_assoc()) {
                        $pdf -> SetFont("PTSerif", "B", 12);
                        $pdf -> SetWidths([12, 103, 25, 25, 25]);
                        $pdf -> MultiCell(190, 5, $pdf -> cyrilic("БАЗА \"{$level["name"]}\""), 0, "C");
                        $pdf -> SetAligns(["C", "C", "C", "C", "C"]);
                        $pdf -> Row([$pdf -> cyrilic("№ п/п"), $pdf -> cyrilic("Специальность"), $pdf -> cyrilic("Подано док-ов"), $pdf -> cyrilic("Оригинал"), $pdf -> cyrilic("Договора")]);
                        $pdf -> SetAligns(["L", "L", "C", "C", "C"]);
                        $pdf -> SetFont("PTSerif", "", 12);
                        $specialties = $database -> query("SELECT `id`, `shortname` FROM `enr_specialties` WHERE `forExtramural` = 0;");
                        $counters = [
                            "allDocs" => 0,
                            "originalDiploma" => 0,
                            "contracts" => 0,
                            "item" => 0,
                        ];
                        while ($specialty = $specialties -> fetch_assoc()) {
                            $calculate = [
                                "allDocs" => intval($database -> query("SELECT COUNT(`id`) FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `isChecked` = 1 AND `specialty` = {$specialty["id"]};") -> fetch_assoc()["COUNT(`id`)"]),
                                "originalDiploma" => intval($database -> query("SELECT COUNT(`id`) FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `isChecked` = 1 AND `specialty` = {$specialty["id"]} AND `withOriginalDiploma` = 1;") -> fetch_assoc()["COUNT(`id`)"]),
                                "contracts" => intval($database -> query("SELECT COUNT(`id`) FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `isChecked` = 1 AND `specialty` = {$specialty["id"]} AND `paysType` = 2;") -> fetch_assoc()["COUNT(`id`)"]),
                            ];
                            $counters["allDocs"] += $calculate["allDocs"];
                            $counters["originalDiploma"] += $calculate["originalDiploma"];
                            $counters["contracts"] += $calculate["contracts"];
                            $counters["item"]++;
                            $pdf -> Row([$pdf -> cyrilic("{$counters["item"]}."), $pdf -> cyrilic("{$specialty["shortname"]}"), $pdf -> cyrilic("{$calculate["allDocs"]}"), $pdf -> cyrilic("{$calculate["originalDiploma"]}"), $pdf -> cyrilic("{$calculate["contracts"]}")]);
                        }
                        $pdf -> SetFont("PTSerif", "B", 12);
                        $pdf -> Cell(115, 4, $pdf -> cyrilic("ИТОГО:"), 1, 0, "R");
                        $pdf -> Cell(25, 4, $pdf -> cyrilic("{$counters["allDocs"]}"), 1, 0, "C");
                        $pdf -> Cell(25, 4, $pdf -> cyrilic("{$counters["originalDiploma"]}"), 1, 0, "C");
                        $pdf -> Cell(25, 4, $pdf -> cyrilic("{$counters["contracts"]}"), 1, 0, "C");
                        $pdf -> Ln(8);
                        $pdf -> SetFont("PTSerif", "", 12);
                    }
                }
                if ($type == "all")
                    $pdf -> AddPage();
                if ($type == "all" || $type == "extramural") {
                    $pdf -> Cell(190, 4, $pdf -> cyrilic("ЗАОЧНОЕ ОТДЕЛЕНИЕ"), 0, 0, "C");
                    $pdf -> Ln(8);
                    $levels = $database -> query("SELECT `id`, `name` FROM `enr_education_levels`;");
                    while ($level = $levels -> fetch_assoc()) {
                        $pdf -> SetFont("PTSerif", "B", 12);
                        $pdf -> SetWidths([12, 103, 25, 25, 25]);
                        $pdf -> MultiCell(190, 5, $pdf -> cyrilic("БАЗА \"{$level["name"]}\""), 0, "C");
                        $pdf -> SetAligns(["C", "C", "C", "C", "C"]);
                        $pdf -> Row([$pdf -> cyrilic("№ п/п"), $pdf -> cyrilic("Специальность"), $pdf -> cyrilic("Подано док-ов"), $pdf -> cyrilic("Оригинал"), $pdf -> cyrilic("Договора")]);
                        $pdf -> SetAligns(["L", "L", "C", "C", "C"]);
                        $pdf -> SetFont("PTSerif", "", 12);
                        $specialties = $database -> query("SELECT `id`, `shortname` FROM `enr_specialties` WHERE `forExtramural` = 1;");
                        $counters = [
                            "allDocs" => 0,
                            "originalDiploma" => 0,
                            "contracts" => 0,
                            "item" => 0,
                        ];
                        while ($specialty = $specialties -> fetch_assoc()) {
                            $calculate = [
                                "allDocs" => intval($database -> query("SELECT COUNT(`id`) FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `isChecked` = 1 AND `specialty` = {$specialty["id"]};") -> fetch_assoc()["COUNT(`id`)"]),
                                "originalDiploma" => intval($database -> query("SELECT COUNT(`id`) FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `isChecked` = 1 AND `specialty` = {$specialty["id"]} AND `withOriginalDiploma` = 1;") -> fetch_assoc()["COUNT(`id`)"]),
                                "contracts" => intval($database -> query("SELECT COUNT(`id`) FROM `enr_statements` WHERE `degree` = {$level["id"]} AND `isChecked` = 1 AND `specialty` = {$specialty["id"]} AND `paysType` = 2;") -> fetch_assoc()["COUNT(`id`)"]),
                            ];
                            $counters["allDocs"] += $calculate["allDocs"];
                            $counters["originalDiploma"] += $calculate["originalDiploma"];
                            $counters["contracts"] += $calculate["contracts"];
                            $counters["item"]++;
                            $pdf -> Row([$pdf -> cyrilic("{$counters["item"]}."), $pdf -> cyrilic("{$specialty["shortname"]}"), $pdf -> cyrilic("{$calculate["allDocs"]}"), $pdf -> cyrilic("{$calculate["originalDiploma"]}"), $pdf -> cyrilic("{$calculate["contracts"]}")]);
                        }
                        $pdf -> SetFont("PTSerif", "B", 12);
                        $pdf -> Cell(115, 4, $pdf -> cyrilic("ИТОГО:"), 1, 0, "R");
                        $pdf -> Cell(25, 4, $pdf -> cyrilic("{$counters["allDocs"]}"), 1, 0, "C");
                        $pdf -> Cell(25, 4, $pdf -> cyrilic("{$counters["originalDiploma"]}"), 1, 0, "C");
                        $pdf -> Cell(25, 4, $pdf -> cyrilic("{$counters["contracts"]}"), 1, 0, "C");
                        $pdf -> Ln(8);
                        $pdf -> SetFont("PTSerif", "", 12);
                    }
                }
                return $pdf -> Output("S");
                $database -> close();
            } else
                return false;
        } else
            return false;
    }

    function listOfEnrollees($user = [], string $type = "fulltime", $withKey = true, $onlyOriginal = false) {
        if (!empty($user)) {
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                require __DIR__ . "/../../../configurations/database/class.php";
                require __DIR__ . "/../../../libraries/fpdf/scripts/pdf-mc-tables.php";
                require_once __DIR__ . "/../../../configurations/main.php";
                require __DIR__ . "/../../../configurations/cipher-keys.php";
                $crypt = new CryptService($ciphers["database"]);
                class listOfEnrolleesPdf extends PDF_MC_Table {
                    function header() {
                        $this -> SetFont("PTSerif", "B", 12);
                        $this -> MultiCell(190, 4, $this -> cyrilic("СПИСКИ АБИТУРИЕНТОВ " . Date("Y", time()) . " ГОДА"), 0, "C");
                        $this -> SetFont("PTSerif", "", 12);
                        $this -> MultiCell(190, 4, $this -> cyrilic("Дата создания списка: " . Date("d.m.Y", time()) . "."), 0, "R");
                        $this -> Ln(8);
                    }
                    function footer() {
                        $this -> SetY(-15);
                        $this -> SetFont("PTSerif", "", 12);
                        $this -> Cell(0, 10, $this -> cyrilic("Страница " . $this -> PageNo()), 0, 0, "C");
                        $this -> Ln(-5);
                        $this -> SetFont("PTMono", "", 12);
                        $this -> Cell(190, 5, $this -> cyrilic("Записи, написанные моноширным шрифтом - без копии Заявления."));
                        $this -> Ln(-5);
                        $this -> SetFont("PTSerif", "I", 12);
                        $this -> Cell(190, 5, $this -> cyrilic("Записи, написанные курсивом - абитуриенты, не попадающие на бюджет."));
                        $this -> SetFont("PTSerif", "", 12);
                        $this -> Ln(-5);
                        $this -> SetFillColor(153, 153, 153);
                        $this -> Cell(5, 5, "", 1, 0, "L", true);
                        $this -> Cell(3, 5, "");
                        $this -> Cell(182, 5, $this -> cyrilic(" - у абитуриента выше такой же средний балл."));
                        $this -> Ln(-5);
                        $this -> SetFillColor(51, 153, 255);
                        $this -> Cell(5, 5, "", 1, 0, "L", true);
                        $this -> Cell(3, 5, "");
                        $this -> Cell(182, 5, $this -> cyrilic(" - абитуриент с заключенным договором."));
                    }
                }
                $pdf = new listOfEnrolleesPdf();
                $pdf -> AddFont("PTSerif", "", "PTSerif-Regular.php");
                $pdf -> AddFont("PTSerif", "B", "PTSerif-Bold.php");
                $pdf -> AddFont("PTSerif", "I", "PTSerif-Italic.php");
                $pdf -> AddFont("PTSerif", "BI", "PTSerif-BoldItalic.php");
                $pdf -> AddFont("PTMono", "", "PTMono-Regular.php");
                $pdf -> AliasNbPages();
                $pdf -> AddPage();
                $pdf -> SetFont("PTSerif", "", 12);
                $firstPage = true;
                if ($type == "fulltime") {
                    $pdf -> Cell(190, 5, $pdf -> cyrilic("ОЧНОЕ ОТДЕЛЕНИЕ"), 0, 0, "C");
                    $pdf -> Ln(8);
                    $specialties = $database -> query("SELECT `id`, `fullname`, `budget` FROM `enr_specialties` WHERE `forExtramural` = 0;");
                    while ($specialty = $specialties -> fetch_assoc()) {
                        if ($firstPage)
                            $firstPage = false;
                        else
                            $pdf -> AddPage();
                        $pdf -> SetFont("PTSerif", "B", 12);
                        $pdf -> SetWidths([14.38, 95, 23.03, 25.92, 31.67]);
                        $pdf -> MultiCell(190, 5, $pdf -> cyrilic(explode("@", $specialty["fullname"])[0]), 0, "C");
                        $pdf -> SetAligns(["C", "C", "C", "C", "C"]);
                        if ($withKey)
                            $pdf -> Row([$pdf -> cyrilic("№ п/п"), $pdf -> cyrilic("ФИО"), $pdf -> cyrilic("Средний балл"), $pdf -> cyrilic("Оригинал"), $pdf -> cyrilic("№ личного дела")]);
                        else
                            $pdf -> Row([$pdf -> cyrilic("№ п/п"), $pdf -> cyrilic("ФИО"), $pdf -> cyrilic("Средний балл"), $pdf -> cyrilic("Оригинал"), $pdf -> cyrilic("Общежитие")]);
                        $pdf -> SetAligns(["L", "L", "C", "C", "C"]);
                        $pdf -> SetFont("PTSerif", "", 12);
                        $counters = [
                            "item" => 1,
                            "previousGrade" => 0,
                        ];
                        $pdf -> SetFillColor(255, 255, 255);
                        if ($onlyOriginal)
                            $enrollees = $database -> query("SELECT `id`, `specialty`, `degree`, `timestamp`, `firstname`, `lastname`, `patronymic`, `averageMark`, `hostel`, `paysType`, `withOriginalDiploma`, `withStatement`, `isOnline` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1 AND `withOriginalDiploma` = 1 ORDER BY `averageMark` DESC;");
                        else
                            $enrollees = $database -> query("SELECT `id`, `specialty`, `degree`, `timestamp`, `firstname`, `lastname`, `patronymic`, `averageMark`, `hostel`, `paysType`, `withOriginalDiploma`, `withStatement`, `isOnline` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1 ORDER BY `averageMark` DESC;");
                        if ($enrollees -> num_rows != 0)
                            while ($enrollee = $enrollees -> fetch_assoc()) {
                                $fill = [];
                                if ($counters["item"] > intval($specialty["budget"]))
                                    $pdf -> SetFont("PTSerif", "I", 12);
                                if ($counters["previousGrade"] == floatval($enrollee["averageMark"])) {
                                    $pdf -> SetFillColor(153, 153, 153);
                                    $fill = [true, true, true, true, true];
                                }
                                if ($enrollee["paysType"] == "2") {
                                    $pdf -> SetFillColor(51, 153, 255);
                                    $fill = [true, true, true, true, true];
                                }
                                if (!boolval($enrollee["withStatement"]) && boolval($enrollee["isOnline"]))
                                    $pdf -> SetFont("PTMono", "", 12);
                                if ($counters["item"] % 40 == 0)
                                    $pdf -> AddPage();
                                if ($withKey) {
                                    $key = [
                                        "specialty" => $database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$enrollee["specialty"]}") -> fetch_assoc()["compositeKey"],
                                        "level" => $database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$enrollee["degree"]}") -> fetch_assoc()["compositeKey"],
                                        "count" => $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$enrollee["id"]}") -> fetch_assoc()["compositeKey"],
                                        "year" => Date("Y", $enrollee["timestamp"]),
                                    ];
                                    $pdf -> Row(["{$counters["item"]}.", $pdf -> cyrilic("{$crypt -> decrypt($enrollee["lastname"])} {$crypt -> decrypt($enrollee["firstname"])} " . (!empty($enrollee["patronymic"]) ? "{$crypt -> decrypt($enrollee["patronymic"])}" : "")), $enrollee["averageMark"], (boolval($enrollee["withOriginalDiploma"]) ? "+" : "-"), $pdf -> cyrilic("{$key["count"]}-{$key["level"]}-{$key["specialty"]}")], $fill);
                                } else
                                    $pdf -> Row(["{$counters["item"]}.", $pdf -> cyrilic("{$crypt -> decrypt($enrollee["lastname"])} {$crypt -> decrypt($enrollee["firstname"])} " . (!empty($enrollee["patronymic"]) ? "{$crypt -> decrypt($enrollee["patronymic"])}" : "")), $enrollee["averageMark"], (boolval($enrollee["withOriginalDiploma"]) ? "+" : "-"), (boolval($enrollee["hostel"]) ? "+" : "-")], $fill);
                                $counters["item"]++;
                                $counters["previousGrade"] = floatval($enrollee["averageMark"]);
                                $pdf -> SetFont("PTSerif", "", 12);
                            }
                    }
                    return $pdf -> Output("S");
                } elseif ($type == "extramural") {
                    $pdf -> Cell(190, 5, $pdf -> cyrilic("ЗАОЧНОЕ ОТДЕЛЕНИЕ"), 0, 0, "C");
                    $pdf -> Ln(8);
                    $specialties = $database -> query("SELECT `id`, `fullname`, `budget` FROM `enr_specialties` WHERE `forExtramural` = 1;");
                    while ($specialty = $specialties -> fetch_assoc()) {
                        if ($firstPage)
                            $firstPage = false;
                        else
                            $pdf -> AddPage();
                        $pdf -> SetFont("PTSerif", "B", 12);
                        $pdf -> SetWidths([14.4, 115.14, 25.92, 34.54]);
                        $pdf -> MultiCell(190, 5, $pdf -> cyrilic(explode("@", $specialty["fullname"])[0]), 0, "C");
                        $pdf -> SetAligns(["C", "C", "C", "C"]);
                        $pdf -> Row([$pdf -> cyrilic("№ п/п"), $pdf -> cyrilic("ФИО"), $pdf -> cyrilic("Средний балл"), $pdf -> cyrilic("Оригинал")]);
                        $pdf -> SetAligns(["L", "L", "C", "C"]);
                        $pdf -> SetFont("PTSerif", "", 12);
                        $counters = [
                            "item" => 1,
                            "previousGrade" => 0,
                        ];
                        $pdf -> SetFillColor(255, 255, 255);
                        $enrollees = $database -> query("SELECT `id`, `specialty`, `degree`, `timestamp`, `firstname`, `lastname`, `patronymic`, `averageMark`, `paysType`, `withOriginalDiploma`, `withStatement`, `isOnline` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `isChecked` = 1 ORDER BY `averageMark` DESC;");
                        if ($enrollees -> num_rows != 0)
                            while ($enrollee = $enrollees -> fetch_assoc()) {
                                $fill = [];
                                if ($counters["item"] > intval($specialty["budget"]))
                                    $pdf -> SetFont("PTSerif", "I", 12);
                                if ($counters["previousGrade"] == floatval($enrollee["averageMark"])) {
                                    $pdf -> SetFillColor(153, 153, 153);
                                    $fill = [true, true, true, true, true];
                                }
                                if ($enrollee["paysType"] == "2") {
                                    $pdf -> SetFillColor(51, 153, 255);
                                    $fill = [true, true, true, true, true];
                                }
                                if (!boolval($enrollee["withStatement"]) && boolval($enrollee["isOnline"]))
                                    $pdf -> SetFont("PTMono", "", 12);
                                if ($counters["item"] % 40 == 0)
                                    $pdf -> AddPage();
                                $key = [
                                    "specialty" => $database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$enrollee["specialty"]}") -> fetch_assoc()["compositeKey"],
                                    "level" => $database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$enrollee["degree"]}") -> fetch_assoc()["compositeKey"],
                                    "count" => $database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$enrollee["id"]}") -> fetch_assoc()["compositeKey"],
                                    "year" => Date("Y", $enrollee["timestamp"]),
                                ];
                                $pdf -> Row(["{$counters["item"]}.", $pdf -> cyrilic("{$crypt -> decrypt($enrollee["lastname"])} {$crypt -> decrypt($enrollee["firstname"])} " . (!empty($enrollee["patronymic"]) ? "{$crypt -> decrypt($enrollee["patronymic"])}" : "")), !empty($enrollee["averageMark"]) ? $enrollee["averageMark"] : "-", (boolval($enrollee["withOriginalDiploma"]) ? "+" : "-")], $fill);
                                $counters["item"]++;
                                $counters["previousGrade"] = floatval($enrollee["averageMark"]);
                                $pdf -> SetFont("PTSerif", "", 12);
                            }
                    }
                    return $pdf -> Output("S");
                } else
                    return false;
                $database -> close();
            } else
                return false;
        } else
            return false;
    }
    function listOfHostel($user = []) {
        if (!empty($user)) {
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                require __DIR__ . "/../../../configurations/database/class.php";
                require __DIR__ . "/../../../libraries/fpdf/scripts/pdf-mc-tables.php";
                require_once __DIR__ . "/../../../configurations/main.php";
                require __DIR__ . "/../../../configurations/cipher-keys.php";
                $crypt = new CryptService($ciphers["database"]);
                class listOfHostelPdf extends PDF_MC_Table {
                    function header() {
                        $this -> SetFont("PTSerif", "B", 12);
                        $this -> MultiCell(190, 4, $this -> cyrilic("СПИСОК АБИТУРИЕНТОВ НА ЗАСЕЛЕНИЕ В ОБЩЕЖИТИЕ"), 0, "C");
                        $this -> SetFont("PTSerif", "", 12);
                        $this -> MultiCell(190, 4, $this -> cyrilic("Дата создания списка: " . Date("d.m.Y", time()) . "."), 0, "R");
                        $this -> Ln(8);
                    }
                    function footer() {
                        $this -> SetY(-15);
                        $this -> SetFont("PTSerif", "", 12);
                        $this -> Cell(0, 10, $this -> cyrilic("Страница " . $this -> PageNo()), 0, 0, "C");
                    }
                }
                $pdf = new listOfHostelPdf();
                $pdf -> AddFont("PTSerif", "", "PTSerif-Regular.php");
                $pdf -> AddFont("PTSerif", "B", "PTSerif-Bold.php");
                $pdf -> AddFont("PTSerif", "I", "PTSerif-Italic.php");
                $pdf -> AddFont("PTSerif", "BI", "PTSerif-BoldItalic.php");
                $pdf -> AddFont("PTMono", "", "PTMono-Regular.php");
                $pdf -> AliasNbPages();
                $pdf -> AddPage();
                $pdf -> SetFont("PTSerif", "B", 12);
                $pdf -> SetWidths([9.88, 25.95, 71.67, 24.13, 39.84, 18.53]);
                $pdf -> SetAligns(["C", "C", "C", "C", "C", "C"]);
                $pdf -> Row([$pdf -> cyrilic("№ п/п"), $pdf -> cyrilic("№ заявления"), $pdf -> cyrilic("ФИО"), $pdf -> cyrilic("Специаль\nность"), $pdf -> cyrilic("Населённый пункт"), ">18"]);
                $pdf -> SetAligns(["L", "L", "L", "C", "L", "C"]);
                $pdf -> SetFont("PTSerif", "", 12);
                $item = 1;
                $enrollees = $database -> query("SELECT `firstname`, `lastname`, `patronymic`, `hostelNumber`, `birthday`, `specialty`, `address` FROM `enr_statements` WHERE `hostel` = 1 AND `isChecked` = 1;");
                if ($enrollees -> num_rows != 0)
                    while ($enrollee = $enrollees -> fetch_assoc()) {
                        $sub_data = [
                            "fullname" => "{$crypt -> decrypt($enrollee["lastname"])} {$crypt -> decrypt($enrollee["firstname"])} " . (!empty($enrollee["patronymic"]) ? "{$crypt -> decrypt($enrollee["patronymic"])}" : ""),
                            "hostelNumber" => intval($enrollee["hostelNumber"]),
                            "birthday" => explode("-", $crypt -> decrypt($enrollee["birthday"])),
                            "specialty" => $database -> query("SELECT `shortname` FROM `enr_specialties` WHERE `id` = {$enrollee["specialty"]};") -> fetch_assoc()["shortname"],
                            "address" => json_decode($crypt -> decrypt($enrollee["address"])),
                        ];
                        $_now = explode(".", Date("Y.m.d"));
                        $_years = intval($_now[0]) - intval($sub_data["birthday"][0]);
                        if (intval($now[1]) > intval($sub_data["birthday"][1]))
                            $_years++;
                        elseif (intval($now[1]) == intval($sub_data["birthday"][1])) {
                            if (intval($now[2]) <= intval($sub_data["birthday"][2]))
                                $_years--;
                        } elseif (intval($now[1]) < intval($sub_data["birthday"][1]))
                            $_years--;
                        $is_adult = $_years >= 18 ? true : false;
                        $pdf -> Row([$pdf -> cyrilic("{$item}."), "{$sub_data["hostelNumber"]}", $pdf -> cyrilic("{$sub_data["fullname"]}"), $pdf -> cyrilic("{$sub_data["specialty"]}"), $pdf -> cyrilic("{$sub_data["address"] -> city}"), $is_adult ? "+" : "-"]);
                        $item++;
                    }
                return $pdf -> Output("S");
                $database -> close();
            } else
                return false;
        } else
            return false;
    }

    function analysisOfNames($user = []) {
        if (!empty($user)) {
            if ($user -> check_level(1001) || $user -> check_level(1002)) {
                require __DIR__ . "/../../../configurations/database/class.php";
                require __DIR__ . "/../../../libraries/fpdf/scripts/pdf-mc-tables.php";
                require_once __DIR__ . "/../../../configurations/main.php";
                require __DIR__ . "/../../../configurations/cipher-keys.php";
                $crypt = new CryptService($ciphers["database"]);
                class analysisOfNamesPDF extends PDF_MC_Table {
                    function header() {
                        $this -> SetFont("PTSerif", "B", 12);
                        $this -> MultiCell(190, 4, $this -> cyrilic("АНАЛИЗАЦИОННЫЙ СПИСОК АБИТУРИЕНТОВ"), 0, "C");
                        $this -> SetFont("PTSerif", "", 12);
                        $this -> MultiCell(190, 4, $this -> cyrilic("Дата создания списка: " . Date("d.m.Y", time()) . "."), 0, "R");
                        $this -> Ln(8);
                    }
                    function footer() {
                        $this -> SetY(-15);
                        $this -> SetFont("PTSerif", "", 12);
                        $this -> Cell(0, 10, $this -> cyrilic("Страница " . $this -> PageNo()), 0, 0, "C");
                    }
                }
                $pdf = new analysisOfNamesPDF();
                $pdf -> AddFont("PTSerif", "", "PTSerif-Regular.php");
                $pdf -> AddFont("PTSerif", "B", "PTSerif-Bold.php");
                $pdf -> AddFont("PTSerif", "I", "PTSerif-Italic.php");
                $pdf -> AddFont("PTSerif", "BI", "PTSerif-BoldItalic.php");
                $pdf -> AddFont("PTMono", "", "PTMono-Regular.php");
                $pdf -> AliasNbPages();
                $pdf -> AddPage();
                $pdf -> SetWidths([12, 70.59, 59.91, 47.5]);
                $pdf -> SetFont("PTSerif", "", 12);
                $enrollees = $database -> query("SELECT COUNT(`id`) AS `counter`, `firstname`, `lastname`, `patronymic` FROM `enr_statements` GROUP BY `firstname`, `lastname`, `patronymic`;");
                if ($enrollees -> num_rows != 0) {
                    $mainCounter = 1;
                    while ($check_enrollee = $enrollees -> fetch_assoc()) {
                        if (intval($check_enrollee["counter"]) > 1) {
                            $pdf -> Cell(190, 4, $pdf -> cyrilic("{$mainCounter}. {$crypt -> decrypt($check_enrollee["lastname"])} {$crypt -> decrypt($check_enrollee["firstname"])} " . (!empty($check_enrollee["patronymic"]) ? $crypt -> decrypt($check_enrollee["patronymic"]) : "")));
                            $pdf -> Ln();
                            $query = $database -> query("SELECT `email`, `telephone`, `homeTelephone`, `timestamp`, `specialty` FROM `enr_statements` WHERE `lastname` = '{$check_enrollee["lastname"]}' AND `firstname` = '{$check_enrollee["firstname"]}' AND `patronymic` = '{$check_enrollee["patronymic"]}';");
                            $subCounter = 1;
                            while ($enrollee = $query -> fetch_assoc()) {
                                if ($subCounter == 1) {
                                    $pdf -> SetAligns(["C", "C", "C", "C"]);
                                    $pdf -> SetFont("PTSerif", "B", 12);
                                    $pdf -> Row([$pdf -> cyrilic("№ п/п"), $pdf -> cyrilic("Специальность"), $pdf -> cyrilic("Контактные данные"), $pdf -> cyrilic("Дата создания заявления")]);
                                    $pdf -> SetAligns(["L", "L", "L", "C"]);
                                    $pdf -> SetFont("PTSerif", "", 12);
                                    $pdf -> Row([$pdf -> cyrilic("{$subCounter}."), $pdf -> cyrilic("{$database -> query("SELECT `shortname` FROM `enr_specialties` WHERE `id` = {$enrollee["specialty"]};") -> fetch_assoc()["shortname"]}"), $pdf -> cyrilic("{$crypt -> decrypt($enrollee["email"])}, {$crypt -> decrypt($enrollee["telephone"])}"), $pdf -> cyrilic(Date("d.m.Y", $enrollee["timestamp"]))]);
                                } else
                                    $pdf -> Row([$pdf -> cyrilic("{$subCounter}."), $pdf -> cyrilic("{$database -> query("SELECT `shortname` FROM `enr_specialties` WHERE `id` = {$enrollee["specialty"]};") -> fetch_assoc()["shortname"]}"), $pdf -> cyrilic("{$crypt -> decrypt($enrollee["email"])}, {$crypt -> decrypt($enrollee["telephone"])}"), $pdf -> cyrilic(Date("d.m.Y", $enrollee["timestamp"]))]);
                                $subCounter++;
                            }
                            $pdf -> Ln(10);
                            $mainCounter++;
                        }
                    }
                }
                return $pdf -> Output("S");
                $database -> close();
            } else
                return false;
        } else
            return false;
    }
?>
