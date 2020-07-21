<?php
    require __DIR__ . "/../../../../configurations/cipher-keys.php";
    require_once __DIR__ . "/../../../../configurations/main.php";
    $crypt = new CryptService($ciphers["database"]);
?>
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
                    $counter = 10;
                    while ($row = $specialties -> fetch_assoc()) { ?>
                        <div id="v-pills-statements-<?php echo boolval($row["forExtramural"]) ? "extramural" : "fulltime"; ?>-<?php echo $row["id"]; ?>" class="tab-pane fade <?php echo $counter == 10 ? "show active" : ""; ?>" role="tabpanel" aria-labelledby="v-pills-statements-<?php echo boolval($row["forExtramural"]) ? "extramural" : "fulltime"; ?>-<?php echo $row["id"]; ?>-pill">
                            <h3><?php echo explode("@", $row["fullname"])[0] . (!empty(explode("@", $row["fullname"])[1]) ? " <i>" . explode("@", $row["fullname"])[1] . "</i>" : ""); ?></h3>
                            <p>Мест на бюджет: <b><?php echo $row["budget"]; ?></b></p>
                            <p>Мест на договор: <b><?php echo $row["contract"]; ?></b></p>
                            <div role="tablist" id="accordion-<?php echo $counter; ?>" class="accordion">
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="true" aria-controls="accordion-<?php echo $counter; ?> .item-<?php echo $counter; ?>" href="#accordion-<?php echo $counter; ?> .item-1">Бюджетная форма</a>
                                        </h5>
                                    </div>
                                    <div class="collapse show item-1" role="tabpanel" data-parent="#accordion-<?php echo $counter; ?>">
                                        <div class="card-body">
                                            <?php $enrollies = $this -> database -> query("SELECT `id`, `lastname`, `firstname`, `patronymic`, `averageMark`, `isOnline`, `withStatement`, `withOriginalDiploma`, `possibleContract`, `degree`, `compositeKey`, `timestamp` FROM `enr_statements` WHERE `specialty` = {$row["id"]} AND `educationalType` = '" . (boolval($row["forExtramural"]) ? "extramural" : "fulltime") . "' AND `paysType` = 1 AND `isChecked` = 1 ORDER BY `averageMark` DESC;");
                                            if ($enrollies -> num_rows != 0) {
                                                $firstElement = true;
                                                $average = -1;
                                                $sub_counter = 1;
                                                while ($enrollee = $enrollies -> fetch_assoc()) {
                                                    $key = [
                                                        "specialty" => $row["compositeKey"],
                                                        "level" => $this -> database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$enrollee["degree"]}") -> fetch_assoc()["compositeKey"],
                                                        "count" => $enrollee["compositeKey"],
                                                    ];
                                                    if ($firstElement) {
                                                        $firstElement = false; ?>
                                                        <ul class="list-group">
                                                    <?php } ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo $average == $enrollee["averageMark"] ? "bg-warning" : ""; ?>" data-id="<?php echo $enrollee["id"]; ?>">
                                                        <span><?php echo (boolval($enrollee["withOriginalDiploma"]) ? "<i class=\"" . (boolval($enrollee["possibleContract"]) ? "text-info " : "") . "fas fa-bell possible-contract-button\" style=\"width: 23px; text-align: center; cursor: pointer;\" data-id=\"{$enrollee["id"]}\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"С оригиналом документа об образовании!\"></i>" : "<i class=\"" . (boolval($enrollee["possibleContract"]) ? "text-info " : "") . "fas fa-bell-slash possible-contract-button\" style=\"width: 23px; text-align: center; cursor: pointer;\" data-id=\"{$enrollee["id"]}\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"Без оригинала документа об образовании!\"></i>") . "{$sub_counter}. {$crypt -> decrypt($enrollee["lastname"])} {$crypt -> decrypt($enrollee["firstname"])}" . (!empty($enrollee["patronymic"]) ? " " . $crypt -> decrypt($enrollee["patronymic"]) : "") . " ({$enrollee["averageMark"]}) ({$key["count"]}-{$key["level"]}-{$key["specialty"]})" . (boolval($enrollee["isOnline"]) ? "<i class=\"fas fa-cloud\" style=\"margin-left: 10px; cursor: default;\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"Онлайн-заявление\"></i>" : "") . (boolval($enrollee["isOnline"]) && !boolval($enrollee["withStatement"]) ? "<i class=\"fas fa-user-alt-slash\" style=\"margin-left: 10px; cursor: default;\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"Оригинала заявления нет!\"></i>" : (boolval($enrollee["isOnline"]) && boolval($enrollee["withStatement"]) ? "<i class=\"fas fa-user-alt\" style=\"margin-left: 10px; cursor: default;\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"Оригинал заявления присутствует!\"></i>" : "")); ?></span>
                                                            <div class="btn-group btn-group-sm float-right" role="group">
                                                                <div class="dropleft btn-group" role="group">
                                                                    <button class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">
                                                                        <i class="fa fa-archive"></i>
                                                                    </button>
                                                                    <div role="menu" class="dropdown-menu enrollee-dropdown-menu">
                                                                        <a role="presentation" data-id="<?php echo $enrollee["id"]; ?>" class="dropdown-item button-enrollee-archive">Архив документов</a>
                                                                        <a role="presentation" data-id="<?php echo $enrollee["id"]; ?>" class="dropdown-item button-enrollee-receipt">Расписка</a>
                                                                        <a role="presentation" data-id="<?php echo $enrollee["id"]; ?>" class="dropdown-item button-enrollee-statement">Заявление</a>
                                                                    </div>
                                                                </div>
                                                                <button class="btn btn-outline-primary button-enrollee-edit" data-toggle="tooltip" data-bs-tooltip="" type="button" title="Редактировать">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-outline-danger button-enrollee-delete" data-toggle="tooltip" data-bs-tooltip="" type="button" title="Удалить">
                                                                    <i class="fas fa-eraser"></i>
                                                                </button>
                                                            </div>
                                                        </li>
                                                    <?php $average = $enrollee["averageMark"];
                                                    $sub_counter++;
                                                } ?>
                                                </ul>
                                            <?php } else { ?>
                                                <p class="card-text">Абитуриентов, которые подали заявления на эту специальность нет. Для того, чтобы проверить новые заявления, перезагрузите страницу или нажмите <a href="#" onclick="location.reload();">здесь</a>.</p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-<?php echo $counter; ?> .item-2" href="#accordion-<?php echo $counter; ?> .item-2">Договорная</a>
                                        </h5>
                                    </div>
                                    <div class="collapse item-2" role="tabpanel" data-parent="#accordion-<?php echo $counter; ?>">
                                        <div class="card-body">
                                            <?php $enrollies = $this -> database -> query("SELECT `id`, `lastname`, `firstname`, `patronymic`, `averageMark`, `degree`, `compositeKey`, `isOnline`, `withOriginalDiploma`, `withStatement` FROM `enr_statements` WHERE `specialty` = {$row["id"]} AND `educationalType` = '" . (boolval($row["forExtramural"]) ? "extramural" : "fulltime") . "' AND `paysType` = 2 AND `isChecked` = 1 ORDER BY `averageMark` DESC;");
                                            if ($enrollies -> num_rows != 0) {
                                                $firstElement = true;
                                                $sub_counter = 1;
                                                while ($enrollee = $enrollies -> fetch_assoc()) {
                                                    $key = [
                                                        "specialty" => $row["compositeKey"],
                                                        "level" => $this -> database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$enrollee["degree"]}") -> fetch_assoc()["compositeKey"],
                                                        "count" => $enrollee["compositeKey"],
                                                    ];
                                                    if ($firstElement) {
                                                        $firstElement = false; ?>
                                                        <ul class="list-group">
                                                    <?php } ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="<?php echo $enrollee["id"]; ?>">
                                                        <span><?php echo (boolval($enrollee["withOriginalDiploma"]) ? "<i class=\"fas fa-bell\" style=\"width: 23px; text-align: center; cursor: default;\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"С оригиналом документа об образовании!\"></i>" : "<i class=\"fas fa-bell-slash\" style=\"width: 23px; text-align: center; cursor: default;\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"Без оригинала документа об образовании!\"></i>") .  "{$sub_counter}. {$crypt -> decrypt($enrollee["lastname"])} {$crypt -> decrypt($enrollee["firstname"])}" . (!empty($enrollee["patronymic"]) ? " " . $crypt -> decrypt($enrollee["patronymic"]) : "") . " ({$enrollee["averageMark"]}) ({$key["count"]}-{$key["level"]}-{$key["specialty"]})" . (boolval($enrollee["isOnline"]) ? "<i class=\"fas fa-cloud\" style=\"margin-left: 10px; cursor: default;\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"Онлайн-заявление\"></i>" : "") . (boolval($enrollee["isOnline"]) && !boolval($enrollee["withStatement"]) ? "<i class=\"fas fa-user-alt-slash\" style=\"margin-left: 10px; cursor: default;\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"Оригинала заявления нет!\"></i>" : (boolval($enrollee["isOnline"]) && boolval($enrollee["withStatement"]) ? "<i class=\"fas fa-user-alt\" style=\"margin-left: 10px; cursor: default;\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" type=\"button\" title=\"Оригинал заявления присутствует!\"></i>" : "")); ?></span>
                                                            <div class="btn-group btn-group-sm float-right" role="group">
                                                                <div class="dropleft btn-group" role="group">
                                                                    <button class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">
                                                                        <i class="fa fa-archive"></i>
                                                                    </button>
                                                                    <div role="menu" class="dropdown-menu enrollee-dropdown-menu">
                                                                        <a role="presentation" data-id="<?php echo $enrollee["id"]; ?>" class="dropdown-item button-enrollee-archive">Архив документов</a>
                                                                        <a role="presentation" data-id="<?php echo $enrollee["id"]; ?>" class="dropdown-item button-enrollee-receipt">Расписка</a>
                                                                        <a role="presentation" data-id="<?php echo $enrollee["id"]; ?>" class="dropdown-item button-enrollee-statement">Заявление</a>
                                                                    </div>
                                                                </div>
                                                                <!-- <button class="btn btn-outline-primary button-enrollee-archive" data-toggle="tooltip" data-bs-tooltip="" type="button" title="Архив документов">
                                                                    <i class="fas fa-archive"></i>
                                                                </button> -->
                                                                <button class="btn btn-outline-primary button-enrollee-edit" data-toggle="tooltip" data-bs-tooltip="" type="button" title="Редактировать">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-outline-danger button-enrollee-delete" data-toggle="tooltip" data-bs-tooltip="" type="button" title="Удалить">
                                                                    <i class="fas fa-eraser"></i>
                                                                </button>
                                                            </div>
                                                        </li>
                                                    <?php $sub_counter++;
                                                } ?>
                                                </ul>
                                            <?php } else { ?>
                                                <p class="card-text">Абитуриентов, которые подали заявления на эту специальность нет. Для того, чтобы проверить новые заявления, перезагрузите страницу или нажмите <a href="#" onclick="location.reload();">здесь</a>.</p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $counter++;
                    } ?>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/secretary/statements.js?<?php echo time(); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
<script src="/global-assets/js/jquery.mask.js"></script>
<script src="/global-assets/js/dropdown-bootstrap.js"></script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    (function() {
        // hold onto the drop down menu
        var dropdownMenu;
        // and when you show it, move it to the body 
        $(window).on('show.bs.dropdown', function(e) {
            // grab the menu
            dropdownMenu = $(e.target).find('.enrollee-dropdown-menu');
            // detach it and append it to the body
            $('body').append(dropdownMenu.detach());
            // grab the new offset position
            var eOffset = $(e.target).offset();
            // make sure to place it where it would normally go (this could be improved)
            dropdownMenu.css({
                'display': 'block',
                'top': eOffset.top + $(e.target).outerHeight(),
                'left': eOffset.left,
                'cursor': 'pointer'
            });
        });
        // and when you hide it, reattach the drop down, and hide it normally
        $(window).on('hide.bs.dropdown', function(e) {
            $(e.target).append(dropdownMenu.detach());
            dropdownMenu.hide();
        });
    })();
</script>