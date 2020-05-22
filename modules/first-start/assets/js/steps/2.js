var code;
$("#mail-check-code").mask("000000");
document.getElementById("button-check-mail").onclick = () => {
    var form = document.getElementsByClassName("needs-validation")[0];
    if (form.checkValidity() === true) {
        form.classList.remove("was-validated");
        $.post(
            "api/check-mail",
            {
                host: document.getElementById("form-smtp-url").value,
                port: document.getElementById("form-smtp-port").value,
                login: document.getElementById("form-login").value,
                password: document.getElementById("form-password").value,
                to: localStorage.getItem("admin-email"),
            },
            (data) => {
                console.log(data);
                switch (data.status) {
                    case "OK":
                        $(".modal").modal("show");
                        code = data.code;
                    break;
                    case "ERROR":
                        createAlert(data.message, "alert-danger");
                    break;
                }
            }
        );
    } else
        form.classList.add("was-validated");
}
document.getElementById("button-next-step").onclick = () => {
    if (String(code) == document.getElementById("mail-check-code").value) {
        localStorage.setItem("mail-url", document.getElementById("form-smtp-url").value);
        localStorage.setItem("mail-port", document.getElementById("form-smtp-port").value);
        localStorage.setItem("mail-login", document.getElementById("form-login").value);
        localStorage.setItem("mail-password", document.getElementById("form-password").value);
        location.href = "?step=3";
    } else {
        createAlert("Код неверен. Попробуйте перепроверить код из письма.");
    }
}
document.getElementById("button-broke").onclick = () => {
    createAlert("Провертье ящик ещё раз. Возможно, что письмо попало в спам. Если письма нет, то попробуйте перезагрузить это окно и настроить подключение ещё раз. Если это сообщение вы видете не впервый раз, то советуем открыть багтрек на GitHub.");
}