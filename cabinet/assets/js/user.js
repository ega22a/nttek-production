document.getElementById("user-new-email").onclick = function() {
    var input = this.parentNode.parentNode.children[0];
    if (input.value.length != 0) {
        this.parentNode.parentNode.parentNode.parentNode.parentNode.setAttribute("class", "validated");
        $.post(
            "api/user/edit",
            {
                token: Cookies.get("token"),
                type: "email",
                content: input.value,
            },
            (data) => {
                console.log(data);
                switch (data.status) {
                    case "OK":
                        createAlert("Адрес электронной почты успешно обновлен!", "alert-success");
                        document.getElementById("form-user-readonly-email").value = input.value;
                    break;
                }
            }
        )
    } else {
        this.parentNode.parentNode.parentNode.parentNode.parentNode.setAttribute("class", "validated was-validated");
        createAlert("Вы должны ввести адрес электронной почты, чтобы обновить его.");
    }
}

document.getElementById("user-new-telephone").onclick = function() {
    var input = this.parentNode.parentNode.children[0];
    if (input.value.length != 0) {
        this.parentNode.parentNode.parentNode.parentNode.parentNode.setAttribute("class", "validated");
        $.post(
            "api/user/edit",
            {
                token: Cookies.get("token"),
                type: "telephone",
                content: input.value,
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        createAlert("Номер мобильного телефона успешно обновлен", "alert-success");
                        document.getElementById("form-user-readonly-telephone").value = input.value;
                    break;
                }
            }
        );
    } else {
        this.parentNode.parentNode.parentNode.parentNode.parentNode.setAttribute("class", "validated was-validated");
        createAlert("Вы должны ввести номер мобильного телефона, чтобы обновить его.");
    }
}

document.getElementById("user-new-login").onclick = function() {
    var input = document.getElementById("form-user-edit-login").value,
        secondInput = document.getElementById("form-user-edit-login-second").value;
    if (input.length != 0 && secondInput.length != 0) {
        this.parentNode.setAttribute("class", "validate");
        if (input == secondInput) {
            $.post(
                "api/user/edit",
                {
                    token: Cookies.get("token"),
                    type: "login",
                    content: input,
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            createAlert("Логин успешно обновлен!", "alert-success");
                        break;
                        case "LOGIN_IS_NOT_UNIQUE":
                            createAlert("Введенный вами логин уже используется другим пользователем!");
                        break;
                    }
                }
            )
        } else
            createAlert("Введенные данные не совпадают!");
    } else {
        this.parentNode.setAttribute("class", "validate was-validated");
        createAlert("Для обновления аутентификационных данных нужно заполнить поля!")
    }
}

document.getElementById("user-new-password").onclick = function() {
    var input = document.getElementById("form-user-edit-password").value,
        secondInput = document.getElementById("form-user-edit-password-second").value;
    if (input.length != 0 && secondInput.length != 0) {
        this.parentNode.setAttribute("class", "validate");
        if (input == secondInput) {
            if (input.length > 8) {
                $.post(
                    "api/user/edit",
                    {
                        token: Cookies.get("token"),
                        type: "password",
                        content: input,
                    },
                    (data) => {
                        switch (data.status) {
                            case "OK":
                                createAlert("Пароль успешно изменен!", "alert-success");
                            break;
                            case "IS_TINY":
                                createAlert("Сервер получил пароль менее 8-ми символов!");
                            break;
                        }
                    }
                )
            } else
                createAlert("Пароль должен содержать не менее 8-ми символов!");
        } else
            createAlert("Введенные данные не совпадают!");
    } else {
        this.parentNode.setAttribute("class", "validate was-validated");
        createAlert("Для обновления аутентификационных данных нужно заполнить поля!")
    }
}
