<?php $forms = $this -> database -> query("SELECT * FROM `frm_forms`;"); ?>
<header style="min-height: 100vh;background-size: cover;background-repeat: no-repeat;">
    <div style="width: 100%;min-height: 100vh;padding-top: 80px;">
        <div class="container">
            <div class="row col-md-12" style="margin: 0 auto;">
                <div class="col-md-3">
                    <ul class="nav nav-pills flex-column" role="tablist" area-orientation="vertical">
                        <?php if ($forms -> num_rows != 0) {
                            $counter = 0;
                            while ($form = $forms -> fetch_assoc()) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $counter == 0 ? "active" : ""; ?>" id="v-pills-<?php echo $form["id"]; ?>-tab" href="#v-pills-<?php echo $form["id"]; ?>" data-toggle="pill" role="tab" aria-controls="v-pills-<?php echo $form["id"]; ?>" aria-selected="true"><?php echo $form["name"]; ?></a>
                                </li>
                                <?php $counter++;
                            }
                        }?>
                    </ul>
                </div>
                <div class="border rounded col-md-9 tab-content" style="padding: 15px; margin-bottom: 15px;">
                    <?php $forms -> data_seek(0);
                    if ($forms -> num_rows != 0) {
                        $counter = 0;
                        while ($form = $forms -> fetch_assoc()) { ?>
                            <div id="v-pills-<?php echo $form["id"]; ?>" class="tab-pane fade show <?php echo $counter == 0 ? "active" : ""; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $form["id"]; ?>-tab">
                                <h3><?php echo $form["name"]; ?></h3>
                                <form>
                                    <?php if (boolval($form["collectEmail"])) { ?>
                                        <div class="form-row" data-extend="email">
                                            <div class="form-group col-md-12">
                                                <label for="<?php echo "collect-email-{$form["id"]}"; ?>">Адрес электронной почты<span class="text-danger">*</span>:</label>
                                                <input class="form-control" required="" type="email" id="<?php echo "collect-email-{$form["id"]}"; ?>" placeholder="Адрес электронной почты">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php foreach (json_decode(htmlspecialchars_decode($form["form"])) as $form_key => $form_value) {
                                        switch ($form_value -> type) {
                                            case "text": ?>
                                                <div class="form-row" data-extend="text">
                                                    <div class="form-group col-md-12">
                                                        <label for="<?php echo $form_value -> id; ?>"><?php echo $form_value -> label; echo $form_value -> required ? "<span class=\"text-danger\">*</span>" : ""; ?>:</label>
                                                        <input class="form-control" <?php echo $form_value -> required ? "required=\"\"" : ""; ?> type="<?php echo $form_value -> additional; ?>" id="<?php echo $form_value -> id; ?>" placeholder="<?php echo $form_value -> label; ?>">
                                                    </div>
                                                </div>
                                            <?php break;
                                            case "select": ?>
                                                <div class="form-row" data-extend="select">
                                                    <div class="form-group col-md-12">
                                                        <select class="custom-select" id="<?php echo $form_value -> id; ?>" <?php echo $form_value -> muliple ? "multiple=\"\"" : ""; echo $form_value -> required ? "required=\"\"" : ""; ?>>
                                                            <option selected="" disabled=""><?php echo $form_value -> label; ?></option>
                                                            <?php foreach ($form_value -> data as $data_key => $data_value) {
                                                                if ($data_value -> optgroup) { ?>
                                                                    <optgroup label="<?php echo $data_value -> value; ?>">
                                                                        <?php foreach ($data_value -> data as $opt_key => $opt_value) { ?>
                                                                            <option value="<?php echo "{$data_key}-{$opt_key}"; ?>"><?php echo $opt_value; ?></option>
                                                                        <?php } ?>
                                                                    </optgroup>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo "{$data_key}"; ?>"><?php echo $data_value -> value    ; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php break;
                                            case "radio": ?>
                                                <div class="form-row" data-extend="radio">
                                                    <?php foreach ($form_value as $radio_key => $radio_button) { ?>
                                                        <div class="form-group col-md-12">
                                                            <div class="custom-control custom-control-inline custom-radio">
                                                                <input type="radio" class="custom-control-input" id="<?php echo "{$form_value -> id}-radio-{$radio_key}"; ?>">
                                                                <label class="custom-control-label" for="<?php echo "{$form_value -> id}-radio-{$radio_key}"; ?>"><?php echo $radio_button; ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php break;
                                            case "checkbox": ?>
                                                <div class="form-row" data-extend="checkbox">
                                                    <div class="form-group col-md-12">
                                                        <div class="custom-control custom-control-inline custom-switch">
                                                            <input class="custom-control-input" type="checkbox" id="<?php echo $form_value -> id; ?>">
                                                            <label class="custom-control-label" for="<?php echo $form_value -> id; ?>"><?php echo $form_value -> label; echo $form_value -> required ? "<span class=\"text-danger\">*</span>" : ""; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                             <?php break;
                                        }
                                    } ?>
                                </form>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-primary btn-block send-form" data-id="<?php echo $form["id"]; ?>" type="button">Отправить данные</button>
                                    </div>
                                </div>
                                <p class="form-text">Нажимая кнопку "Отправить данные" вы автоматически даёте своё согласие на хранение и обработку персональных данных в порядке, установленном в образовательном учреждении в соответствии с Федеральным Законом № 152-ФЗ от 27 июля 2006 года.</p>
                            </div>
                            <?php $counter++;
                        }
                    } ?>
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
<script src="assets/js/index.js?<?php echo time(); ?>"></script>
</body>
</html>