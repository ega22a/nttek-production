<?php
    // echo "<script type=\"text/javascript\">alert(\"Уважаемые абитуриенты! Личный кабинет находится в стадии технического обслуживания. Просим вас подождать окончания технических работ. Приносим извинения за неудобства.\");</script>";
    // heading("Location: https://assistant.nttek.ru");
    // exit;
?>
<?php $statement = $this -> database -> query("SELECT `enr_statements`.* FROM `enr_statements` INNER JOIN `main_users` ON `main_users`.`id` = `enr_statements`.`usersId` INNER JOIN `main_user_auth` ON `main_users`.`id` = `main_user_auth`.`usersId` WHERE `main_user_auth`.`id` = {$this -> user -> _authId};") -> fetch_assoc();
    $specialty = $this -> database -> query("SELECT * FROM `enr_specialties` WHERE `id` = {$statement["specialty"]};") -> fetch_assoc();
    $information = json_decode(file_get_contents(__DIR__ . "/../../../configurations/json/about.json")) -> school -> enrollment;
    $subQuery = $this -> database -> query("SELECT `id`, `averageMark` FROM `enr_statements` WHERE `specialty` = {$statement["specialty"]} AND `averageMark` IS NOT NULL ORDER BY `averageMark` DESC;");
    $originalQuery = $this -> database -> query("SELECT `id`, `averageMark` FROM `enr_statements` WHERE `specialty` = {$statement["specialty"]} AND `averageMark` IS NOT NULL AND `withOriginalDiploma` = 1 ORDER BY `averageMark` DESC;");
    $place = 1;
    $originalPlace = 1;
    while ($row = $subQuery -> fetch_assoc())
        if ($row["id"] == $statement["id"])
            break;
        else
            $place++;
    while ($row = $originalQuery -> fetch_assoc())
        if ($row["id"] == $statement["id"])
            break;
        else
            $originalPlace++;
    ?>
<div role="dialog" tabindex="-1" class="modal fade" id="modal-news-archive" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Архив новостей Приемной комиссии</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <?php $newsArchive = $this -> database -> query("SELECT `id`, `isImportant`, `timestamp`, `heading` FROM `enr_news`;");
                    while ($piece = $newsArchive -> fetch_assoc()) { ?>
                    <a class="list-group-item list-group-item-action" onclick="showNews(<?php echo $piece["id"]; ?>)">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5 class="mb-1"><?php echo stripslashes($piece["heading"]); ?></h5>
                            <?php boolval($piece["isImportant"]) ? "<span class=\"badge badge-pill badge-danger align-self-center\">!</span>" : ""; ?>
                        </div>
                        <small><em><?php echo Date("d.m.Y", $piece["timestamp"]); ?></em></small>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div role="dialog" tabindex="-1" class="modal fade" id="modal-show-news" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="news-heading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="news-body">
                
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-1">
                        <i class="far fa-calendar"></i>
                    </div>
                    <div class="col">
                        <small><em id="news-date"></em></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<header style="min-height: 100vh;">
    <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
        <div class="container">
            <div class="row">
                <?php if (!boolval($statement["withStatement"])) { ?>
                    <div class="col-md-12" style="margin: 15px;" id="col-docs">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Неполная подача документов!</h4>
                                <p class="card-text">Для полного поступления Вы должны приложить скан Заявления на обучение<?php echo boolval($statement["hostel"]) ? ", а также Заявление на проживание в общежитии!" : "!"; ?></p>
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-12"><label>Скан Заявления на обучение<span class="text-danger">*</span>:</label>
                                            <div class="custom-file">
                                                <input type="file" id="form-file-statement" class="custom-file-input documents-input" required="" multiple="">
                                                <label class="custom-file-label" for="form-file-statement">Загрузите документы...</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (boolval($statement["hostel"])) { ?>
                                        <div class="form-row">
                                            <div class="form-group col-md-12"><label>Скан Заявления на проживание в общежитии<span class="text-danger">*</span>:</label>
                                                <div class="custom-file">
                                                    <input type="file" id="form-file-hostel" class="custom-file-input documents-input" required="">
                                                    <label class="custom-file-label" for="form-file-hostel">Загрузите документы...</label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </form>
                                <button class="btn btn-primary btn-block" type="button" id="button-save">Загрузить документы</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-12" style="margin: 15px;">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Новости Приемной комиссии</h4>
                            <div class="card-columns">
                                <?php $cards = $this -> database -> query("SELECT * FROM `enr_news` ORDER BY `timestamp` DESC LIMIT 3;");
                                while($card = $cards -> fetch_assoc()) { ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-content-center">
                                                <h5 class="mb-1"><?php echo stripslashes($card["heading"]); ?></h5>
                                                <?php boolval($card["isImportant"]) ? "<span class=\"badge badge-pill badge-danger align-self-center\">!</span>" : ""; ?>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p><?php echo stripslashes($card["synopsis"]); ?></p>
                                            <button class="btn btn-outline-primary btn-sm" type="button" onclick="showNews(<?php echo $card["id"]; ?>)">Полная новость</button>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-1">
                                                    <i class="far fa-calendar"></i>
                                                </div>
                                                <div class="col">
                                                    <small><em><?php echo Date("d.m.Y", $card["timestamp"]); ?></em></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <a class="btn btn-primary btn-block" role="button" href="#" data-toggle="modal" data-target="#modal-news-archive">Загрузить архив новостей</a></div>
                            <p>В случае, если новость отображается некорректно, позвоните нам или напишите на адрес электронной почты!</p>
                    </div>
                </div>
                <?php if (boolval($statement["isOnline"])) { ?>
                    <div class="col-md-12" style="margin: 15px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Информация для онлайн-заявлений</h4>
                                <p class="card-text">Уважаемые абитуриенты! При подаче документов лично, вам нужно принести все сканы! Сканы, загруженные в форме нужны только для того, чтобы сверить данные. В нашей Приемной комиссии распечатываются только:</p>
                                <ol>
                                    <li>Скан паспорта;</li>
                                    <li>Скан документа об образовании.</li>
                                </ol>
                                <p class="card-text">Когда будете доносить документы, обязательно возьмите с собой Заявление и Согласие на хранение и обработку персональных данных!</p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-12" style="margin: 15px;">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Общая информация</h4>
                            <?php $key = [
                                "specialty" => $this -> database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$statement["specialty"]}") -> fetch_assoc()["compositeKey"],
                                "level" => $this -> database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$statement["degree"]}") -> fetch_assoc()["compositeKey"],
                                "count" => $this -> database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$statement["id"]}") -> fetch_assoc()["compositeKey"],
                                "year" => Date("Y", $statement["timestamp"]),
                            ]; ?>
                            <p class="card-text"><?php echo ($statement["sex"] == 1 ? "Уважаемый, " : "Уважаемая, ") . "{$this -> crypt -> decrypt($statement["firstname"])} {$this -> crypt -> decrypt($statement["lastname"])}. Вы подали документы <strong>" . (boolval($statement["isOnline"]) ? "дистанционной" : "очной") . "</strong> формой. Вы выбрали метод оплаты за обучение <strong>" . ($statement["paysType"] == "1" ? "за счёт бюджета Свердловской области (бюджетная форма обучения)" : "с полным возмещением затрат на обучение (договорная форма обучения)") . "</strong>. Выбранная вами специальность: <strong>" . explode("@", $specialty["fullname"])[0] . "</strong>." . (boolval($statement["isExtramural"]) ? " Вы подали документы на заочную форму обучения." : " "); echo " Номер личного дела: <strong>{$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$statement["id"]})</strong>."; echo " Данные актуальны на <strong>" . Date("d.m.Y H:m:s") . " UTC+5</strong>"; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin: 15px;">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Список документов, приложеных Вами:</h4>
                            <ol>
                                <?php $attachedDocs = json_decode($this -> crypt -> decrypt($statement["attachedDocs"]));
                                if (boolval($statement["withOriginalDiploma"]))
                                    echo "<li>Оригинал документа об образовании</li>";
                                foreach ($attachedDocs as $key => $value) { ?>
                                    <li><?php echo $this -> database -> query("SELECT `name` FROM `enr_attached_docs` WHERE `id` = {$value}; ") -> fetch_assoc()["name"]; ?></li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin: 15px;">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Информация о ходе приемной кампании</h4>
                            <?php if ($statement["paysType"] == "1") { ?>
                                <p class="card-text">На данный момент вы выбрали бюджетную форму обучения. Метод зачисления в образовательное учреждение — <strong><em>конкурс среднего балла документа об образовании</em></strong>. Ваш средний балл составляет: <strong><?php echo "{$statement["averageMark"]}"; ?></strong>. Бюджетных мест: <strong><?php echo "{$specialty["budget"]}"; ?></strong>.</p>
                                <ul>
                                    <li>Ваше место в общем рейтинге: <strong><?php echo "{$place}"; ?></strong> из <strong><?php echo "{$this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `averageMark` IS NOT NULL;") -> fetch_assoc()["cnt"]}";?></strong>.</li>
                                    <?php if (boolval($statement["withOriginalDiploma"])) { ?>
                                        <li>Ваше место в рейтинге с оригиналами документов об образовании: <strong><?php echo "{$originalPlace}"; ?></strong> из <strong><?php echo "{$this -> database -> query("SELECT COUNT(`id`) AS `cnt` FROM `enr_statements` WHERE `specialty` = {$specialty["id"]} AND `averageMark` IS NOT NULL AND `withOriginalDiploma` = 1;") -> fetch_assoc()["cnt"]}";?></strong>.</li>
                                    <?php } ?>
                                </ul>
                            <?php } elseif ($statement["paysType"] == "2") { ?>
                                <p class="card-text">На данный момент вы выбрали договорную форму обучения. Вам нужно оплатить сумму, указанную в договоре на оказание платных образовательных услуг.</p>
                            <?php } ?>
                            <?php if (!boolval($statement["withOriginalDiploma"])) { ?>
                                <p class="card-text">Обращаем ваше внимание на то, что <strong>Вы не предоставили оригинал документа об образовании</strong>! Без оригинала документа об образовании Вы не сможете поступить в образовательное учреждение. Оригинал документа об образовании нужно предоставить до <strong><?php echo $information -> date; ?></strong>!</p>
                            <?php } ?>
                            <p class="card-text">Номер телефона Приемной комиссии: <a href="tel:<?php echo "{$information -> telephone}"; ?>"><?php echo "{$information -> telephone}"; ?></a>.</p>
                            <p class="card-text">Адрес электронной почты Приемной комиссии: <a href="mailto:<?php echo "{$information -> email}"; ?>"><?php echo "{$information -> email}"; ?></a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/addmission.js?<?php echo time(); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
<script src="/global-assets/js/jquery.mask.js"></script>
<script src="/global-assets/js/dropdown-bootstrap.js"></script>
</body>

</html>
