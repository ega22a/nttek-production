<div class="modal fade" role="dialog" tabindex="-1" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Проверка почты</h4></div>
                <div class="modal-body">
                    <form>
                        <div class="form-row" style="margin: 0px !important;">
                            <div class="form-group col-md-12">
                                <p>Введите проверочный код:</p>
                                <div class="form-row">
                                    <div class="form-group col-md-12"><input class="form-control once-number" type="number" id="mail-check-code"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" id="button-broke">Письмо не пришло...</button><button class="btn btn-primary" type="button" id="button-next-step">Продолжить</button></div>
            </div>
        </div>
    </div>
    <div class="rounded-bottom border-left border-bottom border-right shadow-sm" style="padding: 25px;max-width: 1280px;margin: 0 15vw;background-color: #ffffff;">
        <h1>Настройка электронной почты</h1>
        <p>Для полноценного функционирования информационной системы ей потребуется доступ к её личному адресу электронной почты, с которой система будет рассылать письма.</p>
        <p>Сервис электронной почты предоставляет библиотека PHPMailer (для ее функционирования нужна программа POSTFIX).</p>
        <form class="needs-validation" novalidate>
            <h5>Данные о электронной почте</h5>
            <div class="form-row" style="padding-bottom: 15px;margin: 0;"><label>Адрес и порт<span class="text-danger">*</span>:</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">ssl://</span></div><input class="form-control" type="text" required="" placeholder="Адрес SMTP-сервера" id="form-smtp-url">
                    <div class="input-group-append input-group-prepend"><span class="input-group-text">:</span></div><input class="form-control col-md-2" type="number" required="" placeholder="Порт" id="form-smtp-port"></div>
            </div>
            <div class="form-row row-md-12">
                <div class="col-md-6 form-group"><label for="form-login">Логин<span class="text-danger">*</span>:</label><input class="form-control" type="text" id="form-login" name="login" placeholder="Логин" required=""></div>
                <div class="col-md-6 form-group"><label for="form-password">Пароль<span class="text-danger">*</span>:</label>
                    <div class="input-group"><input class="form-control" type="text" id="form-password" required="" name="password" placeholder="Пароль">
                        <div class="input-group-append"><button class="btn btn-outline-dark" id="button-hs-pass" type="button" style="width: 50px;"><i class="far fa-eye-slash" id="i-b-password"></i></button></div>
                    </div>
                </div>
            </div>
        </form>
        <div class="form-row row-md-12" style="margin: 0px;"><button class="btn btn-primary btn-block" id="button-check-mail" type="button">Проверить данные</button></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="/global-assets/js/jquery.mask.js"></script>
    <script src="assets/js/script.1.js"></script>
    <script src="assets/js/steps/2.js?<?php echo time(); ?>"></script>
</body>

</html>