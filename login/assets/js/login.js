document.getElementById("form-button-login").onclick = () => {
    var login = document.getElementById("text-login").value,
        password = document.getElementById("text-password").value,
        form = document.getElementsByClassName("needs-validation")[0];
        if (form.checkValidity() === true) {
            form.classList.remove("was-validated");
            $.post(
                "api/login",
                {
                    login: login,
                    password: password,
                },
                (data) => {
                    switch (data.status) {
                        case "NEEDLE":
                            switch (data.message) {
                                case "PASSWORD_DO_NOT_MATCH":
                                    createAlert("Вы ввели неправильные логин или пароль!");
                                break;
                                case "USER_NOT_FOUND":
                                    createAlert("Пользователя с такими данными не существует!");
                                break;
                                default:
                                    Cookies.set("token", data.message, {expires: 365});
                                    location.href = "/";
                                break;
                            }
                        break;
                        case "SOME_DATA_IS_EMPTY":
                            createAlert("Сервер сообщил, что некоторые данные пришли пустыми. Отправтье данные ещё раз.");
                        break;
                    }
                }
            );
        } else
        form.classList.add("was-validated");
}

document.addEventListener("keyup", function(event){
    if (event.keyCode == 13)
        document.getElementById("form-button-login").click();
})