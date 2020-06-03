<div class="modal fade" role="dialog" tabindex="-1" id="modal-edit-new" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Конфигурация данных в базе данных</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form id="modal-form-specialty" style="display: none;" class="validate">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="specialty-input-fullname">Полное наименование специальности:</label>
                                <input class="form-control" type="text" id="specialty-input-fullname" required="" placeholder="Полное наимнование специальности">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="specialty-input-shortname">Краткое наименование специальности:</label>
                                <input class="form-control" type="text" id="specialty-input-shortname" required="" placeholder="Краткое наимнование специальности">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="specialty-input-composite-key">Наименование для составного ключа:</label>
                                <input class="form-control" type="text" id="specialty-input-composite-key" required="" placeholder="Наименование для составного ключа">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="specialty-input-budget">Количество бюджетных мест:</label>
                                <input class="form-control" type="number" id="specialty-input-budget" placeholder="Количество бюджетных мест" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="specialty-input-contract">Количество мест на договор:</label>
                                <input class="form-control" type="number" id="specialty-input-contract" placeholder="Количество мест на договор" required="">
                            </div>
                            <input style="display: none;" type="checkbox" id="specialty-input-for-extramural">
                        </div>
                    </form>
                    <form id="modal-form-educational-levels" style="display: none;" class="validate">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="educational-levels-input-name">Наименование уровня образования:</label>
                                <input class="form-control" type="text" id="educational-levels-input-name" required="" placeholder="Наименование уровня образования">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="educational-levels-input-composite-key">Составной ключ:</label>
                                <input class="form-control" type="text" id="educational-levels-input-composite-key" required="" placeholder="Составной ключ">
                            </div>
                        </div>
                    </form>
                    <form id="modal-form-educational-docs" style="display: none;" class="validate">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="educational-docs-name">Наимнование документа об образовании:</label>
                                <input class="form-control" type="text" id="educational-docs-input-name" required="" placeholder="Наименование документа об образовании">
                            </div>
                        </div>
                    </form>
                    <form id="modal-form-languages" style="display: none;" class="validate">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="educational-docs-name">Наименование иностранного языка:</label>
                                <input class="form-control" type="text" id="languages-input-name" required="" placeholder="Наименование иностранного языка">
                            </div>
                        </div>
                    </form>
                    <form id="modal-form-hostel-rooms" style="display: none;" class="validate">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="hostel-rooms-name">Наимнование типа комнаты:</label>
                                <input class="form-control" type="text" id="hostel-rooms-input-name" placeholder="Наимнование типа комнаты" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="hostel-rooms-price">Цена за месяц:</label>
                                <input class="form-control" type="number" id="hostel-rooms-input-price" placeholder="Цена за месяц" required="">
                            </div>
                        </div>
                    </form>
                    <form id="modal-form-category-of-citizen" style="display: none;" class="validate">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="category-of-citizen-name">Наимнование статуса категории гражданина:</label>
                                <input class="form-control" type="text" id="category-of-citizen-input-name" placeholder="Наимнование статуса категории гражданина" required="">
                            </div>
                        </div>
                    </form>
                    <form id="modal-form-attached-docs" style="display: none;" class="validate">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="attached-docs-name">Наимнование прилагаемого документа:</label>
                                <input class="form-control" type="text" id="attached-docs-input-name" required="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="attached-docs-latin-name">Наименование прилагаемого документа на латинице:</label>
                                <input class="form-control" type="text" id="attached-docs-input-latin-name" required="">
                            </div>
                            <div class="form-group col-md-12">
                                <sub><strong>Примечание:</strong> пожалуйста, меняйте наименование прилагаемого документа на латинице только в случае крайней необходимости.</sub>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="custom-control custom-switch">
                                    <input class="custom-control-input" type="checkbox" id="attached-docs-input-is-nessesary">
                                    <label class="custom-control-label" for="attached-docs-input-is-nessesary">Обязательный документ</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form id="modal-form-docs-for-review" style="display: none;" class="validate">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="docs-for-review-name">Наименование документа для ознакомления:</label>
                                <input class="form-control" type="text" id="docs-for-review-input-name" required="" placeholder="Наименование документа для ознакомления">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="docs-for-review-file">Загрузите PDF документ для ознакомления:</label>
                                <div class="custom-file">
                                    <input type="file" id="docs-for-review-input-pdf-file" class="custom-file-input" required="">
                                    <label class="custom-file-label" for="docs-for-review-input-pdf-file">Загрузите PDF...</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" id="modal-delete-button">Удалить запись</button>
                    <button class="btn btn-primary" type="button" id="modal-save-button">Сохранить</button>
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
                                        <a data-toggle="collapse" aria-expanded="true" aria-controls="accordion-1 .item-1" href="#accordion-1 .item-1">Записи в базе данных</a>
                                    </h5>
                                </div>
                                <div class="collapse show item-1" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <ul class="nav nav-pills flex-column" role="tablist" area-orientation="vertical" data-count="1">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="v-pills-configurations-specialty-pill" href="#v-pills-configurations-specialty" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-specialty" aria-selected="true">Специальности</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-configurations-educational-levels-pill" href="#v-pills-configurations-educational-levels" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-educational-levels" aria-selected="true">Уровни образования</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-configurations-educational-docs-pill" href="#v-pills-configurations-educational-docs" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-educational-docs" aria-selected="true">Список документов об образовании</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-configurations-languages-pill" href="#v-pills-configurations-languages" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-languages" aria-selected="true">Иностранные языки</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-configurations-hostel-rooms-pill" href="#v-pills-configurations-hostel-rooms" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-hostel-rooms" aria-selected="true">Типы комнат общежития</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-configurations-category-of-citizen-pills" href="#v-pills-configurations-category-of-citizen" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-category-of-citizen" aria-selected="true">Категории граждан</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-configurations-attached-docs-pills" href="#v-pills-configurations-attached-docs" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-attached-docs" aria-selected="true">Список документов, прилагаемых абитуриентами</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-configurations-docs-for-review-pills" href="#v-pills-configurations-docs-for-review" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-docs-for-review" aria-selected="true">Документы для ознакомления</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-2" href="#accordion-1 .item-2">Действия над модулем</a>
                                    </h5>
                                </div>
                                <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <ul class="nav nav-pills flex-column" data-count="2" role="tablist" area-orientation="vertical">
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-configurations-docs-pill" href="#v-pills-configurations-docs" data-toggle="pill" role="tab" aria-controls="v-pills-configurations-docs" aria-selected="true">Работа с автоматическими документами</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded col-md-9 tab-content" style="padding: 15px;margin-bottom: 15px;">
                        <div id="v-pills-configurations-specialty" class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-pills-configurations-specialty-pill">
                            <div role="tablist" id="accordion-6" class="accordion">
                                <div class="card">
                                    <div role="tab" class="card-header">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-6 .item-1" href="#accordion-6 .item-1">Очная форма</a>
                                        </h5>
                                    </div>
                                    <div role="tabpanel" data-parent="#accordion-6" class="collapse item-1">
                                        <div class="card-body">
                                            <div class="list-group" id="specialty-list-group-0">
                                                <?php
                                                    $thumb = $this -> database -> query("SELECT * FROM `enr_specialties` WHERE `forExtramural` = 0;");
                                                    while ($row = $thumb -> fetch_assoc()) {
                                                ?>
                                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "specialty", "data" => $row]); ?>'><span><?php echo $row["fullname"]; ?></span></a>
                                                <?php } ?>
                                            </div>
                                            <button class="btn btn-primary btn-block button-push-line" data-type="specialty" data-number="0" type="button" style="margin-top: 15px;">Добавить запись</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div role="tab" class="card-header">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-6 .item-2" href="#accordion-6 .item-2">Заочная форма</a>
                                        </h5>
                                    </div>
                                    <div role="tabpanel" data-parent="#accordion-6" class="collapse item-2">
                                        <div class="card-body">
                                            <div class="list-group" id="specialty-list-group-1">
                                                <?php
                                                    $thumb = $this -> database -> query("SELECT * FROM `enr_specialties` WHERE `forExtramural` = 1;");
                                                    while ($row = $thumb -> fetch_assoc()) {
                                                ?>
                                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "specialty", "data" => $row]); ?>'><span><?php echo $row["fullname"]; ?></span></a>
                                                <?php } ?>
                                            </div>
                                            <button class="btn btn-primary btn-block button-push-line" data-type="specialty" data-number="1" type="button" style="margin-top: 15px;">Добавить запись</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="v-pills-configurations-educational-levels" class="tab-pane fade show" role="tabpanel" aria-labelledby="v-pills-configurations-educational-levels-pill">
                            <div class="list-group">
                                <?php
                                    $thumb = $this -> database -> query("SELECT * FROM `enr_education_levels`;");
                                    while ($row = $thumb -> fetch_assoc()) {
                                ?>
                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "educational-levels", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span></a>
                                <?php } ?>
                            </div>
                            <button class="btn btn-primary btn-block button-push-line" data-type="educational-levels" type="button" style="margin-top: 15px;">Добавить запись</button>
                        </div>
                        <div id="v-pills-configurations-educational-docs" class="tab-pane fade show" role="tabpanel" aria-labelledby="v-pills-configurations-educational-docs-pill">
                            <div class="list-group">
                                <?php
                                    $thumb = $this -> database -> query("SELECT * FROM `enr_educational_docs`;");
                                    while ($row = $thumb -> fetch_assoc()) {
                                ?>
                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "educational-docs", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span></a>
                                <?php } ?>
                            </div>
                            <button class="btn btn-primary btn-block button-push-line" data-type="educational-docs" type="button" style="margin-top: 15px;">Добавить запись</button>
                        </div>
                        <div id="v-pills-configurations-languages" class="tab-pane fade show" role="tabpanel" aria-labelledby="v-pills-configurations-languages-pill">
                            <div class="list-group">
                                <?php
                                    $thumb = $this -> database -> query("SELECT * FROM `enr_languages`;");
                                    while ($row = $thumb -> fetch_assoc()) {
                                ?>
                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "languages", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span></a>
                                <?php } ?>
                            </div>
                            <button class="btn btn-primary btn-block button-push-line" data-type="languages" type="button" style="margin-top: 15px;">Добавить запись</button>
                        </div>
                        <div id="v-pills-configurations-hostel-rooms" class="tab-pane fade show" role="tabpanel" aria-labelledby="v-pills-configurations-hostel-rooms-pill">
                            <div class="list-group">
                                <?php
                                    $thumb = $this -> database -> query("SELECT * FROM `enr_hostel_rooms`;");
                                    while ($row = $thumb -> fetch_assoc()) {
                                ?>
                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "hostel-rooms", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span></a>
                                <?php } ?>
                            </div>
                            <button class="btn btn-primary btn-block button-push-line" data-type="hostel-rooms" type="button" style="margin-top: 15px;">Добавить запись</button>
                        </div>
                        <div id="v-pills-configurations-category-of-citizen" class="tab-pane fade show" role="tabpanel" aria-labelledby="v-pills-configurations-category-of-citizen-pill">
                            <div class="list-group">
                                <?php
                                    $thumb = $this -> database -> query("SELECT * FROM `enr_category_of_citizen`;");
                                    while ($row = $thumb -> fetch_assoc()) {
                                ?>
                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "category-of-citizen", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span></a>
                                <?php } ?>
                            </div>
                            <button class="btn btn-primary btn-block button-push-line" data-type="category-of-citizen" type="button" style="margin-top: 15px;">Добавить запись</button>
                        </div>
                        <div id="v-pills-configurations-attached-docs" class="tab-pane fade show" role="tabpanel" aria-labelledby="v-pills-configurations-attached-docs-pill">
                            <div role="tablist" id="accordion-3" class="accordion">
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="true" aria-controls="accordion-3 .item-1" href="#accordion-3 .item-1">Очная форма</a>
                                        </h5>
                                    </div>
                                    <div class="collapse item-1" role="tabpanel" data-parent="#accordion-3">
                                        <div class="card-body">
                                            <div role="tablist" id="accordion-4" class="accordion">
                                                <div class="card">
                                                    <div class="card-header" role="tab">
                                                        <h5 class="mb-0">
                                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-4 .item-1-1" href="#accordion-4 .item-1-1">Личный прием</a>
                                                        </h5>
                                                    </div>
                                                    <div class="collapse item-1-1" role="tabpanel" data-parent="#accordion-4">
                                                        <div class="card-body">
                                                            <ul class="list-group" id="attached-docs-list-group-1">
                                                                <?php
                                                                    $thumb = $this -> database -> query("SELECT * FROM `enr_attached_docs` WHERE `forOnline` = 0 AND `forExtramural` = 0;");
                                                                    while ($row = $thumb -> fetch_assoc()) {
                                                                ?>
                                                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "attached-docs", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span><?php echo $row["isNessesary"] ? "<i class=\"fas fa-exclamation-triangle\" style=\"float: right;margin-top:3px;\"></i>" : ""; ?></a>
                                                                <?php } ?>
                                                            </ul>
                                                            <button class="btn btn-primary btn-block button-push-line" data-type="attached-docs" data-number="1" type="button" style="margin-top: 15px;">Добавить запись</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" role="tab">
                                                        <h5 class="mb-0">
                                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-4 .item-2-1" href="#accordion-4 .item-2-1">Онлайн прием</a>
                                                        </h5>
                                                    </div>
                                                    <div class="collapse item-2-1" role="tabpanel" data-parent="#accordion-4">
                                                        <div class="card-body">
                                                            <ul class="list-group" id="attached-docs-list-group-2">
                                                                <?php
                                                                    $thumb = $this -> database -> query("SELECT * FROM `enr_attached_docs` WHERE `forOnline` = 1 AND `forExtramural` = 0;");
                                                                    while ($row = $thumb -> fetch_assoc()) {
                                                                ?>
                                                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "attached-docs", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span><?php echo $row["isNessesary"] ? "<i class=\"fas fa-exclamation-triangle\" style=\"float: right;margin-top:3px;\"></i>" : ""; ?></a>
                                                                <?php } ?>
                                                            </ul>
                                                            <button class="btn btn-primary btn-block button-push-line" data-type="attached-docs" data-number="2" type="button" style="margin-top: 15px;">Добавить запись</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-3 .item-2" href="#accordion-3 .item-2">Заочная форма</a>
                                        </h5>
                                    </div>
                                    <div class="collapse item-2" role="tabpanel" data-parent="#accordion-3">
                                        <div class="card-body">
                                            <div role="tablist" id="accordion-5" class="accordion">
                                                <div class="card">
                                                    <div class="card-header" role="tab">
                                                        <h5 class="mb-0">
                                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-5 .item-1-1" href="#accordion-5 .item-1-1">Личный прием</a>
                                                        </h5>
                                                    </div>
                                                    <div class="collapse item-1-1" role="tabpanel" data-parent="#accordion-5">
                                                        <div class="card-body">
                                                            <ul class="list-group" id="attached-docs-list-group-3">
                                                                <?php
                                                                    $thumb = $this -> database -> query("SELECT * FROM `enr_attached_docs` WHERE `forOnline` = 0 AND `forExtramural` = 1;");
                                                                    while ($row = $thumb -> fetch_assoc()) {
                                                                ?>
                                                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "attached-docs", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span><?php echo $row["isNessesary"] ? "<i class=\"fas fa-exclamation-triangle\" style=\"float: right;margin-top:3px;\"></i>" : ""; ?></a>
                                                                <?php } ?>
                                                            </ul>
                                                            <button class="btn btn-primary btn-block button-push-line" data-type="attached-docs" data-number="3" type="button" style="margin-top: 15px;">Добавить запись</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" role="tab">
                                                        <h5 class="mb-0">
                                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-5 .item-2-1" href="#accordion-5 .item-2-1">Онлайн прием</a>
                                                        </h5>
                                                    </div>
                                                    <div class="collapse item-2-1" role="tabpanel" data-parent="#accordion-5">
                                                        <div class="card-body">
                                                            <ul class="list-group" id="attached-docs-list-group-4">
                                                                <?php
                                                                    $thumb = $this -> database -> query("SELECT * FROM `enr_attached_docs` WHERE `forOnline` = 1 AND `forExtramural` = 1;");
                                                                    while ($row = $thumb -> fetch_assoc()) {
                                                                ?>
                                                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "attached-docs", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span><?php echo $row["isNessesary"] ? "<i class=\"fas fa-exclamation-triangle\" style=\"float: right;margin-top:3px;\"></i>" : ""; ?></a>
                                                                <?php } ?>
                                                            </ul>
                                                            <button class="btn btn-primary btn-block button-push-line" data-type="attached-docs" data-number="4" type="button" style="margin-top: 15px;">Добавить запись</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="v-pills-configurations-docs-for-review" class="tab-pane fade show" role="tabpanel" aria-labelledby="v-pills-configurations-docs-for-review-pill">
                            <div class="list-group">
                                <?php
                                    $thumb = $this -> database -> query("SELECT * FROM `enr_docs_for_review`;");
                                    while ($row = $thumb -> fetch_assoc()) {
                                ?>
                                    <a class="list-group-item list-group-item-action" onclick="listClick(this);" data-json='<?php echo json_encode(["action" => "docs-for-review", "data" => $row]); ?>'><span><?php echo $row["name"]; ?></span></a>
                                <?php } ?>
                            </div>
                            <button class="btn btn-primary btn-block button-push-line" data-type="docs-for-review" type="button" style="margin-top: 15px;">Добавить запись</button>
                        </div>
                        <div id="v-pills-configurations-docs" class="tab-pane fade show" role="tabpanel" aria-labelledby="v-pills-configurations-docs-pill">
                            <div role="tablist" id="accordion-2" class="accordion">
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-2 .item-1" href="#accordion-2 .item-1">Оперативные сводки</a>
                                        </h5>
                                    </div>
                                    <div class="collapse item-1" role="tabpanel" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <ul>
                                                <li><a href="#" onclick="getOperationalSummary('all');">Общая оперативная сводка (PDF)</a></li>
                                                <li><a href="#" onclick="getOperationalSummary('fulltime');">Оперативная сводка очной формы обучения (PDF)</a></li>
                                                <li><a href="#" onclick="getOperationalSummary('extramural');">Оперативная сводка заочной формы обучения (PDF)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-2 .item-3" href="#accordion-2 .item-3">Списки абитуриентов</a>
                                        </h5>
                                    </div>
                                    <div class="collapse item-3" role="tabpanel" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <ul>
                                                <li><a href="#" onclick="getListOfEnrollees('fulltime');">Список абитуриентов по специальностям очной формы (PDF)</a></li>
                                                <li><a href="#" onclick="getListOfEnrollees('extramural');">Список абитуриентов по специальностям заочной формы (PDF)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-2 .item-2" href="#accordion-2 .item-2">Дополнительные документы</a>
                                        </h5>
                                    </div>
                                    <div class="collapse item-2" role="tabpanel" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <ul>
                                                <li><a href="#" onclick="getHostelList('enrollees');">Список абитуриентов с Заявлениями на общежитие (PDF)</a></li>
                                                <li><a href="#" onclick="getHostelList('analysis');">Анализ общего списка абитуриентов на совпадения ФИО (PDF)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <style type="text/css">
        .list-group-item {
            cursor: pointer;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/configuration.js?<?php echo time(); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="/global-assets/js/jquery.mask.js"></script>
    <script src="/global-assets/js/dropdown-bootstrap.js"></script>
    <script src="/global-assets/js/global.js"></script>
</body>

</html>
