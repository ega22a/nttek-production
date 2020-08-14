enrollee.data = {};
enrollee.attachedDocs = {};

for (item of $("#form input, #form select, #form textarea"))
    switch (item.getAttribute("type")) {
        case "textarea":
            var _about = "";
            item.value.split("\n").forEach((subItem) => {
                _about += `${subItem} `;
            });
            enrollee.data[item.getAttribute("id")] = _about;
        break;
        default:
            enrollee.data[item.getAttribute("id")] = item.value;
        break;
    }
enrollee.specialty = document.getElementById("form-enrollee-specialty").value;
for (item of $("#attached-docs-list-group input[type=checkbox]"))
    enrollee.attachedDocs[item.getAttribute("id")] = item.checked;

document.getElementById("button-personal-data-save").onclick = function() {
    var counter = 0,
        objCounter = 0;
    for (item of $("#form input, #form select, #form textarea")) {
        var _tempString = "";
        if (item.getAttribute("type") == "textarea") {
            var _about = "";
            item.value.split("\n").forEach((subItem) => {
                _about += `${subItem} `;
            });
            _tempString = _about;
        } else
            _tempString = item.value;
        if (_tempString == enrollee.data[item.getAttribute("id")])
            counter++;
        objCounter++;
    }
    if (counter != objCounter)
        createConfirm("Вы уверены, что хотите сохранить изменения? Если заявление было подано онлайн, то скан предыдущего заявления удалится, а также скан заявления на общежитие.", () => {
            $("#modal-spinner").modal();
            var sender = new FormData();
            sender.set("token", Cookies.get("token"));
            sender.set("statement", enrollee.id);
            for (item of $("#form input, #form select, #form textarea")) {
                var _tempString = "";
                if (item.getAttribute("type") == "textarea") {
                    var _about = "";
                    item.value.split("\n").forEach((subItem) => {
                        _about += `${subItem} `;
                    });
                    _tempString = _about;
                } else
                    _tempString = item.value;
                if (_tempString != enrollee.data[item.getAttribute("id")])
                    sender.set(item.getAttribute("id").substring(5), _tempString);
            }
            $.ajax({
                url: "../api/secretary/s-edit/personal",
                data: sender,
                processData: false,
                contentType: false,
                type: 'POST',
                success: (data) => {
                    console.log(data);
                    switch (data.status) {
                        case "OK":
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                            createAlert("Данные успешно сохранены! Для получения нового заявления и расписки, перейдите на страницу \"Управление принятыми заявлениями\" и получите архив документов.", "alert-success");
                            for (item of $("#form input, #form select, #form textarea"))
                                switch (item.getAttribute("type")) {
                                    case "textarea":
                                        var _about = "";
                                        item.value.split("\n").forEach((subItem) => {
                                            _about += `${subItem} `;
                                        });
                                        enrollee.data[item.getAttribute("id")] = _about;
                                    break;
                                    default:
                                        enrollee.data[item.getAttribute("id")] = item.value;
                                    break;
                                }
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Данные не обновлены. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                        break;
                    }
                }
            });
        });
    else {
        createAlert("Вы не внесли никаких изменений.");
    }
}
document.getElementById("button-specialty-save").onclick = function() {
    var specialty = document.getElementById("form-enrollee-specialty").value;
    if (specialty != enrollee.specialty)
        createConfirm("Вы уверены, что хотите изменить специальность? Если вы это сделаете, то приложенный скан заявления (если заявление было подано онлайн) будет удален. Если заявление было подано онлайн, то новый бланк придет абитуриенту на электронную почту. Система сгенерирует новый номер личного дела. Также, после нажатия на кнопку \"Подтвердить\" автоматически скачаются необходимые документы.", () => {
            $("#modal-spinner").modal();
            $.post(
                "../api/secretary/s-edit/specialty",
                {
                    token: Cookies.get("token"),
                    specialty: specialty,
                    statement: enrollee.id,
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            createAlert("Данные успешно сохранены!", "alert-success");
                            download(`data:application/pdf;base64,${data.statement}`, `Заявление.pdf`, "application/pdf");
                            download(`data:application/pdf;base64,${data.receipt}`, `Расписка.pdf`, "application/pdf");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Данные не обновлены. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                        break;
                    }
                }
            )
        });
    else
        createAlert("Невозможно применить изменения, т.к. изменений нет.");
}

document.getElementById("button-attached-docs-save").onclick = function() {
    var counter = 0,
        mainCounter = 0,
        filesTrigger = false;
    for (item of $("#attached-docs-list-group input[type=checkbox]")) {
        if (item.checked == enrollee.attachedDocs[item.getAttribute("id")])
            counter++;
        mainCounter++;
    }
    for (item of $("#attached-docs-list-group input[type=file]"))
        if (item.files.length != 0)
            filesTrigger = true;
    if (counter != mainCounter || filesTrigger)
        createConfirm("Вы уверены, что хотите изменить список прилагаемых документов? Если да, то имейте ввиду, что те документы, которые вы отметили как непринятые, автоматически удалятся из системы (если абитуриент подал документы онлайн). Те документы, которые вы загрузили, будут заменять те документы, которые уже загруженны.", () => {
            var sender = new FormData();
            sender.set("token", Cookies.get("token"));
            sender.set("statement", enrollee.id);
            $("#modal-spinner").modal();
            for (item of $("#attached-docs-list-group input[type=checkbox]")) {
                if (item.checked) {
                        var counter = 0;
                        if (document.getElementById(`file-${item.getAttribute("id").substring(9)}`) != null)
                            for (file of document.getElementById(`file-${item.getAttribute("id").substring(9)}`).files) {
                                sender.set(`file-${item.getAttribute("id").substring(9)}-counter-${counter}`, file);
                                counter++;
                            }
                }
                sender.set(item.getAttribute("id"), item.checked);
            }
            $.ajax({
                url: "../api/secretary/s-edit/attached-docs",
                data: sender,
                processData: false,
                contentType: false,
                type: 'POST',
                success: (data) => {
                    console.log(data);
                    switch (data.status) {
                        case "OK":
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                            createAlert("Данные успешно сохранены! Для получения нового заявления и расписки, перейдите на страницу \"Управление принятыми заявлениями\" и получите архив документов.", "alert-success");
                            for (item of $("#attached-docs-list-group input[type=checkbox]"))
                                enrollee.attachedDocs[item.getAttribute("id")] = item.checked;
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Данные не обновлены. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                        break;
                    }
                }
            });
        });
    else
        createAlert("Невозможно изменить список прилагаемых документов, т.к. он пуст.");
}

if (enrollee.type == "fulltime") {
    enrollee.hostel = {
        checked: document.getElementById("checkbox-hostel-open").checked,
    }
    if (enrollee.hostel.checked)
        enrollee.hostel.type = document.getElementById("form-select-hostel-type").value;
    document.getElementById("button-hostel-save").onclick = function() {
        if (document.getElementById("checkbox-hostel-open").checked != enrollee.hostel.checked || (document.getElementById("checkbox-hostel-open").checked && (enrollee.hostel.type != document.getElementById("form-select-hostel-type").value)))
            createConfirm("Вы уверены, что хотите изменить статус зявления на общежитие? Если меняется тип комнаты, то приложеное заявление (если документы были поданы онлайн-формой) будет удалено. Номер заявления не изменится. Если абитуриент отказывается от заявления, то номер будет очищен.", () => {
                $("#modal-spinner").modal();
                 $.post(
                     "../api/secretary/s-edit/hostel",
                     {
                         checked: document.getElementById("checkbox-hostel-open").checked,
                         type: document.getElementById("form-select-hostel-type").value,
                         token: Cookies.get("token"),
                         statement: enrollee.id,
                     },
                     (data) => {
                         switch (data.status) {
                             case "OK":
                                 setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                                 createAlert("Данные успешно сохранены! Для получения нового заявления и расписки, перейдите на страницу \"Управление принятыми заявлениями\" и получите архив документов.", "alert-success");
                                 enrollee.hostel = {
                                     checked: document.getElementById("checkbox-hostel-open").checked,
                                 }
                                 if (enrollee.hostel.checked)
                                     enrollee.hostel.type = document.getElementById("form-select-hostel-type").value;
                             break;
                             default:
                                 createAlert(`Произошла ошибка на сервере. Данные не обновлены. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                                 setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                             break;
                         }
                     }
                 )
            });
        else
            createAlert("Невозможно изменить статус заявления на общежитие, т.к. ничего не изменилось.");
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
    });

document.getElementById("text-input-average-grade").onkeypress = function(event) {
    if ("345".split("").indexOf(event.key) == -1)
        return false;
}

document.getElementById("text-input-average-grade").onkeyup = function(event) {
    if (this.value.length != 0) {
        var _sum = 0;
        this.value.split("").forEach((grade) => {
            _sum += Number(grade);
        });
    document.getElementById("span-average-grade").innerHTML = (_sum / this.value.length).toFixed(2);
    }
}

document.getElementById("button-average-grade-save").onclick = function() {
    if (document.getElementById("text-input-average-grade").value.length != 0) {
        $.post(
            "../api/secretary/s-edit/average-grade",
            {
                token: Cookies.get("token"),
                statement: enrollee.id,
                grades: document.getElementById("text-input-average-grade").value,
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        createAlert("Оценка успешно занесена!", "alert-success");
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

document.getElementById("button-add-additional-text").onclick = function() {
    createConfirm("Вы уверены, что хотите сохранить сообщение или его удалить?", () => {
        $.post(
            "../api/secretary/s-edit/additional/push",
            {
                token: Cookies.get("token"),
                statement: enrollee.id,
                message: $("#wysiwyg").summernote("isEmpty") ? null : $("#wysiwyg").summernote("code")
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        createAlert("Изменения успешно внесены!", "alert-success");
                    break;
                    default:
                        createAlert(`Ошибка при обработке заявления. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
                console.log(data);
            }
        );
    });
}

$(document).ready(function() {
    $('.wysiwyg-summernote').summernote({
        height: 350,
        lang: "ru-RU",
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ["insert", ["picture", "table", "link"]],
          ['height', ['height']]
        ]
    });
    $.post(
        "../api/secretary/s-edit/additional/get",
        {
            token: Cookies.get("token"),
            statement: enrollee.id
        },
        (data) => {
            switch (data.status) {
                case "OK":
                    if (data.message.length != 0)
                        $("#wysiwyg").summernote("code", data.message);
                break;
                default:
                    createAlert(`Ошибка при обработке заявления. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                break;
            }
        }
    );
  });