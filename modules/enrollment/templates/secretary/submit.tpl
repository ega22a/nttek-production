    <div class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" id="modal-statement-receipt">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Генерация заявления</h4>
                </div>
                <div class="modal-body">
                    <p>В скором времени скачается Заявление. Провертье его правильность заполнения. Если какие-то данные неправильные, нажмите на кнопку "Заявление некорректное".</p>
                    <p>Если все данные корректны, то распечатайте Заявление, дайте абитуриенту подписать его, а затем нажмите на кнопку "сгенерировать расписку". Если абитуриент нуждается в общежитии, и вы отметили это, то при генерации расписки скачается Заявление на проживание в общежитии.</p>
                    <p><strong>ВНИМАНИЕ!</strong> При генерации расписки, личному делу присваивается уникальный номер. Также, Заявлению на проживание в общежитии будет присвоен уникальный номер.</p>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <button class="btn btn-danger btn-block" id="modal-s-r-button-error" type="button">Некорректное заявление</button>
                        </div>
                        <div class="form-group col-md-4">
                            <button class="btn btn-primary btn-block" id="modal-s-r-button-receipt" type="button">Создать расписку</button>
                        </div>
                        <div class="form-group col-md-4">
                            <button class="btn btn-primary btn-block" id="modal-s-r-button-next" type="button">Следующий абитуриент</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" id="modal-avarage-grade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
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
    <header>
        <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
            <div class="container">
                <div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active reset-nav" role="tab" data-toggle="tab" href="#tab-1">Очная форма</a></li>
                        <li class="nav-item"><a class="nav-link reset-nav" role="tab" data-toggle="tab" href="#tab-2">Заочная форма</a></li>
                    </ul>
                    <div class="tab-content custom-tab">
                        <div class="tab-pane fade show active" role="tabpanel" id="tab-1">
                            <form id="fulltime-form">
                                <h4>Персональные данные</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Фамилия<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-lastname" required="" placeholder="Фамилия">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Имя<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-firstname" required="" placeholder="Имя">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Отчество (при наличии):</label>
                                        <input class="form-control" type="text" id="fulltime-form-patronymic" required="" placeholder="Отчество">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Пол<span class="text-danger">*</span>:</label>
                                        <select class="form-control" id="fulltime-form-sex" required="">
                                            <option value="1">Мужской</option>
                                            <option value="2">Женский</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Дата рождения<span class="text-danger">*</span>:</label>
                                        <input class="form-control" id="fulltime-form-birthday" type="date" required="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Моб. телефон<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="tel" id="fulltime-form-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Домашний телефон:</label>
                                        <input class="form-control" type="tel" id="fulltime-form-home-telephone" placeholder="+7 (0000) 00-00-00" data-mask="+7 (0000) 00-00-00">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Адрес электронной почты<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="email" id="fulltime-form-email" placeholder="Адрес электронной почты" required="">
                                    </div>
                                </div>
                                <h4>Место рождения</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Страна<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-birth-country" placeholder="Например, Россия" required="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Субъект страны<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-birth-region" placeholder="Например, Свердловская область" required="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Населённый пункт<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-birth-city" placeholder="Например, Нижний Тагил" required="">
                                    </div>
                                </div>
                                <h4>Адрес фактического проживания</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Страна<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-place-country" placeholder="Например, Россия" required="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Субъект страны<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-place-region" placeholder="Например, Свердловская область" required="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Населённый пункт<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-place-city" placeholder="Например, Нижний Тагил" required="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Улица<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-place-street" placeholder="Например, Ленина" required="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Дом<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-place-house" placeholder="Например, 2а" required="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Строение:</label>
                                        <input class="form-control" type="text" id="fulltime-form-place-building" placeholder="Например, 2">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Квартира:</label>
                                        <input class="form-control" type="text" id="fulltime-form-place-flat" placeholder="Например, 2">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Индекс<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="number" id="fulltime-form-place-zip-code" placeholder="Например, 622001" required="" data-mask="000000">
                                    </div>
                                </div>
                                <h4>Паспортные данные</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label>Серия<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-passport-series" placeholder="00 00" required="" data-mask="00 00">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Номер<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-passport-number" placeholder="000000" required="" maxlength="6">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Дата выдачи<span class="text-danger">*</span>:</label>
                                        <input class="form-control" id="fulltime-form-passport-date" type="date" required="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Место выдачи<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-passport-place" required="" placeholder="Например, ГУ МВД РОССИИ ПО СВЕРДЛОВСКОЙ ОБЛАСТИ">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Код подразделения<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-passport-code" required="" placeholder="000-000" data-mask="000-000">
                                    </div>
                                </div>
                                <h4>Данные о поступлении</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Специальность<span class="text-danger">*</span>:</label>
                                        <select class="custom-select" id="fulltime-form-specialty" required="">
                                            <?php $list = $this -> database -> query("SELECT `id`, `fullname` FROM `enr_specialties` WHERE `forExtramural` = 0 ORDER BY `fullname` ASC;");
                                            if ($list -> num_rows != 0) {
                                                while ($field = $list -> fetch_assoc()) { ?>
                                                    <option value="<?php echo $field["id"]; ?>"><?php echo $field["fullname"]; ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Обучение за счёт<span class="text-danger">*</span>:</label>
                                        <select class="custom-select" id="fulltime-form-pay" required="">
                                            <option value="1">За счет средств бюджета Свердловской области (бюджетная форма образования)</option>
                                            <option value="2">С полным возмещением затрат на обучение (договорная форма образования)</option>
                                        </select>
                                    </div>
                                </div>
                                <h4>Данные о предыдущем образовании</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <label>Полное наименование образовательного учреждения<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-previous-fullname" required="" placeholder="Например, Государственное автономное профессиональное образовательное учреждение Свердловской области &quot;Нижнетагильский торгово-экономический колледж&quot;">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Дата окончания<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="number" id="fulltime-form-previous-date" placeholder="Например, 2020" required="" data-mask="0000">
                                    </div>
                                </div>
                                <h4>Данные документа об образовании</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Уровень образования<span class="text-danger">*</span>:</label>
                                        <select class="custom-select" id="fulltime-form-previous-level" required="">
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
                                        <select class="custom-select" id="fulltime-form-previous-doc-type" required="">
                                            <?php $list = $this -> database -> query("SELECT * FROM `enr_educational_docs`;");
                                            if ($list -> num_rows != 0) {
                                                while ($field = $list -> fetch_assoc()) { ?>
                                                    <option value="<?php echo $field["id"]; ?>"><?php echo $field["name"]; ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Серия:</label>
                                        <input class="form-control" type="text" id="fulltime-form-previous-doc-series" placeholder="Например, 123456">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Номер<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" id="fulltime-form-previous-doc-number" required="" placeholder="Например, 1234567890">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Дата выдачи<span class="text-danger">*</span>:</label>
                                        <input class="form-control" id="fulltime-form-previous-doc-date" type="date" required="">
                                    </div>
                                </div>
                                <h4>Дополнительные данные</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Иностранный язык<span class="text-danger">*</span>:</label>
                                        <select class="form-control" id="fulltime-form-language" required="">
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
                                        <select class="form-control" id="fulltime-form-hostel" required="">
                                            <option value="false" selected="">Не нуждаюсь</option>
                                            <option value="true">Нуждаюсь</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Тип комнаты:</label>
                                        <select class="form-control" id="fulltime-form-hostel-type" disabled>
                                            <?php $list = $this -> database -> query("SELECT * FROM `enr_hostel_rooms`;");
                                            if ($list -> num_rows != 0) {
                                                while ($field = $list -> fetch_assoc()) { ?>
                                                    <option value="<?php echo $field["id"]; ?>"><?php echo "{$field["name"]} (Цена: {$field["price"]} р.)"; ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Отношусь к категории граждан<span class="text-danger">*</span>:</label>
                                        <select class="form-control" id="fulltime-form-category-of-citizen" required="">
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
                                        <textarea class="form-control" id="fulltime-form-about" rows="3" placeholder="Опишите свои увлечения, способности и т.д." maxlength="200"></textarea>
                                    </div>
                                </div>
                                <h4>Данные о родителях (законных представителях)</h4>
                                <div id="div-mother">
                                    <h5>Мать</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Фамилия<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="fulltime-form-mother-lastname" required="" placeholder="Фамилия">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Имя<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="fulltime-form-mother-firstname" required="" placeholder="Имя">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Отчество (при наличии):</label>
                                            <input class="form-control" type="text" id="fulltime-form-mother-patronymic" placeholder="Отчество">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Место работы<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="fulltime-form-mother-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" required="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Должность<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="fulltime-form-mother-job-position" placeholder="Например, преподаватель" required="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Контактный мобильный телефон<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="tel" id="fulltime-form-mother-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Рабочий телефон:</label>
                                            <input class="form-control" type="tel" id="fulltime-form-mother-job-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00">
                                        </div>
                                        <div class="d-flex flex-column justify-content-end align-items-start form-group col-md-4">
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input" type="checkbox" id="fulltime-form-mother-checkbox-not-working">
                                                <label class="custom-control-label" for="fulltime-form-mother-checkbox-not-working">Не работает</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input" type="checkbox" id="fulltime-form-mother-checkbox-do-not-have">
                                                <label class="custom-control-label" for="fulltime-form-mother-checkbox-do-not-have">Не имею матери</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="div-father">
                                    <h5>Отец</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Фамилия<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="fulltime-form-father-lastname" required="" placeholder="Фамилия">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Имя<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="fulltime-form-father-firstname" required="" placeholder="Имя">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Отчество (при наличии):</label>
                                            <input class="form-control" type="text" id="fulltime-form-father-patronymic" placeholder="Отчество">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Место работы<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="fulltime-form-father-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" required="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Должность<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="fulltime-form-father-job-position" placeholder="Например, преподаватель" required="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Контактный мобильный телефон<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="tel" id="fulltime-form-father-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Рабочий телефон:</label>
                                            <input class="form-control" type="tel" id="fulltime-form-father-job-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00">
                                        </div>
                                        <div class="d-flex flex-column justify-content-end align-items-start form-group col-md-4">
                                            <div class="custom-control custom-control-inline custom-switch">
                                                <input class="custom-control-input" type="checkbox" id="fulltime-form-father-checkbox-not-working">
                                                <label class="custom-control-label" for="fulltime-form-father-checkbox-not-working">Не работает</label>
                                            </div>
                                            <div class="custom-control custom-control-inline custom-switch">
                                                <input class="custom-control-input" type="checkbox" id="fulltime-form-father-checkbox-do-not-have">
                                                <label class="custom-control-label" for="fulltime-form-father-checkbox-do-not-have">Не имею отца</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="div-representative">
                                    <h5>Законный представитель</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Фамилия:</label>
                                            <input class="form-control" type="text" id="fulltime-form-representative-lastname" disabled="" placeholder="Фамилия">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Имя:</label>
                                            <input class="form-control" type="text" id="fulltime-form-representative-firstname" disabled="" placeholder="Имя">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Отчество (при наличии):</label>
                                            <input class="form-control" type="text" id="fulltime-form-representative-patronymic" disabled="" placeholder="Отчество">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Место работы:</label>
                                            <input class="form-control" type="text" id="fulltime-form-representative-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" disabled="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Должность:</label>
                                            <input class="form-control" type="text" id="fulltime-form-representative-job-position" placeholder="Например, преподаватель" disabled="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Контактный мобильный телефон:</label>
                                            <input class="form-control" type="tel" id="fulltime-form-representative-telephone" placeholder="+7 (900) 000 00-00" disabled="" data-mask="+7 (900) 000 00-00">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Рабочий телефон:</label>
                                            <input class="form-control" type="tel" id="fulltime-form-representative-job-telephone" placeholder="+7 (900) 000 00-00" disabled="" data-mask="+7 (900) 000 00-00">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Кем приходится:</label>
                                            <input class="form-control" type="text" id="fulltime-form-representative-who" disabled="" placeholder="Например, бабушка">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="custom-control custom-control-inline custom-switch">
                                                <input class="custom-control-input" type="checkbox" id="fulltime-form-representative-checkbox-not-working" disabled="">
                                                <label class="custom-control-label" for="fulltime-form-representative-checkbox-not-working">Не работает</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4>Прилагаемые документы</h4>
                                <div class="form-row" style="margin: 15px;">
                                    <div class="form-group col-md-12">
                                        <div class="custom-control custom-control-inline custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="fulltime-form-original-diploma">
                                            <label class="custom-control-label" for="fulltime-form-original-diploma">Оригинал документа об образовании</label>
                                        </div>
                                    </div>
                                    <?php $list = $this -> database -> query("SELECT * FROM `enr_attached_docs` WHERE `forExtramural` = 0 AND `forOnline` = 0;");
                                    if ($list -> num_rows != 0) {
                                        while ($field = $list -> fetch_assoc()) { ?>
                                            <div class="form-group col-md-12">
                                                <div class="custom-control custom-control-inline custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="fulltime-form-file-<?php echo "{$field["latinName"]}"; ?>" <?php echo $field["isNessesary"] == 1 ? "required disabled checked" : ""; ?> data-id="<?php echo $field["id"]; ?>">
                                                    <label class="custom-control-label" for="fulltime-form-file-<?php echo "{$field["latinName"]}"; ?>"><?php echo $field["name"]; echo $field["isNessesary"] == 1 ? "<span class=\"text-danger\">*</span>" : ""; ?></label>
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>
                            </form>
                            <p><span class="text-danger">*</span>&nbsp;- обязательно для заполнения.</p>
                            <button class="btn btn-primary btn-block" type="button" id="button-confirm-fulltime">Создать заявление</button>
                        </div>
                        <div class="tab-pane fade" role="tabpanel" id="tab-2">
                        <form id="extramural-form">
                            <h4>Персональные данные</h4>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Фамилия<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-lastname" required="" placeholder="Фамилия">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Имя<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-firstname" required="" placeholder="Имя">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Отчество (при наличии):</label>
                                    <input class="form-control" type="text" id="extramural-form-patronymic" required="" placeholder="Отчество">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Пол<span class="text-danger">*</span>:</label>
                                    <select class="form-control" id="extramural-form-sex" required="">
                                        <option value="1">Мужской</option>
                                        <option value="2">Женский</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Дата рождения<span class="text-danger">*</span>:</label>
                                    <input class="form-control" id="extramural-form-birthday" type="date" required="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Моб. телефон<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="tel" id="extramural-form-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Домашний телефон:</label>
                                    <input class="form-control" type="tel" id="extramural-form-home-telephone" placeholder="+7 (0000) 00-00-00" data-mask="+7 (0000) 00-00-00">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Адрес электронной почты<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="email" id="extramural-form-email" placeholder="Адрес электронной почты" required="">
                                </div>
                            </div>
                            <h4>Место рождения</h4>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Страна<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-birth-country" placeholder="Например, Россия" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Субъект страны<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-birth-region" placeholder="Например, Свердловская область" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Населённый пункт<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-birth-city" placeholder="Например, Нижний Тагил" required="">
                                </div>
                            </div>
                            <h4>Адрес фактического проживания</h4>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Страна<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-place-country" placeholder="Например, Россия" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Субъект страны<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-place-region" placeholder="Например, Свердловская область" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Населённый пункт<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-place-city" placeholder="Например, Нижний Тагил" required="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Улица<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-place-street" placeholder="Например, Ленина" required="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Дом<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-place-house" placeholder="Например, 2а" required="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Строение:</label>
                                    <input class="form-control" type="text" id="extramural-form-place-building" placeholder="Например, 2">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Квартира:</label>
                                    <input class="form-control" type="text" id="extramural-form-place-flat" placeholder="Например, 2">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Индекс<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="number" id="extramural-form-place-zip-code" placeholder="Например, 622001" required="" data-mask="000000">
                                </div>
                            </div>
                            <h4>Паспортные данные</h4>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Серия<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-passport-series" placeholder="00 00" required="" data-mask="00 00">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Номер<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-passport-number" placeholder="000000" required="" maxlength="6">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Дата выдачи<span class="text-danger">*</span>:</label>
                                    <input class="form-control" id="extramural-form-passport-date" type="date" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Место выдачи<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-passport-place" required="" placeholder="Например, ГУ МВД РОССИИ ПО СВЕРДЛОВСКОЙ ОБЛАСТИ">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Код подразделения<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-passport-code" required="" placeholder="000-000" data-mask="000-000">
                                </div>
                            </div>
                            <h4>Данные о поступлении</h4>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Специальность<span class="text-danger">*</span>:</label>
                                    <select class="custom-select" id="extramural-form-specialty" required="">
                                        <?php $list = $this -> database -> query("SELECT `id`, `fullname` FROM `enr_specialties` WHERE `forExtramural` = 1 ORDER BY `fullname` ASC;");
                                        if ($list -> num_rows != 0) {
                                            while ($field = $list -> fetch_assoc()) { ?>
                                                <option value="<?php echo $field["id"]; ?>"><?php echo $field["fullname"]; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Обучение за счёт<span class="text-danger">*</span>:</label>
                                    <select class="custom-select" id="extramural-form-pay" required="">
                                        <option value="1">За счет средств бюджета Свердловской области (бюджетная форма образования)</option>
                                        <option value="2">С полным возмещением затрат на обучение (договорная форма образования)</option>
                                    </select>
                                </div>
                            </div>
                            <h4>Данные о предыдущем образовании</h4>
                            <div class="form-row">
                                <div class="form-group col-md-10">
                                    <label>Полное наименование образовательного учреждения<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-previous-fullname" required="" placeholder="Например, Государственное автономное профессиональное образовательное учреждение Свердловской области &quot;Нижнетагильский торгово-экономический колледж&quot;">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Дата окончания<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="number" id="extramural-form-previous-date" placeholder="Например, 2020" required="" data-mask="0000">
                                </div>
                            </div>
                            <h4>Данные документа об образовании</h4>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Уровень образования<span class="text-danger">*</span>:</label>
                                    <select class="custom-select" id="extramural-form-previous-level" required="">
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
                                    <select class="custom-select" id="extramural-form-previous-doc-type" required="">
                                        <?php $list = $this -> database -> query("SELECT * FROM `enr_educational_docs`;");
                                        if ($list -> num_rows != 0) {
                                            while ($field = $list -> fetch_assoc()) { ?>
                                                <option value="<?php echo $field["id"]; ?>"><?php echo $field["name"]; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Серия:</label>
                                    <input class="form-control" type="text" id="extramural-form-previous-doc-series" placeholder="Например, 123456">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Номер<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="extramural-form-previous-doc-number" required="" placeholder="Например, 1234567890">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Дата выдачи<span class="text-danger">*</span>:</label>
                                    <input class="form-control" id="extramural-form-previous-doc-date" type="date" required="">
                                </div>
                            </div>
                            <h4>Дополнительные данные</h4>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Иностранный язык<span class="text-danger">*</span>:</label>
                                    <select class="form-control" id="extramural-form-language" required="">
                                        <?php $list = $this -> database -> query("SELECT * FROM `enr_languages`;");
                                        if ($list -> num_rows != 0) {
                                            while ($field = $list -> fetch_assoc()) { ?>
                                                <option value="<?php echo $field["id"]; ?>"><?php echo $field["name"]; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Отношусь к категории граждан<span class="text-danger">*</span>:</label>
                                    <select class="form-control" id="extramural-form-category-of-citizen" required="">
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
                            <h4>Сведения о работе</h4>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Место работы<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" required="" id="extramural-form-job-name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Должность<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" required="" id="extramural-form-job-position">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Стаж работы в отрасли<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="number" required="" id="extramural-form-job-years">
                                </div>
                                <div class="d-flex flex-column justify-content-end align-items-start form-group col-md-4">
                                    <div class="custom-control custom-switch">
                                        <input class="custom-control-input" type="checkbox" id="extramural-form-checkbox-not-working">
                                        <label class="custom-control-label" for="extramural-form-checkbox-not-working">Не работаю</label>
                                    </div>
                                </div>
                            </div>
                            <h4>Прилагаемые документы</h4>
                            <div class="form-row" style="margin: 15px;">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-control-inline custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="extramural-form-original-diploma">
                                        <label class="custom-control-label" for="extramural-form-original-diploma">Оригинал документа об образовании</label>
                                    </div>
                                </div>
                                <?php $list = $this -> database -> query("SELECT * FROM `enr_attached_docs` WHERE `forExtramural` = 1 AND `forOnline` = 0;");
                                if ($list -> num_rows != 0) {
                                    while ($field = $list -> fetch_assoc()) { ?>
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-control-inline custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="extramural-form-file-<?php echo "{$field["latinName"]}"; ?>" <?php echo $field["isNessesary"] == 1 ? "required disabled checked" : ""; ?> data-id="<?php echo $field["id"]; ?>">
                                                <label class="custom-control-label" for="extramural-form-file-<?php echo "{$field["latinName"]}"; ?>"><?php echo $field["name"]; echo $field["isNessesary"] == 1 ? "<span class=\"text-danger\">*</span>" : ""; ?></label>
                                            </div>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                            </form>
                            <p><span class="text-danger">*</span>&nbsp;- обязательно для заполнения.</p>
                            <button class="btn btn-primary btn-block" type="button" id="button-confirm-extramural">Создать заявление</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <style type="text/css">
        .list-group-item,
        input[type="checkbox"] ~ label {
            cursor: pointer;
        }
        .custom-tab {
            background: #fff;
            border-right: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
            border-left: 1px solid #e9ecef;
            border-radius: 0 0 5px 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/secretary/submit.js?<?php echo time(); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="/global-assets/js/jquery.mask.js"></script>
    <script src="/global-assets/js/dropdown-bootstrap.js"></script>
</body>
</html>
