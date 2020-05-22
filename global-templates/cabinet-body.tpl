<?php
    $about = $this -> user -> getDecrypted();
    $database = $this -> config -> get(__DIR__ . "/../configurations/database/auth.ini");
    $postfix = $this -> config -> get(__DIR__ . "/../configurations/email/auth.ini");
    $users = $this -> user -> get_all_users();
?>
<body>
    <?php if ($this -> user -> check_level(0)) { ?>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal-edit-user" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Изменить данные о пользователе</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modal-admin-user-edit-dismiss"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="form-users-edit-lastname">Фамилия:</label>
                                <input class="form-control" type="text" id="form-users-edit-lastname" placeholder="Фамилия">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="form-users-edit-firstname">Имя:</label>
                                <input class="form-control" type="text" id="form-users-edit-firstname" placeholder="Имя">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="form-users-edit-patronymic">Отчество:</label>
                                <input class="form-control" type="text" id="form-users-edit-patronymic" placeholder="Отчество">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="form-users-edit-birthday">Дата рождения:</label>
                                <input class="form-control" type="date" id="form-users-edit-birthday">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="form-users-edit-email">Электорнная почта:</label>
                                <input class="form-control" type="email" placeholder="user@example.com" id="form-users-edit-email">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="form-users-edit-telephone">Телефон:</label>
                                <input class="form-control" type="tel" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00" id="form-users-edit-telephone">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="form-users-edit-levels">Уровни доступа к системе:</label>
                                <select class="custom-select" multiple size="4" id="form-users-edit-levels">
                                    <?php foreach (json_decode(file_get_contents(__DIR__ . "/../configurations/json/levels.json")) as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>" data-vanilla="<?php echo "{$value -> level}"; ?>"><?php echo "{$value -> description}";?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div>
                        <a class="btn btn-secondary" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-1" href="#collapse-1" role="button">Изменить логин или пароль</a>
                        <div class="collapse" id="collapse-1" style="margin-top: 15px;">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="form-users-edit-login">Новый логин:</label>
                                        <input class="form-control" type="text" id="form-users-edit-login" placeholder="Если не меняется - оставь пустым!">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="form-users-edit-password">Новый пароль:</label>
                                        <input class="form-control" type="text" id="form-users-edit-password" placeholder="Если не меняется - оставь пустым!">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="form-users-edit-save">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal-load-user" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Новые пользователи</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modal-load-user-dismiss"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form>
                        <p>Подготовьте CSV-таблицу (рекомендуется в <a href="https://sheets.google.com" target="_blank">Google Sheets</a>) и загрузите эту таблицу сюда. Таблица должна содержать следующие колонки:</p>
                        <ol>
                            <li>Фамилия;</li>
                            <li>Имя;</li>
                            <li>Отчество (если нет - поставить "пробел");</li>
                            <li>Дата рождения (обязательно в формате ГГГГ-ММ-ДД);</li>
                            <li>Адрес электронной почты;</li>
                            <li>Номер мобильного телефона (обязательно в формате 9000000000);</li>
                            <li>Уровни доступа к системе (разделитель - точка с запятой).</li>
                        </ol>
                        <p>Со списком уровней доступа к системе и их описаниями можно ознакомиться <a href="#" target="_blank">здесь</a>.</p>
                        <p>Система автоматически сгенерирует логин и пароль и отправит данные на указанные адреса электронной почты.</p>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file-load-users" accept="text/csv">
                                    <label class="custom-file-label" for="file-load-users">Загрузить CSV...</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div id="form-file-load-users-errors"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="admin-users-load-new">Зарегестрировать</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal-email-telephone" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Изменить телефон или электронную почту</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <div role="tablist" id="accordion-3" class="accordion">
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-3 .item-1" href="#accordion-3 .item-1">Изменить электронную почту</a></h5>
                            </div>
                            <div class="collapse item-1" role="tabpanel" data-parent="#accordion-3">
                                <div class="card-body">
                                    <form class="validated" novalidate>
                                        <div class="form-row col-md-12">
                                            <div class="form-group col-md-12">
                                                <label for="form-user-edit-email">Новый адрес электронной почты:</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="email" placeholder="user@example.com" id="form-user-edit-email" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary" type="button" id="user-new-email">Сохранить</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab">
                                <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-3 .item-2" href="#accordion-3 .item-2">Изменить номер телефона</a></h5>
                            </div>
                            <div class="collapse item-2" role="tabpanel" data-parent="#accordion-3">
                                <div class="card-body">
                                    <form class="validated" novalidate>
                                        <div class="form-row col-md-12">
                                            <div class="form-group col-md-12">
                                                <label for="form-user-edit-telephone">Новый номер телефона:</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="tel" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00" id="form-user-edit-telephone" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary" type="button" id="user-new-telephone">Сохранить</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header style="min-height: 100vh;">
        <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
            <div class="container">
                <div class="row col-md-12" style="margin: 0 auto;">
                    <div class="col-md-3" style="margin-bottom: 15px;">
                        <ul class="nav nav-pills flex-column" role="tablist" area-orientation="vertical">
                            <li class="nav-item"><a class="nav-link active" id="v-pills-personal-data-tab" href="#v-pills-personal-data" data-toggle="pill" role="tab" aria-controls="v-pills-personal-data" aria-selected="true">Персональные данные</a></li>
                            <li class="nav-item"><a class="nav-link" id="v-pills-auth-data-tab" href="#v-pills-auth-data" data-toggle="pill" role="tab" aria-controls="v-pills-auth-data" aria-selected="false">Аутентификация</a></li>
                            <?php if ($this -> user -> check_level(0)) { ?>
                            <li class="nav-item"><a class="nav-link" id="v-pills-admin-tab" href="#v-pills-admin" data-toggle="pill" role="tab" aria-controls="v-pills-admin-data" aria-selected="false">Администраторская панель</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="border rounded col-md-9 tab-content" style="padding: 15px;margin-bottom: 15px;">
                        <div id="v-pills-personal-data" class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-pills-personal-data-tab">
                            <form>
                                <div class="form-row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="form-user-readonly-lastname">Фамилия:</label>
                                        <input class="form-control" type="text" disabled="" name="lastname" placeholder="Фамилия" id="form-user-readonly-lastname" value="<?php echo $about["lastname"]; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form-user-readonly-firstname">Имя:</label>
                                        <input class="form-control" type="text" disabled="" name="firstname" placeholder="Имя" id="form-user-readonly-firstname" value="<?php echo $about["firstname"]; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form-user-readonly-patronymic">Отчество:</label>
                                        <input class="form-control" type="text" disabled="" name="patronymic" placeholder="Отчество" id="form-user-readonly-patronymic" value="<?php echo $about["patronymic"]; ?>">
                                    </div>
                                </div>
                                <div class="form-row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="form-user-readonly-birthday">Дата рождения:</label>
                                        <input class="form-control" type="date" disabled="" readonly="" name="birthday" id="form-user-readonly-birthday" value="<?php echo $about["birthday"]; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form-user-readonly-email">Электронная почта:</label>
                                        <input class="form-control" type="email" disabled="" readonly="" placeholder="Электронная почта" name="email" id="form-user-readonly-email" value="<?php echo $about["email"]; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form-user-readonly-telephone">Телефон:</label>
                                        <input class="form-control" type="tel" disabled="" readonly="" placeholder="Телефон" name="telephone" id="form-user-readonly-telephone" value="<?php echo $about["telephone"]; ?>">
                                    </div>
                            </div><p style="padding: 0 15px;"><sub><strong>ВНИМАНИЕ!</strong> Изменить свои персональные данные Вы можете только тогда, когда подадите в отдел кадров документы, подтверждающие смену персональных данных. Для изменения номера телефона или адреса электронной почты, воспользуйтесь формой: <a href="#" onclick="$('#modal-email-telephone').modal();">заполнить форму</a>.<?php if ($this -> user -> check_level(0)) { ?> Примечание для администратора: для того, чтобы изменить персональные данные о себе, нужно перейти в раздел "Управление пользователями" <i class="em em-smiley" aria-role="presentation" aria-label="SMILING FACE WITH OPEN MOUTH"></i>. <?php } ?></sub></p></form>
                        </div>
                        <div id="v-pills-auth-data" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-auth-data-tab">
                            <div role="tablist" id="accordion-1" class="accordion">
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-1" href="#accordion-1 .item-1">Изменить логин</a></h5>
                                    </div>
                                    <div class="collapse item-1" role="tabpanel" data-parent="#accordion-1">
                                        <div class="card-body">
                                            <form class="validate" novalidate>
                                                <div class="form-row col-md-12">
                                                    <div class="form-group col-md-6">
                                                        <label for="form-user-edit-login">Введите новый логин:</label>
                                                        <input class="form-control" type="text" name="login" placeholder="Логин" id="form-user-edit-login" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="form-user-edit-login-second">Повторите новый логин:</label>
                                                        <input class="form-control" type="text" name="second-login" placeholder="Логин, но ещё раз" id="form-user-edit-login-second" required>
                                                    </div>
                                                </div><button class="btn btn-primary" type="button" style="margin-left: 15px;" id="user-new-login">Изменить логин</button></form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-2" href="#accordion-1 .item-2">Изменить пароль</a></h5>
                                    </div>
                                    <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                                        <div class="card-body">
                                            <form class="validate" novalidate>
                                                <div class="form-row col-md-12">
                                                    <div class="form-group col-md-6">
                                                        <label for="form-user-edit-password">Введите новый пароль:</label>
                                                        <input class="form-control" type="password" placeholder="Введите новый пароль" id="form-user-edit-password" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="form-user-edit-password-second">Повторите новый пароль:</label>
                                                        <input class="form-control" type="password" placeholder="Новый пароль, но ещё раз" id="form-user-edit-password-second" required>
                                                    </div>
                                                </div><button class="btn btn-primary" type="button" style="margin-left: 15px;" id="user-new-password">Изменить пароль</button></form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($this -> user -> check_level(0)) { ?>
                        <div id="v-pills-admin" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-admin-tab">
                            <div role="tablist" id="accordion-2" class="accordion">
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-2 .item-1" href="#accordion-2 .item-1">Управление пользователями</a></h5>
                                    </div>
                                    <div class="collapse item-1" role="tabpanel" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <form>
                                                <div class="form-row col-md-12">
                                                    <div class="form-group col-md-12">
                                                        <div class="input-group">
                                                            <button class="btn btn-secondary col-md-12" type="button" onclick='$("#modal-load-user").modal();'>Зарегестрировать пользователей</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row col-md-12">
                                                    <div class="form-group col-md-12">
                                                        <label for="form-admin-users-search">Поиск пользователей:</label>
                                                        <div class="input-group">
                                                            <input class="form-control" type="text" id="form-admin-users-search">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="table-responsive" style="padding: 0 15px; max-height: 55vh;">
                                                <table class="table table-striped table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 4vw;">#</th>
                                                            <th style="width: 35vw;">ФИО</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="users-tbody">
                                                        <?php foreach($users as $key => $user) {?>
                                                            <tr id="tr-user-<?php echo $key; ?>" data-json='<?php echo json_encode($user); ?>' data-count="<?php echo $key; ?>" class="admin-user-tr">
                                                                <td><?php echo $user["id"]; ?></td>
                                                                <td>
                                                                    <?php echo "{$user["lastname"]} {$user["firstname"]} {$user["patronymic"]}"; ?>
                                                                    <div class="admin-user-tr-buttons text-primary">
                                                                        <i class="fa fa-edit admin-user-edit" data-id="<?php echo $key; ?>"></i>
                                                                        <?php if ($user["id"] != 1) { ?>
                                                                        <i class="fa fa-ban admin-user-delete" data-id="<?php echo $key; ?>"></i>
                                                                        <?php }; ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-2 .item-3" href="#accordion-2 .item-3">Конфигурация системы</a></h5>
                                    </div>
                                    <div class="collapse item-3" role="tabpanel" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <form class="validate" novalidate>
                                                <h5>SMTP-сервер</h5>
                                                <div class="form-row" style="padding-bottom: 15px;margin: 0;">
                                                    <label for="form-admin-smtp-address">Адрес и порт:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">ssl://</span>
                                                        </div>
                                                        <input required class="form-control" type="text" placeholder="smtp.example.com" value="<?php echo $postfix["host"]; ?>" id="form-admin-smtp-address">
                                                        <div class="input-group-append input-group-prepend">
                                                            <span class="input-group-text">:</span>
                                                        </div>
                                                        <input required class="form-control col-md-2" type="number" placeholder="465" value="<?php echo $postfix["port"]; ?>" id="form-admin-smtp-port">
                                                    </div>
                                                </div>
                                                <div class="form-row row-md-12">
                                                    <div class="col-md-6 form-group">
                                                        <label for="form-admin-smtp-login">Логин:</label>
                                                        <input required class="form-control" type="text" id="form-admin-smtp-login" placeholder="Логин" value="<?php echo $postfix["login"]; ?>">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="form-admin-smtp-password">Пароль:</label>
                                                        <div class="input-group">
                                                            <input required class="form-control" type="password" id="form-admin-smtp-password" placeholder="Пароль" value="<?php echo $postfix["password"]; ?>">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-dark button-hs-pass" type="button" style="width: 50px;"><i class="far fa-eye" id="i-b-password"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="padding: 0;"><button class="btn btn-primary btn-block" type="button" id="admin-smtp-button">Изменить данные</button></div>
                                            </form>
                                            <hr>
                                            <form class="validate" novalidate>
                                                <h5>База данных</h5>
                                                <div class="form-row row-md-12">
                                                    <div class="form-group col-md-12">
                                                        <label for="form-admin-database-address">Адрес подключения к БД:</label>
                                                        <input required class="form-control" type="text" placeholder="localhost" value="<?php echo $database["host"]; ?>" id="form-admin-database-address">
                                                    </div>
                                                </div>
                                                <div class="form-row row-md-12">
                                                    <div class="col-md-6 form-group">
                                                        <label for="form-admin-database-login">Логин:</label>
                                                        <input required class="form-control" type="text" id="form-admin-database-login" placeholder="Логин" value="<?php echo $database["login"]; ?>">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="form-admin-database-password">Пароль:</label>
                                                        <div class="input-group">
                                                            <input required class="form-control" type="password" id="form-admin-database-password" placeholder="Пароль" value="<?php echo $database["password"]; ?>">
                                                            <div class="input-group-append"><button class="btn btn-outline-dark button-hs-pass" type="button" style="width: 50px;"><i class="far fa-eye" id="i-b-password"></i></button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="form-database-name">Имя базы данных:</label>
                                                        <input required class="form-control" type="text" id="form-admin-database-name" placeholder="Например, collegeSystem" value="<?php echo $database["database"]; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="padding: 0;"><button class="btn btn-primary btn-block" type="button" id="admin-database-button">Изменить данные</button></div>
                                            </form>
                                            <p style="margin-top: 15px;"><b>ВНИМАНИЕ!!!</b> Изменение этих данных может привести к полной неработоспособности системы! При именении конфигурационных данных, настоятельно рекомендуется сделать резервную копию исходных конфигурационных файлов. Изменяйте данные на свой страх и риск!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/global-assets/js/jquery.mask.js"></script>
    <script src="/global-assets/js/dropdown-bootstrap.js"></script>
    <?php if ($this -> user -> check_level(0)) { ?>
        <script src="assets/js/admin.js?<?php echo time(); ?>"></script>
    <?php } ?>
    <script src="assets/js/user.js?<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="assets/css/admin.css?<?php echo time(); ?>">
</body>

</html>
