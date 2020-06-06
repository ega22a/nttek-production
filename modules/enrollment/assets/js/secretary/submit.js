var enrolleeData = {};

document.getElementById("fulltime-form-mother-checkbox-not-working").onclick = function() {
    var jobName = document.getElementById("fulltime-form-mother-job-name"),
        jobPosition = document.getElementById("fulltime-form-mother-job-position"),
        jobTelephone = document.getElementById("fulltime-form-mother-job-telephone");
    if (this.checked) {
        jobName.value = "";
        jobPosition.value = "";
        jobTelephone.value = "";
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobTelephone.setAttribute("disabled", true);
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон:";
    } else {
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobTelephone.removeAttribute("disabled");
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
    }
}

document.getElementById("fulltime-form-mother-checkbox-do-not-have").onclick = function() {
    var firstname = document.getElementById("fulltime-form-mother-firstname"),
        lastname = document.getElementById("fulltime-form-mother-lastname"),
        patronymic = document.getElementById("fulltime-form-mother-patronymic"),
        telephone = document.getElementById("fulltime-form-mother-telephone"),
        jobName = document.getElementById("fulltime-form-mother-job-name"),
        jobPosition = document.getElementById("fulltime-form-mother-job-position"),
        jobTelephone = document.getElementById("fulltime-form-mother-job-telephone"),
        checkboxDontWork = document.getElementById("fulltime-form-mother-checkbox-not-working");
    if (this.checked) {
        checkboxDontWork.checked = false;
        checkboxDontWork.setAttribute("disabled", true);
        firstname.value = "";
        lastname.value = "";
        patronymic.value = "";
        telephone.value = "";
        jobName.value = "";
        jobPosition.value = "";
        jobTelephone.value = "";
        firstname.parentNode.children[0].innerHTML = "Имя:";
        lastname.parentNode.children[0].innerHTML = "Фамилия:";
        telephone.parentNode.children[0].innerHTML = "Контактный мобильный телефон:";
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон:";
        firstname.setAttribute("disabled", true);
        lastname.setAttribute("disabled", true);
        patronymic.setAttribute("disabled", true);
        telephone.setAttribute("disabled", true);
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobTelephone.setAttribute("disabled", true);
        firstname.removeAttribute("required");
        lastname.removeAttribute("required");
        telephone.removeAttribute("required");
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        if (document.getElementById("fulltime-form-father-checkbox-do-not-have").checked)
            $("#modal-representative").modal();
    } else {
        checkboxDontWork.removeAttribute("disabled");
        firstname.removeAttribute("disabled");
        lastname.removeAttribute("disabled");
        patronymic.removeAttribute("disabled");
        telephone.removeAttribute("disabled");
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobTelephone.removeAttribute("disabled");
        firstname.setAttribute("required", true);
        lastname.setAttribute("required", true);
        telephone.setAttribute("required", true);
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        firstname.parentNode.children[0].innerHTML = "Имя<span class=\"text-danger\">*</span>:";
        lastname.parentNode.children[0].innerHTML = "Фамилия<span class=\"text-danger\">*</span>:";
        telephone.parentNode.children[0].innerHTML = "Контактный мобильный телефон<span class=\"text-danger\">*</span>:";
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
    }
    if (this.checked && document.getElementById("fulltime-form-father-checkbox-do-not-have").checked) {
        document.getElementById("fulltime-form-representative-lastname").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-firstname").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-patronymic").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-job-name").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-job-position").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-job-telephone").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-telephone").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-who").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-checkbox-not-working").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-lastname").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-firstname").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-job-position").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-job-name").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-telephone").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-who").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-firstname").parentNode.children[0].innerHTML = "Имя<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-lastname").parentNode.children[0].innerHTML = "Фамилия<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-telephone").parentNode.children[0].innerHTML = "Контактный мобильный телефон<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-job-name").parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-job-position").parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-who").parentNode.children[0].innerHTML = "Кем приходится<span class=\"text-danger\">*</span>:";
    } else {
        document.getElementById("fulltime-form-representative-lastname").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-firstname").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-patronymic").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-job-name").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-job-position").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-job-telephone").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-telephone").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-who").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-checkbox-not-working").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-lastname").removeAttribute("required");
        document.getElementById("fulltime-form-representative-firstname").removeAttribute("required");
        document.getElementById("fulltime-form-representative-job-position").removeAttribute("required");
        document.getElementById("fulltime-form-representative-job-name").removeAttribute("required");
        document.getElementById("fulltime-form-representative-telephone").removeAttribute("required");
        document.getElementById("fulltime-form-representative-who").removeAttribute("required");
        document.getElementById("fulltime-form-representative-firstname").parentNode.children[0].innerHTML = "Имя:";
        document.getElementById("fulltime-form-representative-lastname").parentNode.children[0].innerHTML = "Фамилия:";
        document.getElementById("fulltime-form-representative-telephone").parentNode.children[0].innerHTML = "Контактный мобильный телефон:";
        document.getElementById("fulltime-form-representative-job-name").parentNode.children[0].innerHTML = "Место работы:";
        document.getElementById("fulltime-form-representative-job-position").parentNode.children[0].innerHTML = "Должность:";
        document.getElementById("fulltime-form-representative-job-telephone").parentNode.children[0].innerHTML = "Рабочий телефон:";
        document.getElementById("fulltime-form-representative-who").parentNode.children[0].innerHTML = "Кем приходится:";
        document.getElementById("fulltime-form-representative-checkbox-not-working").checked = false;
    }
}

document.getElementById("fulltime-form-father-checkbox-not-working").onclick = function() {
    var jobName = document.getElementById("fulltime-form-father-job-name"),
        jobPosition = document.getElementById("fulltime-form-father-job-position"),
        jobTelephone = document.getElementById("fulltime-form-father-job-telephone");
    if (this.checked) {
        jobName.value = "";
        jobPosition.value = "";
        jobTelephone.value = "";
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobTelephone.setAttribute("disabled", true);
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон:";
    } else {
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobTelephone.removeAttribute("disabled");
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
    }
}

document.getElementById("fulltime-form-father-checkbox-do-not-have").onclick = function() {
    var firstname = document.getElementById("fulltime-form-father-firstname"),
        lastname = document.getElementById("fulltime-form-father-lastname"),
        patronymic = document.getElementById("fulltime-form-father-patronymic"),
        telephone = document.getElementById("fulltime-form-father-telephone"),
        jobName = document.getElementById("fulltime-form-father-job-name"),
        jobPosition = document.getElementById("fulltime-form-father-job-position"),
        jobTelephone = document.getElementById("fulltime-form-father-job-telephone"),
        checkboxDontWork = document.getElementById("fulltime-form-father-checkbox-not-working");
    if (this.checked) {
        checkboxDontWork.checked = false;
        checkboxDontWork.setAttribute("disabled", true);
        firstname.value = "";
        lastname.value = "";
        patronymic.value = "";
        telephone.value = "";
        jobName.value = "";
        jobPosition.value = "";
        jobTelephone.value = "";
        firstname.parentNode.children[0].innerHTML = "Имя:";
        lastname.parentNode.children[0].innerHTML = "Фамилия:";
        telephone.parentNode.children[0].innerHTML = "Контактный мобильный телефон:";
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон:";
        firstname.setAttribute("disabled", true);
        lastname.setAttribute("disabled", true);
        patronymic.setAttribute("disabled", true);
        telephone.setAttribute("disabled", true);
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobTelephone.setAttribute("disabled", true);
        firstname.removeAttribute("required");
        lastname.removeAttribute("required");
        telephone.removeAttribute("required");
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        if (document.getElementById("fulltime-form-mother-checkbox-do-not-have").checked)
            $("#modal-representative").modal();
    } else {
        checkboxDontWork.removeAttribute("disabled");
        firstname.removeAttribute("disabled");
        lastname.removeAttribute("disabled");
        patronymic.removeAttribute("disabled");
        telephone.removeAttribute("disabled");
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobTelephone.removeAttribute("disabled");
        firstname.setAttribute("required", true);
        lastname.setAttribute("required", true);
        telephone.setAttribute("required", true);
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        firstname.parentNode.children[0].innerHTML = "Имя<span class=\"text-danger\">*</span>:";
        lastname.parentNode.children[0].innerHTML = "Фамилия<span class=\"text-danger\">*</span>:";
        telephone.parentNode.children[0].innerHTML = "Контактный мобильный телефон<span class=\"text-danger\">*</span>:";
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
    }
    if (this.checked && document.getElementById("fulltime-form-mother-checkbox-do-not-have").checked) {
        document.getElementById("fulltime-form-representative-lastname").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-firstname").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-patronymic").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-job-name").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-job-position").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-job-telephone").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-telephone").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-who").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-checkbox-not-working").removeAttribute("disabled");
        document.getElementById("fulltime-form-representative-lastname").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-firstname").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-job-position").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-job-name").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-telephone").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-who").setAttribute("required", true);
        document.getElementById("fulltime-form-representative-firstname").parentNode.children[0].innerHTML = "Имя<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-lastname").parentNode.children[0].innerHTML = "Фамилия<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-telephone").parentNode.children[0].innerHTML = "Контактный мобильный телефон<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-job-name").parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-job-position").parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-representative-who").parentNode.children[0].innerHTML = "Кем приходится<span class=\"text-danger\">*</span>:";
    } else {
        document.getElementById("fulltime-form-representative-lastname").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-firstname").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-patronymic").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-job-name").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-job-position").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-job-telephone").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-telephone").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-who").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-checkbox-not-working").setAttribute("disabled", true);
        document.getElementById("fulltime-form-representative-lastname").removeAttribute("required");
        document.getElementById("fulltime-form-representative-firstname").removeAttribute("required");
        document.getElementById("fulltime-form-representative-job-position").removeAttribute("required");
        document.getElementById("fulltime-form-representative-job-name").removeAttribute("required");
        document.getElementById("fulltime-form-representative-telephone").removeAttribute("required");
        document.getElementById("fulltime-form-representative-who").removeAttribute("required");
        document.getElementById("fulltime-form-representative-firstname").parentNode.children[0].innerHTML = "Имя:";
        document.getElementById("fulltime-form-representative-lastname").parentNode.children[0].innerHTML = "Фамилия:";
        document.getElementById("fulltime-form-representative-telephone").parentNode.children[0].innerHTML = "Контактный мобильный телефон:";
        document.getElementById("fulltime-form-representative-job-name").parentNode.children[0].innerHTML = "Место работы:";
        document.getElementById("fulltime-form-representative-job-position").parentNode.children[0].innerHTML = "Должность:";
        document.getElementById("fulltime-form-representative-who").parentNode.children[0].innerHTML = "Кем приходится:";
        document.getElementById("fulltime-form-representative-checkbox-not-working").checked = false;
    }
}

document.getElementById("fulltime-form-representative-checkbox-not-working").onclick = function() {
    var jobName = document.getElementById("fulltime-form-representative-job-name"),
        jobPosition = document.getElementById("fulltime-form-representative-job-position"),
        jobTelephone = document.getElementById("fulltime-form-representative-job-telephone");
    if (this.checked) {
        jobName.value = "";
        jobPosition.value = "";
        jobTelephone.value = "";
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobTelephone.setAttribute("disabled", true);
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон:";
    } else {
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobTelephone.removeAttribute("disabled");
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
    }
}

for (piece of $("input[type=text]"))
    piece.addEventListener("input", function() {
        if (this.value.length != 0)
            this.value = this.value[0].toUpperCase() + this.value.substring(1);
    });

document.getElementById("button-confirm-fulltime").onclick = function() {
    if (document.getElementById("fulltime-form").checkValidity()) {
        document.getElementById("fulltime-form").setAttribute("class", "validate");
        enrolleeData.type = "fulltime";
        var enrollee = new FormData();
        enrollee.set("token", Cookies.get("token"));
        for (item of $("#fulltime-form input, #fulltime-form select")) {
            var id = item.getAttribute("id").substring(14, item.getAttribute("id").length);
            switch (item.getAttribute("type")) {
                case "checkbox":
                    enrollee.set(id, item.checked);
                break;
                default:
                    enrollee.set(id, item.value);
                break;
            }
        }
        var _about = "";
        document.getElementById("fulltime-form-about").value.split("\n").forEach((item) => {
            _about += `${item} `;
        });
        enrollee.set("about", _about);
        $("#modal-statement-receipt").modal();
        $("#modal-spinner").modal();
        $.ajax({
            url: "../api/secretary/submit/save/fulltime",
            data: enrollee,
            processData: false,
            contentType: false,
            type: 'POST',
            success: (data) => {
                switch (data.status) {
                    case "OK":
                        $.post(
                            "../api/secretary/submit/statement",
                            {
                                "token": Cookies.get("token"),
                                "id": data.id,
                            },
                            (secData) => {
                                switch (secData.status) {
                                    case "OK":
                                        download(`data:application/pdf;base64,${secData.statement}`, "Заявление.pdf");
                                        enrolleeData.id = data.id;
                                        enrolleeData.statement = secData.statement;
                                    break;
                                    default:
                                        createAlert(`Ошибка в запросе к серверу: <b>${secData.status}</b>`);
                                    break;
                                }
                            }
                        );
                    break;
                    default:
                        createAlert(`Ошибка при обработке заявления. Побробнее: <b>${data.status}</b>.`);
                        console.log(data);
                    break;
                }
                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
            }
        });
    } else {
        document.getElementById("fulltime-form").setAttribute("class", "validate was-validated");
        createAlert("Внимание! Не все данные были заполнены! Перепровертье!");
    }
}

document.getElementById("button-confirm-extramural").onclick = function() {
    if (document.getElementById("extramural-form").checkValidity()) {
        document.getElementById("extramural-form").setAttribute("class", "validate");
        enrolleeData.type = "extramural";
        var enrollee = new FormData();
        enrollee.set("token", Cookies.get("token"));
        for (item of $("#extramural-form input, #extramural-form select")) {
            var id = item.getAttribute("id").substring(16, item.getAttribute("id").length);
            switch (item.getAttribute("type")) {
                case "checkbox":
                    enrollee.set(id, item.checked);
                break;
                default:
                    enrollee.set(id, item.value);
                break;
            }
        }
        var _about = "";
        document.getElementById("extramural-form-about").value.split("\n").forEach((item) => {
            _about += `${item} `;
        });
        enrollee.set("about", _about);
        $("#modal-statement-receipt").modal();
        $("#modal-spinner").modal();
        $.ajax({
            url: "../api/secretary/submit/save/extramural",
            data: enrollee,
            processData: false,
            contentType: false,
            type: 'POST',
            success: (data) => {
                switch (data.status) {
                    case "OK":
                        $.post(
                            "../api/secretary/submit/statement",
                            {
                                "token": Cookies.get("token"),
                                "id": data.id,
                            },
                            (secData) => {
                                switch (secData.status) {
                                    case "OK":
                                        download(`data:application/pdf;base64,${secData.statement}`, "Заявление.pdf");
                                        enrolleeData.id = data.id;
                                        enrolleeData.statement = secData.statement;
                                    break;
                                    default:
                                        createAlert(`Ошибка в запросе к серверу: <b>${secData.status}</b>`);
                                    break;
                                }
                            }
                        );
                    break;
                    default:
                        createAlert(`Ошибка при обработке заявления. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                        console.log(data);
                    break;
                }
                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
            }
        });
    } else {
        document.getElementById("extramural-form").setAttribute("class", "validate was-validated");
        createAlert("Внимание! Не все данные были заполнены! Перепровертье!");
    }
}

$(".reset-nav").click(function() {
    document.getElementById("fulltime-form").reset();
    document.getElementById("extramural-form").reset();
    document.getElementById("fulltime-form").setAttribute("class", "validate");
    document.getElementById("extramural-form").setAttribute("class", "validate");
});

document.getElementById("fulltime-form-hostel").addEventListener("change", function() {
    if (this.value == "true") {
        document.getElementById("fulltime-form-hostel-type").parentNode.children[0].innerHTML = "Тип комнаты<span class=\"text-danger\">*</span>:";
        document.getElementById("fulltime-form-hostel-type").setAttribute("required", true);
        document.getElementById("fulltime-form-hostel-type").removeAttribute("disabled");
    } else {
        document.getElementById("fulltime-form-hostel-type").parentNode.children[0].innerHTML = "Тип комнаты:";
        document.getElementById("fulltime-form-hostel-type").setAttribute("disabled", true);
        document.getElementById("fulltime-form-hostel-type").removeAttribute("required");
    }
});

document.getElementById("modal-s-r-button-error").onclick = function() {
    createConfirm("Вы уверены, что заявление некорректное?", () => {
        if (!$.isEmptyObject(enrolleeData))
            $.post(
                "../api/secretary/submit/delete",
                {
                    token: Cookies.get("token"),
                    id: enrolleeData.id,
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            createAlert("Данные удалены с сервера. Перепроверьте и отправьте ещё раз.");
                            $("#modal-statement-receipt").modal("hide");
                        break;
                        default:
                            createAlert(`Ошибка при обработке заявления. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                        break;
                    }
                }
            );
        else
            $("#modal-statement-receipt").modal("hide");
    });
}

document.getElementById("modal-s-r-button-next").onclick = function() {
    createConfirm("Вы уверены, что вы закончили работать с абитуриентом? Если да, то подтвердите.", () => {
        document.getElementById("fulltime-form").reset();
        document.getElementById("extramural-form").reset();
        document.getElementById("fulltime-form").setAttribute("class", "validate");
        document.getElementById("extramural-form").setAttribute("class", "validate");
        $("#modal-statement-receipt").modal("hide");
        enrolleeData = {};
    });
}

document.getElementById("modal-s-r-button-receipt").onclick = function() {
    createConfirm("Вы уверены, что Заявленое корректное? Если да, то продолжайте...", () => {
        $.post(
            "../api/secretary/submit/receipt",
            {
                token: Cookies.get("token"),
                id: enrolleeData.id,
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        download(`data:application/pdf;base64,${data.receipt}`, "Расписка.pdf");
                        if (data.hostel.length != 0)
                            download(`data:application/pdf;base64,${data.hostel}`, "Общежитие.pdf");
                        enrolleeData.receipt = data.receipt;
                        enrolleeData.hostel = data.hostel;
                        if (enrolleeData.type == "fulltime")
                            $("#modal-avarage-grade").modal();
                    break;
                    default:
                        createAlert(`Ошибка при обработке заявления. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
            }
        );
    });
}

document.getElementById("modal-text-input-average-grade").onkeypress = function(event) {
    if ("345".split("").indexOf(event.key) == -1)
        return false;
}

document.getElementById("modal-text-input-average-grade").onkeyup = function(event) {
    if (this.value.length != 0) {
        var _sum = 0;
        this.value.split("").forEach((grade) => {
            _sum += Number(grade);
        });
    document.getElementById("span-average-grade").innerHTML = (_sum / this.value.length).toFixed(2);
    }
}

document.getElementById("modal-avarage-grade-button").onclick = function() {
    if (document.getElementById("modal-text-input-average-grade").value.length != 0) {
        $.post(
            "../api/secretary/submit/grades",
            {
                token: Cookies.get("token"),
                id: enrolleeData.id,
                grades: document.getElementById("modal-text-input-average-grade").value,
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        createAlert("Оценка успешно занесена!");
                        $("#modal-avarage-grade").modal("hide");
                    break;
                    default:
                        createAlert(`Ошибка при обработке заявления. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
            }
        )
    } else
        createAlert("Для того, чтобы посчитать оценку, нужно ввести оценки!");
}
