var editableUser;

var buttonsHSPassword = document.getElementsByClassName("button-hs-pass"),
    divModulesSwitch = document.getElementsByClassName("admin-module-switch");

for (button of buttonsHSPassword)
    button.onclick = function() {
        var input = this.parentElement.parentElement.children[0],
            i = this.children[0];
        if (input.getAttribute("type") == "text") {
            input.setAttribute("type", "password");
            i.setAttribute("class", "far fa-eye");
        } else {
            input.setAttribute("type", "text");
            i.setAttribute("class", "far fa-eye-slash");
        }
    }

for (div of divModulesSwitch)
    div.onclick = function() {
        this.children[0].children[0].checked = !this.children[0].children[0].checked;
    }

document.getElementById("file-load-users").addEventListener("change", function(e) {
    if (this.files.length == 0)
        $("label[for='file-load-users']")[0].innerHTML = "Загрузить CSV...";
    else {
        if (this.files[0].type == "text/csv" || this.files[0].type == "application/vnd.ms-excel")
            $("label[for='file-load-users']")[0].innerHTML = this.files[0].name;
        else {
            createAlert("Вы должны загрузить только CSV-таблицу!");
            this.value = "";
            $("label[for='file-load-users']")[0].innerHTML = "Загрузить CSV...";
        }
    }
});

document.getElementById("admin-users-load-new").onclick = function() {
    var file = document.getElementById("file-load-users").files;
    if (file.length == 1) {
        var form = new FormData();
        form.append("users", file[0]);
        form.append("token", Cookies.get("token"));
        $("#modal-spinner").modal();
        $.ajax({
            url: "api/user/admin/registration",
            data: form,
            processData: false,
            contentType: false,
            type: 'POST',
            success: (data) => {
                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                console.log(data);
                switch (data.status) {
                    case "OK":
                        createAlert("Все пользователи успешно зарегестрированны. Перезагрузите страницу, чтобы увидеть новых пользователей.", "alert-success");
                    break;
                    case "SOME_USERS_ARE_NOT_REGISTERED":
                        var ul = document.createElement("ul");
                        createAlert("Некоторые пользователи не были зарегестрированы. Номера строк незарегестрированных пользователей отображены в форме. Обратите внимание, что ошибки не расшифрованы!");
                        data.list.forEach((value) => {
                            var li = document.createElement("li");
                            li.innerHTML = `Строка: <b>${value.line}</b>. Ошибка: <b>${value.error}</b>.`;
                            ul.appendChild(li);
                        });
                        document.getElementById("form-file-load-users-errors").appendChild(ul);
                    break;
                    case "SOME_DATA_IS_EMPTY":
                        createAlert("Серевер не получил CSV-таблицу или токен авторизации.", "alert-danger");
                    break;
                    case "ACCESS_DENIED":
                        createAlert("Доступ к этому методу API вам недоступен", "alert-danger");
                    break;
                    case "CSV_TABLE_EXPECTED":
                        createAlert("Ожидалась CSV-таблица (ответ сервера).", "alert-danger");
                    break;
                    case "FILE_DOES_NOT_OPENED":
                        createAlert("Сервер не смог открыть файл.", "alert-danger");
                    break;
                }
            }
        });
    } else
        createAlert("Для того, чтобы зарегестрировать пользователей, загрузите CSV-таблицу.");
}

document.getElementById("modal-load-user-dismiss").onclick = () => {
    document.getElementById("form-file-load-users-errors").innerHTML = "";
}

document.getElementById("form-users-edit-save").onclick = () => {
    var user = $(`#tr-user-${editableUser}`).data("json"),
        payload = {},
        thumbLevels = [];
    if (user.lastname != document.getElementById("form-users-edit-lastname").value)
        payload.lastname = document.getElementById("form-users-edit-lastname").value;
    if (user.firstname != document.getElementById("form-users-edit-firstname").value)
        payload.firstname = document.getElementById("form-users-edit-firstname").value;
    if (user.patronymic != document.getElementById("form-users-edit-patronymic").value)
        payload.patronymic = document.getElementById("form-users-edit-patronymic").value;
    if (user.birthday != document.getElementById("form-users-edit-birthday").value)
        payload.birthday = document.getElementById("form-users-edit-birthday").value;
    if (user.email != document.getElementById("form-users-edit-email").value)
        payload.email = document.getElementById("form-users-edit-email").value;
    if (user.telephone != document.getElementById("form-users-edit-telephone").value)
        payload.telephone = document.getElementById("form-users-edit-telephone").value;
    if (document.getElementById("form-users-edit-login").value.length != 0)
        payload.login = document.getElementById("form-users-edit-login").value;
    if (document.getElementById("form-users-edit-password").value.length != 0)
        payload.password = document.getElementById("form-users-edit-password").value;
    for (elem of document.getElementById("form-users-edit-levels").children)
        if (elem.selected)
            thumbLevels.push($(elem).data["vanilla"]);
    if (user.levels.filter(i => !thumbLevels.includes(i)).concat(thumbLevels.filter(i => !user.levels.includes(i))).length != 0 && user.id != 1)
        payload.levels = thumbLevels;
    $.post(
        "api/user/admin/edit",
        {
            token: Cookies.get("token"),
            id: user.id,
            data: JSON.stringify(payload),
        },
        (data) => {
            console.log(data);
            switch (data.status) {
                case "SOME_DATA_IS_EMPTY":
                    createAlert("Сервер не получил ответа некоторые данные!", "alert-danger");
                break;
                case "ADMIN_IS_NOT_FOUND":
                    createAlert("У вас нет привелегий изменять персональные данные!", "alert-danger");
                break;
                case "LOGIN_IS_NOT_UNIQUE":
                    createAlert("Выбранный вами логин - не уникальный.");
                break;
                case "PASSWORD_IS_TINY":
                    createAlert("Пароль короткий. Минимальная длина пароля - 8 символов.");
                break;
                case "LEVELS_MUST_BE_ARRAY":
                    createAlert("Массив уровней передался неправильным форматом", "alert-danger");
                break;
                case "USER_IS_NOT_FOUND":
                    createAlert("Пользователь, которому вы пытаетесь изменить данные, не найден.", "alert-danger");
                break;
                case "OK":
                    createAlert("Данные успешно обновлены! Страница перезагрузится через несколько секунд.", "alert-success");
                    setTimeout(() => { location.reload(); }, 3000);
                break;
            }
        }
    );
}

$(".admin-user-edit").click(function() {
    var user = $(`#tr-user-${$(this).data("id")}`).data("json");
    editableUser = $(this).data("id");
    document.getElementById("form-users-edit-lastname").value = user.lastname;
    document.getElementById("form-users-edit-firstname").value = user.firstname;
    document.getElementById("form-users-edit-patronymic").value = user.patronymic;
    document.getElementById("form-users-edit-birthday").value = user.birthday;
    document.getElementById("form-users-edit-email").value = user.email;
    document.getElementById("form-users-edit-telephone").value = user.telephone;
    if (editableUser == 0)
        $("#form-users-edit-levels > option").attr("disabled", true);
    else
        user.levels.forEach((value) => {
            $(`#form-users-edit-levels > [data-vanilla='${value}']`).attr("selected", true);
        });
    $("#modal-edit-user").modal();
});

document.getElementById("modal-admin-user-edit-dismiss").onclick = () => {
    editableUser = -1;
    document.getElementById("form-users-edit-lastname").value = "";
    document.getElementById("form-users-edit-firstname").value = "";
    document.getElementById("form-users-edit-patronymic").value = "";
    document.getElementById("form-users-edit-birthday").value = "";
    document.getElementById("form-users-edit-email").value = "";
    document.getElementById("form-users-edit-telephone").value = "";
    document.getElementById("form-users-edit-login").value = "";
    document.getElementById("form-users-edit-password").value = "";
    $("#form-users-edit-levels > option").removeAttr("selected");
    $("#form-users-edit-levels > option").removeAttr("disabled");
}

$(".admin-user-delete").click(function() {
    var id = $(this).data("id"),
        user = $(`#tr-user-${$(this).data("id")}`).data("json");
    createConfirm(
        `Вы уверены, что хотите удалить пользователя с именем ${user.lastname} ${user.firstname} ${user.patronymic}?`,
        function() {
            $.post(
                "api/user/admin/delete",
                {
                    token: Cookies.get("token"),
                    id: user.id,
                },
                (data) => {
                    if (data.status === true) {
                        document.getElementById(`tr-user-${id}`).remove();
                    }
                }
            )
        },
    );
});

document.getElementById("form-admin-users-search").onkeyup = function() {
    var list = document.getElementById("users-tbody").children;
    if (this.value.length == 0)
        for (piece of list)
            piece.setAttribute("style", "");
    else
        for (piece of list) {
            if (piece.innerText.toLowerCase().indexOf(this.value.toLowerCase()) != -1)
                piece.setAttribute("style", "");
            else
                piece.setAttribute("style", "display: none;");
        }
}

document.getElementById("admin-smtp-button").onclick = function() {
    var host = document.getElementById("form-admin-smtp-address").value,
        port = document.getElementById("form-admin-smtp-port").value,
        login = document.getElementById("form-admin-smtp-login").value,
        password = document.getElementById("form-admin-smtp-password").value,
        form = this.parentNode.parentNode;
    if (host.length != 0 && port.length != 0 && login.length != 0 && password.length != 0) {
        createConfirm("Вы <b>УВЕРЕНЫ</b>, что хотите изменить конфигурационных файл подключения к сервису рассылки электронных писем? В случае неудачи система не сможет отправлять письма!!!", () => {
            $.post(
                "api/edit-config",
                {
                    token: Cookies.get("token"),
                    type: "email",
                    data: JSON.stringify({
                        host: host,
                        port: port,
                        login: login,
                        password: password,
                    }),
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            createAlert("Конфигурационные данные электронной почты успешно изменены!");
                        break;
                        case "SOME_DATA_IS_EMPTY":
                            createAlert("Сервер получил неполные данные!", "alert-danger");
                        break;
                        case "ADMIN_IS_NOT_FOUND":
                            createAlert("У вас нет привилегий изменять этот блок!", "alert-danger");
                        break;
                        case "INVALID_JSON_TYPE":
                            createAlert("Невалидный тип JSON-данных!", "alert-danger");
                        break;
                        case "JSON_DATA_ARE_NOT_FULL":
                            createAlert("В JSON-объекте не хватает данных!", "alert-danger");
                        break;
                    }
                }
            );
        });
    } else {
        form.setAttribute("class", "validate was-validated");
        createAlert("Все поля должны быть заполнены!");
    }
}

document.getElementById("admin-database-button").onclick = function() {
    var host = document.getElementById("form-admin-database-address").value,
        login = document.getElementById("form-admin-database-login").value,
        password = document.getElementById("form-admin-database-password").value,
        name = document.getElementById("form-admin-database-name").value,
        form = this.parentNode.parentNode;
    if (host.length != 0 && name.length != 0 && login.length != 0 && password.length != 0) {
        createConfirm("Вы <b>УВЕРЕНЫ</b>, что хотите изменить конфигурационных файл подключения к базе данных? В случае неудачи система будет недоступна!!!", () => {
            $.post(
                "api/edit-config",
                {
                    token: Cookies.get("token"),
                    type: "database",
                    data: JSON.stringify({
                        host: host,
                        login: login,
                        password: password,
                        name: name,
                    }),
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            createAlert("");
                        break;
                        case "SOME_DATA_IS_EMPTY":
                            createAlert("Сервер получил неполные данные!", "alert-danger");
                        break;
                        case "ADMIN_IS_NOT_FOUND":
                            createAlert("У вас нет привилегий изменять этот блок!", "alert-danger");
                        break;
                        case "INVALID_JSON_TYPE":
                            createAlert("Невалидный тип JSON-данных!", "alert-danger");
                        break;
                        case "JSON_DATA_ARE_NOT_FULL":
                            createAlert("В JSON-объекте не хватает данных!", "alert-danger");
                        break;
                    }
                }
            );
        });
    } else {
        form.setAttribute("class", "validate was-validated");
        createAlert("Все поля должны быть заполнены!");
    }
}
