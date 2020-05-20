<div class="rounded-bottom border-left border-bottom border-right shadow-sm" style="padding: 25px;max-width: 1280px;margin: 0 15vw;background-color: #ffffff;">
        <h1>Первый запуск</h1>
        <p>Похоже, что вы запустили систему в первый раз. Вам нужно приступить к настройке информационной системы.&nbsp;</p>
        <p>Сперва нужно представиться системе для продолжения работы.</p>
        <form class="needs-validation" novalidate>
            <h5>Данные о администраторе системы</h5>
            <div class="form-row row-md-12">
                <div class="col-md-4 form-group"><label for="form-lastname">Фамилия<span class="text-danger">*</span>:</label><input class="form-control" type="text" id="form-lastname" name="lastname" placeholder="Фамилия" required></div>
                <div class="col-md-4 form-group"><label for="form-firstname">Имя<span class="text-danger">*</span>:</label><input class="form-control" type="text" id="form-firstname" name="firstname" placeholder="Имя" required></div>
                <div class="col-md-4 form-group"><label for="form-patronymic">Отчество (при наличии):</label><input class="form-control" type="text" id="form-patronymic" name="patronymic" placeholder="Отчество"></div>
            </div>
            <div class="form-row row-md-12">
                <div class="col-md-4 form-group"><label for="form-birthday">Дата рождения<span class="text-danger">*</span>:</label><input class="form-control" id="form-birthday" required="" type="date"></div>
                <div class="col-md-4 form-group"><label for="form-email">Электронная почта<span class="text-danger">*</span>:</label><input class="form-control" type="email" id="form-email" required="" name="email" placeholder="admin@example.com"></div>
                <div class="col-md-4 form-group"><label for="form-telephone">Номер телефона<span class="text-danger">*</span>:</label><input class="form-control" type="text" id="form-telephone" name="telephone" placeholder="+7 (000) 000 00-00" required></div>
            </div>
            <hr>
            <h5>Аутентификационные данные администратора</h5>
            <div class="form-row row-md-12">
                <div class="col-md-6 form-group"><label for="form-login">Логин<span class="text-danger">*</span>:</label><input class="form-control" type="text" id="form-login" name="login" placeholder="Логин" required=""></div>
                <div class="col-md-6 form-group"><label for="form-password">Пароль<span class="text-danger">*</span>:</label>
                    <div class="input-group"><input class="form-control" type="text" id="form-password" name="password" placeholder="Пароль" required="">
                        <div class="input-group-append"><button class="btn btn-outline-dark" id="button-hs-pass" type="button" style="width: 50px;"><i class="far fa-eye-slash" id="i-b-password"></i></button></div>
                    </div>
                </div>
            </div>
            <div class="form-row row-md-12" style="margin: 0px;"><button class="btn btn-primary btn-block" id="button-generate" type="button">Сгенерировать аутентификационные данные</button></div>
        </form>
        <hr>
        <div class="form-row row-md-12" style="margin: 0px;"><button class="btn btn-primary btn-block" type="button" id="button-next">Продолжить настройку...</button></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="/global-assets/js/jquery.mask.js"></script>
    <script src="assets/js/script.0.js"></script>
    <script src="assets/js/script.1.js"></script>
    <script src="assets/js/steps/1.js"></script>
</body>

</html>