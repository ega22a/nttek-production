document.getElementById("button-check-db").onclick = () => {
    var form = document.getElementsByClassName("needs-validation")[0];
    if (form.checkValidity() === true) {
        var dbHost = document.getElementById("form-host").value,
            dbLogin = document.getElementById("form-login").value,
            dbPassword = document.getElementById("form-password").value,
            dbLogin = document.getElementById("form-login").value,
            dbName = document.getElementById("form-database-name").value;
        $.post(
            "api/check-database",
            {
                host: dbHost,
                login: dbLogin,
                password: dbPassword,
                database: dbName
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        $.post(
                            "api/confirm",
                            {
                                admin: {
                                    login: localStorage.getItem("admin-login"),
                                    password: localStorage.getItem("admin-password"),
                                    firstname: localStorage.getItem("admin-firstname"),
                                    lastname: localStorage.getItem("admin-lastname"),
                                    patronymic: localStorage.getItem("admin-patronymic"),
                                    birthday: localStorage.getItem("admin-birthday"),
                                    email: localStorage.getItem("admin-email"),
                                    telephone: localStorage.getItem("admin-telephone")
                                },
                                email: {
                                    host: localStorage.getItem("mail-url"),
                                    port: localStorage.getItem("mail-port"),
                                    login: localStorage.getItem("mail-login"),
                                    password: localStorage.getItem("mail-password")
                                },
                                database: {
                                    host: dbHost,
                                    login: dbLogin,
                                    password: dbPassword,
                                    database: dbName,
                                }
                            },
                            (data) => {
                                switch (data.status) {
                                    case "OK":
                                        localStorage.clear();
                                        location.href = "/";
                                    break;
                                    case "FAILED_TO_CREATE_INI":
                                        createAlert("ВНИМАНИЕ! Сервер не может создать конфигурационные данные. Предоставьте необходимые разрешения серверу.", "alert-danger");
                                    break;
                                    case "SOME_DATA_IS_EMPTY":
                                        switch (data.nesting) {
                                            case 1:
                                                createAlert("Данные о администраторе, электронной почты или базе данных получены пустыми. Попробуйте ещё раз, очистив файлы сайта (в браузере).");
                                            break;
                                            case 2:
                                                createAlert("Внутренние данные получены пустыми. Попробуйте ещё раз, очистив файлы сайта (в браузере).");
                                            break;
                                        }
                                    break;
                                    case "ACCESS_DENIED":
                                        createAlert("Во приколист, а! Как ты сюда попал?", "alert-danger");
                                    break;
                                }
                            }
                        );
                    break;
                    case "CONNECT_ERROR":
                        createAlert(`Ошибка подключения к БД. Подробнее: ${data.message}.`, "alert-danger");
                    break;
                    case "SOME_DATA_IS_EMPTY":
                        createAlert("Сервер сообщил, что некоторые данные, переданные на сервер - пустые.");
                    break;
                    case "ACCESS_DENIED":
                        createAlert("Сервер сообщил, что вам отказано в доступе. А вы вообще как тут оказались???");
                    break;
                }
            }
        );
        form.classList.remove("was-validated");
    } else
        form.classList.add("was-validated");
}