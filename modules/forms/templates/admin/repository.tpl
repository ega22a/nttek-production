<div class="modal fade" role="dialog" tabindex="-1" id="modal-edit-form" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">${formName}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="exsisting-form-name">Наименование формы<span class="text-danger">*</span>:</label>
                            <input class="form-control" type="text" id="exsisting-form-name" placeholder="Например, &quot;Заказать справку&quot;">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-control-inline custom-switch">
                                <input class="custom-control-input" type="checkbox" id="exsisting-checkbox-collect-email">
                                <label class="custom-control-label" for="exsisting-checkbox-collect-email">Собирать адреса электронной почты</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-control-inline custom-switch">
                                <input class="custom-control-input" type="checkbox" id="exsisting-form-send-to-email" checked="">
                                <label class="custom-control-label" for="exsisting-form-send-to-email">Пересылать форму на адрес электронной почты</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="exsisting-form-email">Адрес электронной почты<span id="exsisting-form-email-danger" class="text-danger">*</span>:</label>
                            <input class="form-control" type="email" id="exsisting-form-email" placeholder="Например, &quot;admin@nttek.ru&quot;">
                        </div>
                    </div>
                    <ul class="list-group" id="exsisting-form-list-of-elements">
                        
                    </ul>
                    <ul class="list-group" style="margin-top: 15px;">
                        <li class="list-group-item">
                            <select class="custom-select custom-select-sm" id="exsisting-form-select-element">
                                <option value="" selected="">Выберите элемент</option>
                                <option value="text">Текстовое поле</option>
                                <option value="radio">Радиокнопки (одно из множества)</option>
                                <option value="checkbox">Чекбокс (поле "галочка")</option>
                                <option value="select">Выпадающий список</option>
                            </select>
                            <button class="btn btn-primary btn-block btn-sm" id="exsisting-form-create-element" type="button" style="margin-top: 15px;">Добавить элемент</button>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<header style="min-height: 100vh;background-size: cover;background-repeat: no-repeat;">
    <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
        <div class="container">
            <div class="row col-md-12" style="margin: 0 auto;">
                <div class="col-md-3">
                    <ul class="nav nav-pills flex-column" role="tablist" area-orientation="vertical">
                        <li class="nav-item">
                            <a class="nav-link active" id="v-pills-new-form-tab" href="#v-pills-new-form" data-toggle="pill" role="tab" aria-controls="v-pills-new-form" aria-selected="true">Создать новую форму</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="v-pills-forms-storage-tab" href="#v-pills-forms-storage" data-toggle="pill" role="tab" aria-controls="v-pills-forms-storage" aria-selected="false">Хранилище форм</a>
                        </li>
                    </ul>
                </div>
                <div class="border rounded col-md-9 tab-content" style="padding: 15px;margin-bottom: 15px;">
                    <div id="v-pills-new-form" class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-pills-new-form-tab">
                        <h3>Создать новую форму</h3>
                        <p>Эта страница предназначена для создания форм. Просто начните создавать форму!</p>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="new-form-name">Наименование формы<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="new-form-name" required="" placeholder="Например, &quot;Заказать справку&quot;">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-control-inline custom-switch">
                                        <input class="custom-control-input" type="checkbox" id="new-checkbox-collect-email">
                                        <label class="custom-control-label" for="new-checkbox-collect-email">Собирать адреса электронной почты</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-control-inline custom-switch">
                                        <input class="custom-control-input" type="checkbox" id="new-form-send-to-email" checked="">
                                        <label class="custom-control-label" for="new-form-send-to-email">Пересылать форму на адрес электронной почты</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="new-form-email">Адрес электронной почты<span id="new-form-email-danger" class="text-danger">*</span>:</label>
                                    <input class="form-control" type="email" id="new-form-email" required="" placeholder="Например, &quot;admin@nttek.ru&quot;">
                                </div>
                            </div>
                            <ul class="list-group" id="new-form-list-of-elements">
                                
                            </ul>
                            <ul class="list-group" style="margin-top: 15px;">
                                <li class="list-group-item">
                                    <select class="custom-select custom-select-sm" id="new-form-select-element">
                                        <option value="" selected="">Выберите элемент</option>
                                        <option value="text">Текстовое поле</option>
                                        <option value="radio">Радиокнопки (одно из множества)</option>
                                        <option value="checkbox">Чекбокс (поле "галочка")</option>
                                        <option value="select">Выпадающий список</option>
                                    </select>
                                    <button class="btn btn-primary btn-block btn-sm" id="new-form-create-element" type="button" style="margin-top: 15px;">Добавить элемент</button>
                                </li>
                            </ul>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <button class="btn btn-primary btn-block" id="new-form-save" type="button" style="margin-top: 15px;">Сохранить форму</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="v-pills-forms-storage" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-forms-storage-tab">
                        <h3>Хранилище форм</h3>
                        <ul class="list-group">
                            <?php $forms = $this -> database -> query("SELECT `id`, `name` FROM `frm_forms`;");
                            if ($forms -> num_rows != 0)
                                while ($form = $forms -> fetch_assoc()) { ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><?php echo $form["name"]; ?></span>
                                        <div class="btn-group btn-group-sm float-right" role="group">
                                            <button class="btn btn-outline-primary" onclick="exsistingButtonEdit(<?php echo $form["id"]; ?>, this);" type="button">Редактировать</button>
                                            <button class="btn btn-outline-danger" onclick="exsistingButtonDelete(<?php echo $form["id"]; ?>, this);" type="button">Удалить</button>
                                        </div>
                                    </li>
                                <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
<script src="/global-assets/js/jquery.mask.js"></script>
<script src="/global-assets/js/dropdown-bootstrap.js"></script>
<script src="../assets/js/admin/repository.js?<?php echo time(); ?>"></script>
</body>
</html>