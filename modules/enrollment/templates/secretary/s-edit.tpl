<?php $isFulltime = $this -> statement["educationalType"] == "fulltime" ? 1 : 0; ?>
<?php $key = [
    "specialty" => $this -> database -> query("SELECT `compositeKey` FROM `enr_specialties` WHERE `id` = {$this -> statement["specialty"]}") -> fetch_assoc()["compositeKey"],
    "level" => $this -> database -> query("SELECT `compositeKey` FROM `enr_education_levels` WHERE `id` = {$this -> statement["degree"]}") -> fetch_assoc()["compositeKey"],
    "count" => $this -> database -> query("SELECT `compositeKey` FROM `enr_statements` WHERE `id` = {$this -> statement["id"]}") -> fetch_assoc()["compositeKey"],
    "year" => Date("Y", $this -> statement["timestamp"]),
]; ?>
<script type="text/javascript"> document.title = "Редактирование абитуриента"; </script>
<header style="min-height: 100vh;">
    <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
        <div class="container">
            <nav aria-label="breadcrumb" style="margin: 0 15px;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="statements">Управление принятыми заявлениями</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo "{$this -> crypt -> decrypt($this -> statement["lastname"])} {$this -> crypt -> decrypt($this -> statement["firstname"])} " . (!empty($this -> statement["patronymic"]) ? $this -> crypt -> decrypt($this -> statement["patronymic"]) : ""); echo " ({$key["count"]}-{$key["level"]}-{$key["specialty"]}/{$key["year"]} ({$this -> statement["id"]}))"; ?></li>
                </ol>
            </nav>
            <script type="text/javascript">
                var enrollee = {
                        type: "<?php echo $this -> statement["educationalType"]; ?>",
                        id: <?php echo $this -> statement["id"]; ?>
                };
            </script>
            <div class="row col-md-12" style="margin: 0 auto; align-items: flex-start;">
                <div class="col-md-3">
                    <ul class="nav nav-pills flex-column" role="tablist" area-orientation="vertical" data-count="1">
                        <li class="nav-item">
                            <a class="nav-link active" id="v-pills-statement-edit-pill" href="#v-pills-statement-edit" data-toggle="pill" role="tab" aria-controls="v-pills-statement-edit" aria-selected="true">Редактировать данные</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="v-pills-statement-more-pill" href="#v-pills-statement-more" data-toggle="pill" role="tab" aria-controls="v-pills-statement-more" aria-selected="true">Дополнительные действия</a>
                        </li>
                    </ul>
                </div>
                <div class="border rounded col-md-9 tab-content" style="padding: 15px;margin-bottom: 15px;">
                    <div id="v-pills-statement-edit" class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-pills-statement-edit-pill">
                        <form id="form">
                            <h4>Персональные данные</h4>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Фамилия<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-lastname" required="" placeholder="Фамилия" value="<?php echo $this -> crypt -> decrypt($this -> statement["lastname"]); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Имя<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-firstname" required="" placeholder="Имя" value="<?php echo $this -> crypt -> decrypt($this -> statement["firstname"]); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Отчество (при наличии):</label>
                                    <input class="form-control" type="text" id="form-patronymic" placeholder="Отчество" value="<?php echo !empty($this -> statement["patronymic"]) ? $this -> crypt -> decrypt($this -> statement["patronymic"]) : ""; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Пол<span class="text-danger">*</span>:</label>
                                    <select class="form-control" id="form-sex" required="">
                                        <option value="1" <?php echo $this -> statement["sex"] == 1 ? "selected" : ""; ?>>Мужской</option>
                                        <option value="2" <?php echo $this -> statement["sex"] == 2 ? "selected" : ""; ?>>Женский</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Дата рождения<span class="text-danger">*</span>:</label>
                                    <input class="form-control" id="form-birthday" type="date" required="" value="<?php echo $this -> crypt -> decrypt($this -> statement["birthday"]); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Моб. телефон<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="tel" id="form-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00" value="<?php echo $this -> crypt -> decrypt($this -> statement["telephone"]); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Домашний телефон:</label>
                                    <input class="form-control" type="tel" id="form-home-telephone" placeholder="+7 (0000) 00-00-00" data-mask="+7 (0000) 00-00-00" value="<?php echo !empty($this -> statement["homeTelephone"]) ? $this -> crypt -> decrypt($this -> statement["homeTelephone"]) : ""; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Адрес электронной почты<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="email" id="form-email" placeholder="Адрес электронной почты" required="" value="<?php echo $this -> crypt -> decrypt($this -> statement["email"]); ?>">
                                </div>
                            </div>
                            <h4>Место рождения</h4>
                            <?php $birthplace = json_decode($this -> crypt -> decrypt($this -> statement["birthplace"])); ?>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Страна<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-birth-country" placeholder="Например, Россия" required="" value="<?php echo $birthplace -> country; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Субъект страны<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-birth-region" placeholder="Например, Свердловская область" required="" value="<?php echo $birthplace -> region; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Населённый пункт<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-birth-city" placeholder="Например, Нижний Тагил" required="" value="<?php echo $birthplace -> city; ?>">
                                </div>
                            </div>
                            <h4>Адрес фактического проживания</h4>
                            <?php $address = json_decode($this -> crypt -> decrypt($this -> statement["address"])); ?>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Страна<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-place-country" placeholder="Например, Россия" required=""  value="<?php echo $address -> country; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Субъект страны<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-place-region" placeholder="Например, Свердловская область" required="" value="<?php echo $address -> region; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Населённый пункт<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-place-city" placeholder="Например, Нижний Тагил" required="" value="<?php echo $address -> city; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Улица<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-place-street" placeholder="Например, Ленина" required="" value="<?php echo $address -> street; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Дом<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-place-house" placeholder="Например, 2а" required="" value="<?php echo $address -> house; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Строение:</label>
                                    <input class="form-control" type="text" id="form-place-building" placeholder="Например, 2" value="<?php echo !empty($address -> building) ? $address -> building : ""; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Квартира:</label>
                                    <input class="form-control" type="text" id="form-place-flat" placeholder="Например, 2" value="<?php echo !empty($address -> flat) ? $address -> flat : ""; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Индекс<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="number" id="form-place-zip-code" placeholder="Например, 622001" required="" data-mask="000000" value="<?php echo $address -> zipCode; ?>">
                                </div>
                            </div>
                            <h4>Паспортные данные</h4>
                            <?php $passport = json_decode($this -> crypt -> decrypt($this -> statement["passport"])); ?>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Серия<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-passport-series" required="" placeholder="00 00" data-mask="00 00" value="<?php echo $passport -> series; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Номер<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-passport-number" placeholder="000000" required="" maxlength="6" value="<?php echo $passport -> number; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Дата выдачи<span class="text-danger">*</span>:</label>
                                    <input class="form-control" id="form-passport-date" type="date" required="" value="<?php echo $passport -> date; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Код подразделения<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-passport-code" required="" placeholder="000-000" data-mask="000-000" value="<?php echo $passport -> code; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Место выдачи<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-passport-place" required="" placeholder="Например, ГУ МВД РОССИИ ПО СВЕРДЛОВСКОЙ ОБЛАСТИ" value="<?php echo $passport -> place; ?>">
                                </div>
                            </div>
                            <h4>Данные о поступлении</h4>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Обучение за счёт<span class="text-danger">*</span>:</label>
                                    <select class="custom-select" id="form-pay" required="">
                                        <option value="1" <?php echo $this -> statement["paysType"] == "1" ? "selected" : ""; ?>>За счет средств бюджета Свердловской области (бюджетная форма образования)</option>
                                        <option value="2" <?php echo $this -> statement["paysType"] == "2" ? "selected" : ""; ?>>С полным возмещением затрат на обучение (договорная форма образования)</option>
                                    </select>
                                </div>
                            </div>
                            <h4>Данные о предыдущем образовании</h4>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Полное наименование образовательного учреждения<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-previous-fullname" required="" placeholder="Например, Государственное автономное профессиональное образовательное учреждение Свердловской области &quot;Нижнетагильский торгово-экономический колледж&quot;" value='<?php echo stripcslashes($this -> crypt -> decrypt($this -> statement["previousSchool"])); ?>'>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Дата окончания<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="number" id="form-previous-date" placeholder="Например, 2020" required="" data-mask="0000" value="<?php echo $this -> crypt -> decrypt($this -> statement["previousSchoolDate"]); ?>">
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
                                                <option value="<?php echo $field["id"]; ?>" <?php echo $field["id"] == $this -> statement["degree"] ? "selected" : ""; ?>><?php echo $field["name"]; ?></option>
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
                                                <option value="<?php echo $field["id"]; ?>" <?php echo $field["id"] == $this -> statement["previousSchoolDoc"] ? "selected" : ""; ?>><?php echo $field["name"]; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <?php $schoolDoc = json_decode($this -> crypt -> decrypt($this -> statement["previousSchoolDocData"])); ?>
                                <div class="form-group col-md-4">
                                    <label>Серия:</label>
                                    <input class="form-control" type="text" id="form-previous-doc-series" placeholder="Например, 123456" value="<?php echo $schoolDoc -> series; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Номер<span class="text-danger">*</span>:</label>
                                    <input class="form-control" type="text" id="form-previous-doc-number" required="" placeholder="Например, 1234567890" value="<?php echo $schoolDoc -> number; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Дата выдачи<span class="text-danger">*</span>:</label>
                                    <input class="form-control" id="form-previous-doc-date" type="date" required="" value="<?php echo $schoolDoc -> date; ?>">
                                </div>
                            </div>
                            <h4>Дополнительные данные</h4>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Иностранный язык<span class="text-danger">*</span>:</label>
                                    <select class="form-control" id="form-language" required="">
                                        <?php $list = $this -> database -> query("SELECT * FROM `enr_languages`;");
                                        if ($list -> num_rows != 0) {
                                            while ($field = $list -> fetch_assoc()) { ?>
                                                <option value="<?php echo $field["id"]; ?>" <?php echo $field["id"] == $this -> statement["language"] ? "selected" : ""; ?>><?php echo $field["name"]; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Отношусь к категории граждан<span class="text-danger">*</span>:</label>
                                    <select class="form-control" id="form-category-of-citizen" required="">
                                        <option value="-1" selected>Ни к одной из перечисленных</option>
                                        <?php $list = $this -> database -> query("SELECT * FROM `enr_category_of_citizen`;");
                                        if ($list -> num_rows != 0) {
                                            while ($field = $list -> fetch_assoc()) { ?>
                                                <option value="<?php echo $field["id"]; ?>" <?php echo $field["id"] == $this -> statement["category"] ? "selected" : ""; ?>><?php echo $field["name"]; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <?php if (boolval($isFulltime)) { ?>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Дополнительные сведения о себе (увлечения):</label>
                                        <textarea class="form-control" id="form-about" rows="3" placeholder="Опишите свои увлечения, способности и т.д." maxlength="200"><?php echo stripcslashes($this -> crypt -> decrypt($this -> statement["about"])); ?></textarea>
                                    </div>
                                </div>
                            <?php }
                            if (boolval($isFulltime)) { ?>
                                <h4>Данные о родителях (законных представителях)</h4>
                                <div id="div-mother">
                                    <?php $mother = !empty($this -> statement["mother"]) ? json_decode($this -> crypt -> decrypt($this -> statement["mother"])) : NULL; ?>
                                    <h5>Мать</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Фамилия<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="form-mother-lastname" required="" placeholder="Фамилия" value="<?php echo !empty($mother) ? $mother -> lastname : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Имя<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="form-mother-firstname" required="" placeholder="Имя" value="<?php echo !empty($mother) ? $mother -> firstname : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Отчество (при наличии):</label>
                                            <input class="form-control" type="text" id="form-mother-patronymic" placeholder="Отчество" value="<?php echo !empty($mother) ? $mother -> patronymic : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Место работы:</label>
                                            <input class="form-control" type="text" id="form-mother-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" value='<?php echo stripcslashes(!empty($mother) ? $mother -> jobName : ""); ?>'>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Должность:</label>
                                            <input class="form-control" type="text" id="form-mother-job-position" placeholder="Например, преподаватель" value="<?php echo !empty($mother) ? $mother -> jobPosition : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Контактный мобильный телефон<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="tel" id="form-mother-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00" value="<?php echo !empty($mother) ? $mother -> telephone : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Рабочий телефон:</label>
                                            <input class="form-control" type="tel" id="form-mother-job-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00" value="<?php echo !empty($mother) ? $mother -> jobTelephone : ""; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div id="div-father">
                                    <h5>Отец</h5>
                                    <?php $father = !empty($this -> statement["father"]) ? json_decode($this -> crypt -> decrypt($this -> statement["father"])) : NULL; ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Фамилия<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="form-father-lastname" required="" placeholder="Фамилия" value="<?php echo !empty($father) ? $father -> lastname : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Имя<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="text" id="form-father-firstname" required="" placeholder="Имя" value="<?php echo !empty($father) ? $father -> firstname : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Отчество (при наличии):</label>
                                            <input class="form-control" type="text" id="form-father-patronymic" placeholder="Отчество" value="<?php echo !empty($father) ? $father -> patronymic : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Место работы:</label>
                                            <input class="form-control" type="text" id="form-father-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" value='<?php echo stripcslashes(!empty($father) ? $father -> jobName : ""); ?>'>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Должность:</label>
                                            <input class="form-control" type="text" id="form-father-job-position" placeholder="Например, преподаватель" value="<?php echo !empty($father) ? $father -> jobPosition : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Контактный мобильный телефон<span class="text-danger">*</span>:</label>
                                            <input class="form-control" type="tel" id="form-father-telephone" placeholder="+7 (900) 000 00-00" required="" data-mask="+7 (900) 000 00-00" value="<?php echo !empty($father) ? $father -> telephone : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Рабочий телефон:</label>
                                            <input class="form-control" type="tel" id="form-father-job-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00" value="<?php echo !empty($father) ? $father -> jobTelephone : ""; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div id="div-representative">
                                    <h5>Законный представитель</h5>
                                    <?php $representative = !empty($this -> statement["representative"]) ? json_decode($this -> crypt -> decrypt($this -> statement["representative"])) : NULL; ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Фамилия:</label>
                                            <input class="form-control" type="text" id="form-representative-lastname" placeholder="Фамилия" value="<?php echo !empty($representative) ? $representative -> lastname : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Имя:</label>
                                            <input class="form-control" type="text" id="form-representative-firstname" placeholder="Имя" value="<?php echo !empty($representative) ? $representative -> firstname : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Отчество (при наличии):</label>
                                            <input class="form-control" type="text" id="form-representative-patronymic" placeholder="Отчество" value="<?php echo !empty($representative) ? $representative -> patronymic : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Место работы:</label>
                                            <input class="form-control" type="text" id="form-representative-job-name" placeholder="Например, ГАПОУ СО &quot;НТТЭК&quot;" value='<?php echo stripcslashes(!empty($representative) ? $representative -> jobName : ""); ?>'>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Должность:</label>
                                            <input class="form-control" type="text" id="form-representative-job-position" placeholder="Например, преподаватель" value="<?php echo !empty($representative) ? $representative -> jobPosition : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Контактный мобильный телефон:</label>
                                            <input class="form-control" type="tel" id="form-representative-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00" value="<?php echo !empty($representative) ? $representative -> telephone : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Рабочий телефон:</label>
                                            <input class="form-control" type="tel" id="form-representative-job-telephone" placeholder="+7 (900) 000 00-00" data-mask="+7 (900) 000 00-00" value="<?php echo !empty($representative) ? $representative -> jobTelephone : ""; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Кем приходится:</label>
                                            <input class="form-control" type="text" id="form-representative-who" placeholder="Например, бабушка" value="<?php echo !empty($representative) ? $representative -> who : ""; ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <h4>Сведения о работе</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Место работы<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" required="" id="form-job-name" value='<?php echo !empty($this -> statement["work"]) ? stripcslashes($this -> crypt -> decrypt($this -> statement["work"])) : ""; ?>'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Должность<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="text" required="" id="form-job-position" value='<?php echo !empty($this -> statement["position"]) ? stripcslashes($this -> crypt -> decrypt($this -> statement["position"])) : ""; ?>'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Стаж работы в отрасли (полных лет)<span class="text-danger">*</span>:</label>
                                        <input class="form-control" type="number" required="" id="form-job-years" value='<?php echo !empty($this -> statement["workExpirence"]) ? stripcslashes($this -> crypt -> decrypt($this -> statement["workExpirence"])) : ""; ?>'>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                        <p><span class="text-danger">*</span>&nbsp;- обязательно для заполнения.</p>
                        <button class="btn btn-primary btn-block" type="button" style="margin-top: 15px;" id="button-personal-data-save">Сохранить</button>
                    </div>
                    <div id="v-pills-statement-more" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-statement-more-pill">
                        <div role="tablist" id="accordion-1" class="accordion">
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-1" href="#accordion-1 .item-1">Сменить специальность</a>
                                    </h5>
                                </div>
                                <div class="collapse item-1" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <p class="card-text">В нижеприведенном выпадающем списке выберите специальность, в которую хочет перейти абитуриент. Учтите, что при смене специальности у абитуриента удалится присвоенный ему составной ключ и сгенерируется новый, в соответствии со специальностью.</p>
                                        <select class="custom-select" id="form-enrollee-specialty">
                                            <?php $specialties = $this -> database -> query("SELECT * FROM `enr_specialties` WHERE `forExtramural` = " . (boolval($isFulltime) ? "0" : "1") . " ORDER BY `fullname` ASC;");
                                            while ($row = $specialties -> fetch_assoc()) { ?>
                                                <option value="<?php echo $row["id"]; ?>" <?php echo $row["id"] == $this -> statement["specialty"] ? "selected" : ""; ?>><?php echo explode("@", $row["fullname"])[0] . (!empty(explode("@", $row["fullname"])[1]) ? "*" . explode("@", $row["fullname"])[1] : ""); ?></option>
                                            <?php } ?>
                                        </select>
                                        <button class="btn btn-primary btn-block" type="button" style="margin-top: 15px;" id="button-specialty-save">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-2" href="#accordion-1 .item-2">Изменить список прилагаемых документов</a>
                                    </h5>
                                </div>
                                <div class="collapse item-2" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <p class="card-text">Здесь вы можете изменить список прилагаемых документов абитуриентом. Также, вы можете загрузить сканы прилагаемых документов, если это будет необходимо. Учтите, что если вы установите какому-либо документу, что он не приложен, то с сервера удалятся эти приложенные документы!</p>
                                        <ul class="list-group" id="attached-docs-list-group">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-control-inline custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="checkbox-original-diploma" <?php echo boolval($this -> statement["withOriginalDiploma"]) ? "checked" : ""; ?>>
                                                            <label class="custom-control-label" for="checkbox-original-diploma">Оригинал документа об образовании</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $attachedDocs_db = json_decode($this -> crypt -> decrypt($this -> statement["attachedDocs"]));
                                            $attachedDocs = $this -> database -> query("SELECT * FROM `enr_attached_docs` WHERE" . (boolval($this -> statement["isOnline"]) ? " (`forOnline` = 0 OR `forOnline` = 1)" : " `forOnline` = 0") . " AND `forExtramural` =" . (boolval($isFulltime) ? "0" : "1"));
                                            while ($row = $attachedDocs -> fetch_assoc()) { ?>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                            <div class="custom-control custom-control-inline custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="checkbox-<?php echo $row["latinName"]; ?>" <?php echo in_array($row["id"], $attachedDocs_db) ? "checked" : ""; ?>>
                                                                <label class="custom-control-label" for="checkbox-<?php echo $row["latinName"]; ?>"><?php echo $row["name"] . (boolval($row["forOnline"]) ? " (наследовано из онлайн-приема)" : ""); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input documents-input" required="" multiple="" data-name="<?php echo $row["latinName"]; ?>" id="file-<?php echo $row["latinName"]; ?>">
                                                                <label class="custom-file-label" for="file-<?php echo $row["latinName"]; ?>">Загрузите документы...</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <button class="btn btn-primary btn-block" type="button" style="margin-top: 15px;" id="button-attached-docs-save">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                            <?php if (boolval($isFulltime)) { ?>
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-3" href="#accordion-1 .item-3">Изменить статус заявления на общежитие</a>
                                        </h5>
                                    </div>
                                    <div class="collapse item-3" role="tabpanel" data-parent="#accordion-1">
                                        <div class="card-body">
                                            <p class="card-text">Тут вы можете изменить статус заявления на общежитие.</p>
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input" type="checkbox" id="checkbox-hostel-open" <?php echo boolval($this -> statement["hostel"]) ? "checked" : ""; ?>>
                                                <label class="custom-control-label" for="checkbox-hostel-open">Нуждается в общежитии</label>
                                            </div>
                                            <select class="custom-select" style="margin-top: 15px;" id="form-select-hostel-type">
                                                <?php $hostel_rooms = $this -> database -> query("SELECT * FROM `enr_hostel_rooms`;");
                                                while ($row = $hostel_rooms -> fetch_assoc()) { ?>
                                                    <option value="<?php echo $row["id"]; ?>" <?php echo $this -> statement["hostelRoom"] == $row["id"] ? "selected" : ""; ?>><?php echo "{$row["name"]} (Цена: {$row["price"]} р.)"; ?></option>
                                                <?php } ?>
                                            </select>
                                            <button class="btn btn-primary btn-block" type="button" style="margin-top: 15px;" id="button-hostel-save">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-4" href="#accordion-1 .item-4">Изменить средний балл</a>
                                    </h5>
                                </div>
                                <div class="collapse item-4" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <p class="card-text">Введите оценки из документа об образовании без разделителей, пробелов, знаков препинания. Допускаются оценки: 3, 4 и 5.</p>
                                        <form>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <input class="form-control" type="text" required placeholde="12345" id="text-input-average-grade">
                                                </div>
                                            </div>
                                        </form>
                                        <p>Нынешняя средняя оценка: <strong><span id="span-average-grade"><?php echo $this -> statement["averageMark"]; ?></span></strong></p>
                                        <button class="btn btn-primary btn-block" type="button" style="margin-top: 15px;" id="button-average-grade-save">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" aria-expanded="false" aria-controls="accordion-1 .item-5" href="#accordion-1 .item-5">Сообщение в личный кабинет</a>
                                    </h5>
                                </div>
                                <div class="collapse item-5" role="tabpanel" data-parent="#accordion-1">
                                    <div class="card-body">
                                        <div class="wysiwyg-summernote" id="wysiwyg"></div>
                                        <button class="btn btn-primary btn-block" type="button" style="margin-top: 15px;" id="button-add-additional-text">Сохранить</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/secretary/s-edit.js?<?php echo time(); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
<script src="/global-assets/js/jquery.mask.js"></script>
<script src="/global-assets/js/dropdown-bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="/global-assets/js/summernote-ru-RU.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
</body>

</html>
