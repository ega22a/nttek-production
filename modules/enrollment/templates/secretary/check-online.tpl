<?php
    require __DIR__ . "/../../../../configurations/cipher-keys.php";
    require_once __DIR__ . "/../../../../configurations/main.php";
    $crypt = new CryptService($ciphers["database"]);
?>
<div class="modal fade" role="dialog" tabindex="-1" id="modal-dismiss-enrollee" data-backdrop="static" style="z-index: 1000000;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Составить сообщение</h4>
                </div>
                <div class="modal-body">
                    <p>Пожалуйста, опишите причину удаления необработанного личного дела.</p>
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <textarea class="form-control" id="modal-dismiss-enrollee-text" rows="5" maxlength="350" required=""></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="modal-dismiss-enrollee-button">Отправить письмо</button>
                </div>
            </div>
        </div>
    </div>
<div role="dialog" tabindex="-1" class="modal fade" data-backdrop="static" id="modal-check-enrollee">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Проверка документов</h4>
            </div>
            <div class="modal-body">
                <p>В скором времени начнется скачивание документов абитуриента. Вам нужно проверить Заявление, а также сканы документов. Если данные корректны, то нажмите на соответвующую кнопку. Если же данные некорректны, то нажмите на соответствующую кнопку. В случае некорректных данных, вам нужно будет написать сообщение с объяснением в отказе.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" id="modal-check-enrollee-incorrect">Данные некорректны</button>
                <button class="btn btn-primary" type="button" id="modal-check-enrollee-correct">Данные корректны</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" id="modal-avarage-grade">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h4 class="modal-title">Подсчет среднего балла</h4>
            </div>
            <div class="modal-body">
                <p>Введите оценки из документа об образовании без разделителей, пробелов, знаков препинания. Допускаются оценки: 3, 4 и 5.</p>
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input class="form-control" type="text" required placeholde="12345" id="modal-text-input-average-grade">
                        </div>
                    </div>
                </form>
                <p>Нынешняя средняя оценка: <strong><span id="span-average-grade"></span></strong></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id="modal-avarage-grade-button">Подсчитать и сохранить</button>
            </div>
        </div>
    </div>
</div>
<header style="min-height: 100vh;">
    <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
        <div class="container">
            <div class="row col-md-12" style="margin: 0 auto; align-items: flex-start;">
            <div class="col-md-3">
                    <div role="tablist" id="accordion-1" class="accordion" style="margin-bottom: 15px;">
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" aria-expanded="true" aria-controls="accordion-1 .item-1" href="#accordion-1 .item-1">Очные заявления</a>
                                </h5>
                            </div>
                            <div class="collapse show item-1" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <ul class="nav nav-pills flex-column" role="tablist" area-orientation="vertical" data-count="1">
                                        <?php $specialties = $this -> database -> query("SELECT `id`, `shortname` FROM `enr_specialties` WHERE `forExtramural` = 0;");
                                        $first = true;
                                        while ($row = $specialties -> fetch_assoc()) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if ($first) { echo "active"; $first = false; } ?>" id="v-pills-statements-fulltime-<?php echo $row["id"]; ?>-pill" href="#v-pills-statements-fulltime-<?php echo $row["id"]; ?>" data-toggle="pill" role="tab" aria-controls="v-pills-statements-fulltime-<?php echo $row["id"]; ?>" aria-selected="true"><?php echo $row["shortname"]; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-2" href="#accordion-1 .item-2">Заочные заявления</a>
                                </h5>
                            </div>
                            <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                                <div class="card-body">
                                    <ul class="nav nav-pills flex-column" data-count="2" role="tablist" area-orientation="vertical">
                                        <?php $specialties = $this -> database -> query("SELECT `id`, `shortname` FROM `enr_specialties` WHERE `forExtramural` = 1;");
                                        while ($row = $specialties -> fetch_assoc()) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-statements-extramural-<?php echo $row["id"]; ?>-pill" href="#v-pills-statements-extramural-<?php echo $row["id"]; ?>" data-toggle="pill" role="tab" aria-controls="v-pills-statements-extramural-<?php echo $row["id"]; ?>" aria-selected="true"><?php echo $row["shortname"]; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded col-md-9 tab-content bg-white" style="padding: 15px;margin-bottom: 15px;">
                    <?php $specialties = $this -> database -> query("SELECT * FROM `enr_specialties`");
                    $firstTab = true;
                    while ($row = $specialties -> fetch_assoc()) { ?>
                        <div id="v-pills-statements-<?php echo boolval($row["forExtramural"]) ? "extramural" : "fulltime"; ?>-<?php echo $row["id"]; ?>" class="tab-pane fade <?php echo $firstTab ? "show active" : ""; $firstTab = false; ?>" role="tabpanel" aria-labelledby="v-pills-statements-<?php echo boolval($row["forExtramural"]) ? "extramural" : "fulltime"; ?>-<?php echo $row["id"]; ?>-pill">
                            <h3><?php echo $row["fullname"]; ?></h3>
                            <?php $enrollies = $this -> database -> query("SELECT `id`, `lastname`, `firstname`, `patronymic`, `paysType` FROM `enr_statements` WHERE `specialty` = {$row["id"]} AND `educationalType` = '" . (boolval($row["forExtramural"]) ? "extramural" : "fulltime") . "' AND `isChecked` = 0;");
                            if ($enrollies -> num_rows != 0) {
                                $firstElement = true;
                                while ($enrollee = $enrollies -> fetch_assoc()) {
                                    if ($firstElement) {
                                        $firstElement = false; ?>
                                        <div class="list-group" style="margin-top: 20px;">
                                    <?php } ?>
                                        <a href="#" class="list-group-item list-group-item-action item-enrollee-action" data-json='<?php echo json_encode(["id" => intval($enrollee["id"]), "type" => $enrollee["paysType"] == 1 ? "budget" : "contract",]); ?>'>
                                            <span><?php echo "{$crypt -> decrypt($enrollee["lastname"])} {$crypt -> decrypt($enrollee["firstname"])}" . (!empty($enrollee["patronymic"]) ? " " . $crypt -> decrypt($enrollee["patronymic"]) : ""); ?></span>
                                        </a>
                                <?php } ?>
                                </div>
                            <?php } else { ?>
                                <p class="card-text" style="marign-top: 20px;">Абитуриентов, которые подали заявления на эту специальность нет. Для того, чтобы проверить новые заявления, перезагрузите страницу или нажмите <a href="#" onclick="location.reload();">здесь</a>.</p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/secretary/check-online.js?<?php echo time(); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
<script src="/global-assets/js/jquery.mask.js"></script>
<script src="/global-assets/js/dropdown-bootstrap.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
