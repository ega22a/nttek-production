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
        createConfirm(`Нажмите кнопку "Подтвердить", чтобы отправить Ваши данные в приемную комиссию. После успешной отправки всех данных на сервер, Вам придет письмо на адрес <b>${enrollee.get("email")}</b> в котором будут указаны дальнейшие действия.`, () => {
            $("#modal-spinner").modal();
            $.ajax({
                url: "api/submit/extramural",
                data: enrollee,
                processData: false,
                contentType: false,
                type: 'POST',
                success: (data) => {
                    console.log(data);
                    switch (data.status) {
                        case "OK":
                            createAlert("Данные успешно сохранены! Вам было отправлено сообщение на указанный адрес электронной почты!", "alert-success");
                        break;
                        case "ERRORS_IN_DB":
                            createAlert(`Произошла ошибка на сервере. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                        break;
                        case "ERRORS_IN_FILES":
                            createAlert(`Вы загружаете некорректные документы! Ознакомьтесь с условиями к документам!`, "alert-danger");
                        break;
                        case "HOSTEL_ROOM_IS_NOT_FOUND":
                            createAlert(`Выбранный тип комнаты не найден!`, "alert-danger");
                        break;
                        case "CATEGORY_OF_CITIZEN_IS_NOT_FOUND":
                            createAlert(`Категория гражданина не найдена!`, "alert-danger");
                        break;
                        case "LANGUAGE_IS_NOT_FOUND":
                            createAlert(`Иностранный язык не найден!`, "alert-danger");
                        break;
                        case "EDUCATIONAL_DOC_IS_NOT_FOUND":
                            createAlert(`Тип документа об образовании не найден!`, "alert-danger");
                        break;
                        case "EDUCATIONAL_LEVEL_IS_NOT_FOUND":
                            createAlert(`Уровень образования не найден!`, "alert-danger");
                        break;
                        case "TYPE_OF_PAY_CAN_ONLY_BY_1_OR_2":
                            createAlert(`Некорректный тип оплаты за обучение!`, "alert-danger");
                        break;
                        case "SPECIALTY_IS_NOT_FOUND":
                            createAlert(`Специальность не найдена!`, "alert-danger");
                        break;
                        case "SEX_CAN_ONLY_BE_1_OR_2":
                            createAlert(`Пол может быть только Мужским или Женским!`, "alert-danger");
                        break;
                        case "REQUIRED_FILES_ARE_EMPTY":
                            createAlert(`Некоторые обязательные документы не были загружены на сервер! Попробуйте ещё раз или позвоните в Приемную комиссию!`, "alert-danger");
                        break;
                        case "FILE_LIST_IS_EMPTY":
                            createAlert(`Сервер не получил от вас файлы! Если ошибка повторяется, позвоните в Приемную комиссию!`, "alert-danger");
                        break;
                        case "EMAIL_IS_HOLD":
                            createAlert(`На данный адрес электронной почты уже сформировано личное дело (или оно на рассмотрении)!`, "alert-danger");
                        break;
                        case "ERRORS_IN_DATA":
                            createAlert(`Ошибка в данных! ОБЯЗАТЕЛЬНО позвоните в Приемную комиссию и позовите системного администратора!`, "alert-danger");
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                        break;
                    }
                    setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
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

document.getElementById("form-checkbox-not-working").onclick = function() {
    var jobName = document.getElementById("form-job-name"),
        jobPosition = document.getElementById("form-job-position"),
        jobYears = document.getElementById("form-job-years");
    if (this.checked) {
        jobName.value = "";
        jobPosition.value = "";
        jobYears.value = "";
        jobName.setAttribute("disabled", true);
        jobPosition.setAttribute("disabled", true);
        jobYears.setAttribute("disabled", true);
        jobName.removeAttribute("required");
        jobPosition.removeAttribute("required");
        jobYears.removeAttribute("required");
        jobName.parentNode.children[0].innerHTML = "Место работы:";
        jobPosition.parentNode.children[0].innerHTML = "Должность:";
        jobYears.parentNode.children[0].innerHTML = "Стаж работы в отрасли:";
    } else {
        jobName.removeAttribute("disabled");
        jobPosition.removeAttribute("disabled");
        jobYears.removeAttribute("disabled");
        jobName.setAttribute("required", true);
        jobPosition.setAttribute("required", true);
        jobYears.setAttribute("required", true);
        jobName.parentNode.children[0].innerHTML = "Место работы<span class=\"text-danger\">*</span>:";
        jobPosition.parentNode.children[0].innerHTML = "Должность<span class=\"text-danger\">*</span>:";
        jobYears.parentNode.children[0].innerHTML = "Стаж работы в отрасли<span class=\"text-danger\">*</span>:";
    }
}

for (piece of $("input[type=text]"))
    piece.addEventListener("input", function() {
        if (this.value.length != 0)
            this.value = this.value[0].toUpperCase() + this.value.substring(1);
    });
