var representative = false;

document.getElementById("form-mother-checkbox-not-working").onclick = function() {
    var jobName = document.getElementById("form-mother-job-name"),
        jobPosition = document.getElementById("form-mother-job-position"),
        jobTelephone = document.getElementById("form-mother-job-telephone");
    if (this.checked) {
        jobName.value = "";
        jobPosition.value = "";
        jobTelephone.value = "";
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobTelephone.setAttribute("disabled", true);
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        jobTelephone.removeAttribute("required");
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон:";
    } else {
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobTelephone.removeAttribute("disabled");
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        jobTelephone.setAttribute("required", true);
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон<span class=\"text-danger\">*</span>:";
    }
}

document.getElementById("form-mother-checkbox-do-not-have").onclick = function() {
    var firstname = document.getElementById("form-mother-firstname"),
        lastname = document.getElementById("form-mother-lastname"),
        patronymic = document.getElementById("form-mother-patronymic"),
        telephone = document.getElementById("form-mother-telephone"),
        jobName = document.getElementById("form-mother-job-name"),
        jobPosition = document.getElementById("form-mother-job-position"),
        jobTelephone = document.getElementById("form-mother-job-telephone"),
        checkboxDontWork = document.getElementById("form-mother-checkbox-not-working");
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
        jobTelephone.removeAttribute("required");
        if (document.getElementById("form-father-checkbox-do-not-have").checked)
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
        jobTelephone.setAttribute("required", true);
        firstname.parentNode.children[0].innerHTML = "Имя<span class=\"text-danger\">*</span>:";
        lastname.parentNode.children[0].innerHTML = "Фамилия<span class=\"text-danger\">*</span>:";
        telephone.parentNode.children[0].innerHTML = "Контактный мобильный телефон<span class=\"text-danger\">*</span>:";
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон<span class=\"text-danger\">*</span>:";
        document.getElementById("form-representative-firstname").value = "";
        document.getElementById("form-representative-lastname").value = "";
        document.getElementById("form-representative-patronymic").value = "";
        document.getElementById("form-representative-job-name").value = "";
        document.getElementById("form-representative-job-position").value = "";
        document.getElementById("form-representative-job-telephone").value = "";
        document.getElementById("form-representative-who").value = "";
    }
}

document.getElementById("form-father-checkbox-not-working").onclick = function() {
    var jobName = document.getElementById("form-father-job-name"),
        jobPosition = document.getElementById("form-father-job-position"),
        jobTelephone = document.getElementById("form-father-job-telephone");
    if (this.checked) {
        jobName.value = "";
        jobPosition.value = "";
        jobTelephone.value = "";
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobTelephone.setAttribute("disabled", true);
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        jobTelephone.removeAttribute("required");
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон:";
    } else {
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobTelephone.removeAttribute("disabled");
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        jobTelephone.setAttribute("required", true);
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон<span class=\"text-danger\">*</span>:";
    }
}

document.getElementById("form-father-checkbox-do-not-have").onclick = function() {
    var firstname = document.getElementById("form-father-firstname"),
        lastname = document.getElementById("form-father-lastname"),
        patronymic = document.getElementById("form-father-patronymic"),
        telephone = document.getElementById("form-father-telephone"),
        jobName = document.getElementById("form-father-job-name"),
        jobPosition = document.getElementById("form-father-job-position"),
        jobTelephone = document.getElementById("form-father-job-telephone"),
        checkboxDontWork = document.getElementById("form-father-checkbox-not-working");
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
        jobTelephone.removeAttribute("required");
        if (document.getElementById("form-mother-checkbox-do-not-have").checked)
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
        jobTelephone.setAttribute("required", true);
        firstname.parentNode.children[0].innerHTML = "Имя<span class=\"text-danger\">*</span>:";
        lastname.parentNode.children[0].innerHTML = "Фамилия<span class=\"text-danger\">*</span>:";
        telephone.parentNode.children[0].innerHTML = "Контактный мобильный телефон<span class=\"text-danger\">*</span>:";
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон<span class=\"text-danger\">*</span>:";
        document.getElementById("form-representative-firstname").value = "";
        document.getElementById("form-representative-lastname").value = "";
        document.getElementById("form-representative-patronymic").value = "";
        document.getElementById("form-representative-job-name").value = "";
        document.getElementById("form-representative-job-position").value = "";
        document.getElementById("form-representative-job-telephone").value = "";
        document.getElementById("form-representative-who").value = "";
    }
}

document.getElementById("form-representative-checkbox-not-working").onclick = function() {
    var jobName = document.getElementById("form-representative-job-name"),
        jobPosition = document.getElementById("form-representative-job-position"),
        jobTelephone = document.getElementById("form-representative-job-telephone");
    if (this.checked) {
        jobName.value = "";
        jobPosition.value = "";
        jobTelephone.value = "";
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobTelephone.setAttribute("disabled", true);
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        jobTelephone.removeAttribute("required");
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон:";
    } else {
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobTelephone.removeAttribute("disabled");
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        jobTelephone.setAttribute("required", true);
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
        jobTelephone.parentNode.children[0].innerHTML = "Рабочий телефон<span class=\"text-danger\">*</span>:";
    }
}

$('#modal-representative').on('hide.bs.modal', function () {
    if (!representative) {
        document.getElementById("form-representative-firstname").value = "";
        document.getElementById("form-representative-lastname").value = "";
        document.getElementById("form-representative-patronymic").value = "";
        document.getElementById("form-representative-job-name").value = "";
        document.getElementById("form-representative-job-position").value = "";
        document.getElementById("form-representative-job-telephone").value = "";
        document.getElementById("form-representative-who").value = "";
        document.getElementById("form-mother-checkbox-do-not-have").click();
        document.getElementById("form-father-checkbox-do-not-have").click();
    }
});

document.getElementById("submit-docs").onclick = function() {
    createConfirm("Со всеми документами ознакомились? Продолжая работу с формой, вы автоматически даёте своё соглсие на обработку и хранение персональных данных!", () => {
        document.getElementById("div-first-step").setAttribute("style", "display: none;");
        document.getElementById("div-second-step").setAttribute("style", "display: block;");
    });
}

document.getElementById("button-confirm").onclick = function() {
    var form = document.getElementById("form-global");
    if (form.checkValidity()) {
        form.setAttribute("class", "");
        var enrollee = new FormData();
        for (item of $("form input, form select")) {
            var id = item.getAttribute("id").substring(5, item.getAttribute("id").length);
            switch (item.getAttribute("type")) {
                case "checkbox":
                    enrollee.set(id, item.checked);
                break;
                case "file":
                    var counter = 0;
                    for (f of item.files) {
                        enrollee.set(`${id}-counter-${counter}`, f);
                        counter++;
                    }
                break;
                default:
                    enrollee.set(id, item.value);
                break;
            }
        }
        var _about = "";
        document.getElementById("form-about").value.split("\n").forEach((item) => {
            _about += `${item} `;
        });
        enrollee.set("about", _about);
        createConfirm(`Нажмите кнопку "Подтвердить", чтобы отправить Ваши данные в приемную комиссию. После успешной отправки всех данных на сервер, Вам придет письмо на адрес <b>${enrollee.get("email")}</b> в котором будут указаны дальнейшие действия.`, () => {
            $("#modal-spinner").modal();
            $.ajax({
                url: "api/submit/fulltime",
                data: enrollee,
                processData: false,
                contentType: false,
                type: 'POST',
                success: (data) => {
                    switch (data.status) {
                        case "OK":
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                            createAlert("Данные успешно сохранены! Вам было отправлено сообщение на указанный адрес электронной почты!", "alert-success");
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                        break;
                    }
                }
            });
        });
    } else {
        form.setAttribute("class", "validate was-validated");
        createAlert("Не все данные были заполнены. Пожалуйста, перепровертье форму.");
    }
}

var _files = document.getElementsByClassName("documents-input");

for (item of _files)
    item.addEventListener("change", function() {
        if (this.files.length == 0)
            $(`label[for="${this.getAttribute("id")}"]`)[0].innerHTML = "Загрузите документы...";
        else {
            var name = "",
                granted = true;
            for (piece of this.files) {
                if (piece.type == "application/pdf" || piece.type == "image/png" || piece.type == "image/jpg" || piece.type == "image/jpeg")
                    name += piece.name + "; ";
                else
                    granted = false;
            }
            if (granted)
                $(`label[for="${this.getAttribute("id")}"]`)[0].innerHTML = name.substring(0, name.length - 2);
            else {
                createAlert("Вы загрузили неправильный формат файла! К загрузке принимаются файлы с форматом: PDF, PNG, JPG и JPEG.");
                this.value = "";
                $(`label[for="${this.getAttribute("id")}"]`)[0].innerHTML = "Загрузите документы...";
            }
        }
    })

document.getElementById("form-hostel").addEventListener("change", function() {
    if (this.value == "true") {
        document.getElementById("form-hostel-type").parentNode.children[0].innerHTML = "Тип комнаты<span class=\"text-danger\">*</span>:";
        document.getElementById("form-hostel-type").setAttribute("required", true);
        document.getElementById("form-hostel-type").removeAttribute("disabled");
    } else {
        document.getElementById("form-hostel-type").parentNode.children[0].innerHTML = "Тип комнаты:";
        document.getElementById("form-hostel-type").setAttribute("disabled", true);
        document.getElementById("form-hostel-type").removeAttribute("required");
    }
});

for (piece of $("input[type=text]"))
    piece.addEventListener("input", function() {
        if (this.value.length != 0)
            this.value = this.value[0].toUpperCase() + this.value.substring(1);
    });

document.getElementById("representative-button").onclick = function() {
    if (document.getElementById("representative-form").checkValidity()) {
        document.getElementById("representative-form").setAttribute("class", "validate");
        representative = true;
        $("#modal-representative").modal("hide");
    } else {
        document.getElementById("representative-form").setAttribute("class", "validate was-validated");
        representative = false;
    }
}
