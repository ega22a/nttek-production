    <div class="rounded-bottom border-left border-bottom border-right shadow-sm" style="padding: 25px;max-width: 1280px;margin: 0 15vw;background-color: #ffffff;">
        <h1>Настройка базы данных</h1>
        <p>Теперь нужно настроить подключение к базе данных. Подключение к базе данных организовано через библиотеку MySQLi (надстройка PHP). После успешного подключения к базе данных будут сгенерированны ключи шифрования Cookies, промежуточного шифрования
            данных и т.д.</p>
        <form class="needs-validation" novalidate>
            <h5>Данные подключенния к базе данных</h5>
            <div class="form-row row-md-12">
                <div class="form-group col-md-12"><label>Адрес расположения базы данных (по умолчанию - localhost)<span class="text-danger">*</span>:</label><input class="form-control" type="text" value="localhost" id="form-host"></div>
            </div>
            <div class="form-row row-md-12">
                <div class="col-md-6 form-group"><label for="form-login">Логин<span class="text-danger">*</span>:</label><input class="form-control" type="text" id="form-login" name="login" placeholder="Логин" required=""></div>
                <div class="col-md-6 form-group"><label for="form-password">Пароль<span class="text-danger">*</span>:</label>
                    <div class="input-group"><input class="form-control" type="text" id="form-password" required="" name="password" placeholder="Пароль">
                        <div class="input-group-append"><button class="btn btn-outline-dark" id="button-hs-pass" type="button" style="width: 50px;"><i class="far fa-eye-slash" id="i-b-password"></i></button></div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12"><label>Имя базы данных<span class="text-danger">*</span>:</label><input class="form-control" type="text" id="form-database-name" required="" name="database-name" placeholder="Например, collegeSystem"></div>
            </div>
        </form>
        <div class="form-row row-md-12" style="margin: 0px;"><button class="btn btn-primary btn-block" id="button-check-db" type="button">Проверить данные</button></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="/global-assets/js/jquery.mask.js"></script>
    <script src="assets/js/script.1.js"></script>
    <script src="assets/js/steps/3.js?<?php echo time(); ?>"></script>
</body>

</html>