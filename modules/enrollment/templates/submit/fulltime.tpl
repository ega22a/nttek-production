    <div class="modal fade" role="dialog" tabindex="-1" id="modal-representative" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Данные о законном представителе</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form id="representative-form">
                        <div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Фамилия<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-representative-lastname" required="" placeholder="Фамилия">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Имя<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-representative-firstname" required="" placeholder="Имя">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Отчество (при наличии):</label>
                                    <input class="form-control" type="text" id="form-representative-patronymic" placeholder="Отчество">
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Место работы<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-representative-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Должность<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-representative-job-position" placeholder="Например, преподаватель" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Контактный мобильный телефон<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="tel" id="form-representative-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Рабочий телефон:</label>
                                    <input class="form-control" type="tel" id="form-representative-job-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Кем приходится<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-representative-who" required="" placeholder="Например, бабушка">
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="custom-control custom-control-inline custom-switch">
                                        <input class="custom-control-input" type="checkbox" id="form-representative-checkbox-not-working">
                                        <label class="custom-control-label" for="form-representative-checkbox-not-working">Не работает</label>
                                    </div>
                                </div>
                            </div>      
                        </div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-primary" id="representative-button" type="button">Продолжить</button></div>
            </div>
        </div>
    </div>
    <header style="/*min-height: 100vh;padding-bottom: 25px;*/">
        <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
            <div class="container">
                <h1>Подать заявление на очную форму обучения</h1>
                <div id="div-first-step">
                    <p>Мы рады, что Вы решили подать заявление на очную форму обучения в онлайн форме. Для того, чтобы продолжить, ознакомьтесь с нижеприведенными документами.</p>
                    <div class="list-group">
                        <?php $list = $this -> database -> query("SELECT * FROM `enr_docs_for_review`;");
                        if ($list -> num_rows != 0) {
                            while ($field = $list -> fetch_assoc()) { ?>
                                <a class="list-group-item list-group-item-action" href="/download?id=<?php echo $field["fileId"]; ?>" target="_blank">
                                    <i class="far fa-file-pdf" style="margin-right: 10px;color: #d90c0b;"></i>
                                    <span><?php echo $field["name"]; ?></span>
                                </a>
                            <?php }
                        } ?>
                    </div>
                    <button class="btn btn-primary btn-block" type="button" style="margin-top: 10px;" id="submit-docs">Принять условия и продолжить</button>
                </div>
                <div id="div-second-step" style="display: none;">
                    <form id="form-global">
                        <p>Теперь Вам нужно заполнить следующую форму и приложить сканы документов. Вы можете не беспокоиться на счет безопасности своих персональных данных, так как они передаются по зашифрованному каналу связи (технология HTTPS).</p>
                        <p><strong>ВНИМАНИЕ!</strong> Пожалуйста, ознакомьтесь со следующими условиями подачи документов:</p>
                        <ul>
                            <li>Прикладываемые документы должны быть в формате PDF, JPG, JPEG или PNG.</li>
                            <li>Минимальный размер одного файла - 5 Кб, а максимальный - 10 Мб.</li>
                            <li>Подать заявление можно только один раз на один адрес электронной почты.</li>
                        </ul>
                        <h4>Персональные данные</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Фамилия<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-lastname" required="" placeholder="Фамилия">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Имя<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-firstname" required="" placeholder="Имя">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Отчество (при наличии):</label>
                                <input class="form-control" type="text" id="form-patronymic" placeholder="Отчество">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Пол<span class="text-danger">*</span>:</label>
                                <select class="form-control" id="form-sex" required="">
                                    <option value="1">Мужской</option>
                                    <option value="2">Женский</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Дата рождения<span class="text-danger">*</span>:</label>
                                <input class="form-control" id="form-birthday" type="date" required="">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Мобильный телефон<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="tel" id="form-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Домашний телефон:</label>
                                <input class="form-control" type="tel" id="form-home-telephone" placeholder="+7 (0000) 00-00-00" data-mask="+7 (0000) 00-00-00">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Адрес электронной почты<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="email" id="form-email" placeholder="Адрес электронной почты" required="">
                            </div>
                        </div>
                        <h4>Место рождения</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Страна<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-birth-country" placeholder="Например, Россия" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Субъект страны<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-birth-region" placeholder="Например, Свердловская область" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Населённый пункт<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-birth-city" placeholder="Например, Нижний Тагил" required="">
                            </div>
                        </div>
                        <h4>Адрес фактического проживания</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Страна<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-place-country" placeholder="Например, Россия" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Субъект страны<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-place-region" placeholder="Например, Свердловская область" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Населённый пункт<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-place-city" placeholder="Например, Нижний Тагил" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Улица<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-place-street" placeholder="Например, Ленина" required="">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Дом<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-place-house" placeholder="Например, 2а" required="">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Строение:</label>
                                <input class="form-control" type="text" id="form-place-building" placeholder="Например, 2">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Квартира:</label>
                                <input class="form-control" type="text" id="form-place-flat" placeholder="Например, 2">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Индекс<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="number" id="form-place-zip-code" placeholder="Например, 622001" required="" data-mask="000000">
                            </div>
                        </div>
                        <h4>Паспортные данные</h4>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label>Серия<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-passport-series" placeholder="00 00" required="" data-mask="00 00">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Номер<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-passport-number" placeholder="000000" required="" maxlength="6">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Дата выдачи<span class="text-danger">*</span>:</label>
                                <input class="form-control" id="form-passport-date" type="date" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Место выдачи<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-passport-place" required="" placeholder="Например, ГУ МВД РОССИИ ПО СВЕРДЛОВСКОЙ ОБЛАСТИ">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Код подразделения<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-passport-code" required="" placeholder="000-000" data-mask="000-000">
                            </div>
                        </div>
                        <h4>Данные о поступлении</h4>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Специальность<span class="text-danger">*</span>:</label>
                                <select class="custom-select" id="form-specialty" required="">
                                    <?php $list = $this -> database -> query("SELECT `id`, `fullname` FROM `enr_specialties` WHERE `forExtramural` = 0 ORDER BY `fullname` ASC;");
                                    if ($list -> num_rows != 0) {
                                        while ($field = $list -> fetch_assoc()) { ?>
                                            <option value="<?php echo $field["id"]; ?>"><?php echo explode("@", $field["fullname"])[0] . (!empty(explode("@", $field["fullname"])[1]) ? "*" . explode("@", $field["fullname"])[1] : ""); ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Обучение за счёт<span class="text-danger">*</span>:</label>
                                <select class="custom-select" id="form-pay" required="">
                                    <option value="1">За счет средств бюджета Свердловской области (бюджетная форма образования)</option>
                                    <option value="2">С полным возмещением затрат на обучение (договорная форма образования)</option>
                                </select>
                            </div>
                        </div>
                        <h4>Данные о предыдущем образовании</h4>
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                <label>Полное наименование образовательного учреждения<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-previous-fullname" required="" placeholder="Например, Государственное автономное профессиональное образовательное учреждение Свердловской области &quot;Нижнетагильский торгово-экономический колледж&quot;">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Дата окончания<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="number" id="form-previous-date" placeholder="Например, 2020" required="" data-mask="0000">
                            </div>
                        </div>
                        <h4>Данные документа об образовании</h4>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Уровень образования<span class="text-danger">*</span>:</label>
                                <select class="custom-select" id="form-previous-level" required="">
                                    <?php $list = $this -> database -> query("SELECT `id`, `name` FROM `enr_education_levels`;");
                                    if ($list -> num_rows != 0) {
                                        while ($field = $list -> fetch_assoc()) { ?>
                                            <option value="<?php echo $field["id"]; ?>"><?php echo $field["name"]; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Тип документа об образовании<span class="text-danger">*</span>:</label>
                                <select class="custom-select" id="form-previous-doc-type" required="">
                                    <?php $list = $this -> database -> query("SELECT * FROM `enr_educational_docs`;");
                                    if ($list -> num_rows != 0) {
                                        while ($field = $list -> fetch_assoc()) { ?>
                                            <option value="<?php echo $field["id"]; ?>"><?php echo $field["name"]; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Серия<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-previous-doc-series" required="" placeholder="Например, 123456">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Номер<span class="text-danger">*</span>:</label>
                                <input class="form-control" type="text" id="form-previous-doc-number" required="" placeholder="Например, 1234567890">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Дата выдачи<span class="text-danger">*</span>:</label>
                                <input class="form-control" id="form-previous-doc-date" type="date" required="">
                            </div>
                        </div>
                        <h4>Дополнительные данные</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Иностранный язык<span class="text-danger">*</span>:</label>
                                <select class="form-control" id="form-language" required="">
                                    <?php $list = $this -> database -> query("SELECT * FROM `enr_languages`;");
                                    if ($list -> num_rows != 0) {
                                        while ($field = $list -> fetch_assoc()) { ?>
                                            <option value="<?php echo $field["id"]; ?>"><?php echo $field["name"]; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>В общежитии<span class="text-danger">*</span>:</label>
                                <select class="form-control" id="form-hostel" required="">
                                    <option value="false" selected="">Не нуждаюсь</option>
                                    <option value="true">Нуждаюсь</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Тип комнаты:</label>
                                <select class="form-control" id="form-hostel-type" disabled>
                                    <?php $list = $this -> database -> query("SELECT * FROM `enr_hostel_rooms`;");
                                    if ($list -> num_rows != 0) {
                                        while ($field = $list -> fetch_assoc()) { ?>
                                            <option value="<?php echo $field["id"]; ?>"><?php echo "{$field["name"]}"; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Отношусь к категории граждан<span class="text-danger">*</span>:</label>
                                <select class="form-control" id="form-category-of-citizen" required="">
                                    <option value="-1" selected>Ни к одной из перечисленных</option>
                                    <?php $list = $this -> database -> query("SELECT * FROM `enr_category_of_citizen`;");
                                    if ($list -> num_rows != 0) {
                                        while ($field = $list -> fetch_assoc()) { ?>
                                            <option value="<?php echo $field["id"]; ?>"><?php echo $field["name"]; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Дополнительные сведения о себе (увлечения):</label>
                                <textarea class="form-control" id="form-about" rows="3" placeholder="Опишите свои увлечения, способности и т.д." maxlength="200"></textarea>
                            </div>
                        </div>
                        <h4>Данные о родителях (законных представителях)</h4>
                        <div id="div-mother">
                            <h5>Мать</h5>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Фамилия<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-mother-lastname" required="" placeholder="Фамилия">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Имя<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-mother-firstname" required="" placeholder="Имя">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Отчество (при наличии):</label>
                                    <input class="form-control" type="text" id="form-mother-patronymic" placeholder="Отчество">
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Место работы<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-mother-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Должность<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-mother-job-position" placeholder="Например, преподаватель" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Контактный мобильный телефон<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="tel" id="form-mother-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Рабочий телефон:</label>
                                    <input class="form-control" type="tel" id="form-mother-job-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00">
                                </div>
                                <div class="d-flex flex-column justify-content-end align-items-start form-group col-md-4">
                                    <div class="custom-control custom-switch">
                                        <input class="custom-control-input" type="checkbox" id="form-mother-checkbox-not-working">
                                        <label class="custom-control-label" for="form-mother-checkbox-not-working">Не работает</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input class="custom-control-input" type="checkbox" id="form-mother-checkbox-do-not-have">
                                        <label class="custom-control-label" for="form-mother-checkbox-do-not-have">Не имею матери</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="div-father">
                            <h5>Отец</h5>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Фамилия<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-father-lastname" required="" placeholder="Фамилия">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Имя<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-father-firstname" required="" placeholder="Имя">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Отчество (при наличии):</label>
                                    <input class="form-control" type="text" id="form-father-patronymic" placeholder="Отчество">
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Место работы<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-father-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Должность<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-father-job-position" placeholder="Например, преподаватель" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Контактный мобильный телефон<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="tel" id="form-father-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Рабочий телефон:</label>
                                    <input class="form-control" type="tel" id="form-father-job-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00">
                                </div>
                                <div class="d-flex flex-column justify-content-end align-items-start form-group col-md-4">
                                    <div class="custom-control custom-control-inline custom-switch">
                                        <input class="custom-control-input" type="checkbox" id="form-father-checkbox-not-working">
                                        <label class="custom-control-label" for="form-father-checkbox-not-working">Не работает</label>
                                    </div>
                                    <div class="custom-control custom-control-inline custom-switch">
                                        <input class="custom-control-input" type="checkbox" id="form-father-checkbox-do-not-have">
                                        <label class="custom-control-label" for="form-father-checkbox-do-not-have">Не имею отца</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>Прилагаемые документы</h4>
                        <div class="form-row">
                            <?php $list = $this -> database -> query("SELECT * FROM `enr_attached_docs` WHERE `forExtramural` = 0 AND `forOnline` = 1;");
                            if ($list -> num_rows != 0) {
                                while ($field = $list -> fetch_assoc()) { ?>
                                    <div class="form-group col-md-12"><label><?php echo $field["name"]; echo $field["isNessesary"] == 1 ? "<span class=\"text-danger\">*</span>:" : ":"; ?></label>
                                        <div class="custom-file">
                                            <input type="file" id="form-file-<?php echo "{$field["latinName"]}"; ?>" class="custom-file-input documents-input" <?php echo $field["isNessesary"] == 1 ? "required" : ""; ?> multiple="" data-id="<?php echo $field["id"]; ?>">
                                            <label class="custom-file-label" for="form-file-<?php echo "{$field["latinName"]}"; ?>">Загрузите документы...</label>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </form>
                    <p><span class="text-danger">*</span>&nbsp;- обязательно для заполнения.</p>
                    <button class="btn btn-primary btn-block" type="button" id="button-confirm">Подать заявление</button>
                    <p style="margin-top: 15px;">Нажимая кнопку "Подать заявление" Вы соглашаетесь с нашей политикой в сфере обработки и хранения персональных данных. Ознакомиться с нашей политикой Вы можете здесь.</p>
                </div>
            </div>
        </div>
    </header>
    <style type="text/css">
        .list-group-item,
        input[type="checkbox"] ~ label {
            cursor: pointer;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/fulltime.js?<?php echo time(); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="/global-assets/js/jquery.mask.js"></script>
    <script src="/global-assets/js/dropdown-bootstrap.js"></script>
</body>
</html>