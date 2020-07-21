var buttonsInsertLine = document.getElementsByClassName("button-push-line"),
    action;

function listClick(_this) {
    var data = JSON.parse(_this.getAttribute("data-json"));
    $("#modal-edit-new").modal();
    action = {
        isNew: false,
        what: data.action,
        id: data.data.id,
        vanilla: {},
        item: _this
    };
    document.getElementById(`modal-form-${data.action}`).removeAttribute("style");
    if (action.what == "docs-for-review")
        document.getElementById("docs-for-review-input-pdf-file").removeAttribute("required");
    for (key in data.data) {
        var _k = key;
        for (char of "QWERTYUIOPASDFGHJKLZXCVBNM".split(""))
            if (key.indexOf(char) != -1) {
                _k = key.substring(0, key.indexOf(char)) + "-" + key.substring(key.indexOf(char)).toLowerCase();
                break;
            }
        var inp = document.getElementById(`${data.action}-input-${_k}`);
        if (inp !== null) {
            if (inp.getAttribute("type") != "file" && inp.getAttribute("type") != "checkbox") {
                inp.value = data.data[key];
                action.vanilla[_k] = data.data[key];
            } else if (inp.getAttribute("type") == "checkbox") {
                inp.checked = data.data[key] == "1" ? true : false;
                action.vanilla[_k] = data.data[key] == "1" ? true : false;
            }
        } else if (action.what == "attached-docs" && key != "id")
            action.vanilla[_k] = data.data[key] == "1" ? true : false;
    }
}

for (button of buttonsInsertLine)
    button.onclick = function() {
        var type = $(this).data("type"),
            modal = document.getElementById("modal-edit-new");
        document.getElementById(`modal-form-${type}`).removeAttribute("style");
        $(modal).modal();
        $("#modal-delete-button").hide();
        action = {
            isNew: true,
            what: type,
        }
        if (type == "attached-docs") {
            document.getElementById("attached-docs-input-latin-name").value = `${makeRandomString(8)}-${Date.now()}`;
            action.data = {
                forOnline: $(this).data("number") == "2" || $(this).data("number") == "4" ? true : false,
                forExtramural: $(this).data("number") == "3" || $(this).data("number") == "4" ? true : false,
                number: $(this).data("number")
            }
        } else if (type == "specialty") {
            action.data = {
                number: $(this).data("number")
            }
            if (action.data.number == "1")
                document.getElementById("specialty-input-for-extramural").checked = true;
        }
    }

document.getElementById("modal-save-button").onclick = function() {
    if (document.getElementById(`modal-form-${action.what}`).checkValidity()) {
        var form = new FormData();
        $("#modal-spinner").modal();
        form.append("token", Cookies.get("token"));
        form.append("form-type", action.what);
        document.getElementById(`modal-form-${action.what}`).setAttribute("class", "validate");
        for (input of $(`#modal-form-${action.what} input`)) {
            if (input.getAttribute("type") != "file")
                form.append(input.getAttribute("id").split(`${action.what}-input-`)[1], input.getAttribute("type") == "checkbox" ? input.checked : input.value);
            else
                form.append(input.getAttribute("id").split(`${action.what}-input-`)[1], typeof(input.files[0]) !== "undefined" ? input.files[0] : null);
        }
        if (action.isNew) {
            if (action.what == "attached-docs") {
                form.append("for-extramural", action.data.forExtramural);
                form.append("for-online", action.data.forOnline);
            }
            $.ajax({
                url: "../api/secretary/configuration/fields/new",
                data: form,
                processData: false,
                contentType: false,
                type: 'POST',
                success: (data) => {
                    switch (data.status) {
                        case "OK":
                            var _thumb = {
                                    action: action.what,
                                    data: {}
                                };
                                child = document.createElement("a");
                            child.setAttribute("class", "list-group-item list-group-item-action");
                            child.setAttribute("onclick", "listClick(this);");
                            _thumb.data.action = action.what;
                            for (key in data.data)
                                _thumb.data[key] = data.data[key];
                            child.setAttribute("data-json", JSON.stringify(_thumb));
                            if (action.what == "attached-docs") {
                                child.innerHTML = `<span>${_thumb.data.name}</span>`;
                                child.innerHTML += _thumb.data["is-nessesary"] == "1" ? "<i class=\"fas fa-exclamation-triangle\" style=\"float: right;margin-top:3px;\"></i>" : "";
                            } else
                                child.innerHTML = `<span>${_thumb.data.name}</span>`;
                            if (action.what == "attached-docs")
                                document.getElementById(`attached-docs-list-group-${action.data.number}`).appendChild(child);
                            else if (action.what == "specialty")
                                document.getElementById(`specialty-list-group-${action.data.number}`).appendChild(child);
                            else
                                document.getElementById(`v-pills-configurations-${action.what}`).children[0].appendChild(child);
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                            $("#modal-edit-new").modal("hide");
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                        break;
                    }
                }
            });
        } else {
            var del = [],
                counter = 0;
            form.forEach(function(value, key) {
                if (key != "pdf-file" && key != "token" && key != "form-type")
                    if (String(action.vanilla[key]) == String(value))
                        del.push(key);
            });
            del.forEach((key) => {
                form.delete(key);
            });
            form.forEach(() => {
                counter++;
            });
            if (counter != 2) {
                form.append("id", action.id);
                $.ajax({
                    url: "../api/secretary/configuration/fields/edit",
                    data: form,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: (data) => {
                        switch (data.status) {
                            case "OK":
                                var _thumb = {
                                    action: action.what,
                                    data: {}
                                };
                                _thumb.data.action = action.what;
                                for (key in data.data)
                                    _thumb.data[key] = data.data[key];
                                action.item.setAttribute("data-json", JSON.stringify(_thumb));
                                if (action.what == "attached-docs") {
                                    action.item.innerHTML = `<span>${_thumb.data.name}</span>`;
                                    action.item.innerHTML += _thumb.data["is-nessesary"] == "1" ? "<i class=\"fas fa-exclamation-triangle\" style=\"float: right;margin-top:3px;\"></i>" : "";
                                } else
                                    action.item.innerHTML = `<span>${_thumb.data.name}</span>`;
                                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                                $("#modal-edit-new").modal("hide");
                            break;
                            default:
                                createAlert(`Произошла ошибка на сервере. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                            break;
                        }
                    }
                });
            } else {
                createAlert("Вы ничего не изменили.");
                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
            }
        }
    } else
        document.getElementById(`modal-form-${action.what}`).setAttribute("class", "validate was-validated");
}

document.getElementById("modal-delete-button").onclick = function() {
    if (!action.isNew)
        createConfirm("Вы уверены, что хотите удалить запись? Это может привести к тому, что зависимые записи могут удалиться. Рекомендуется делать это в крайнем случае, когда есть уверенность, что запись не была использована.", () => {
            $("#modal-spinner").modal();
            $.post(
                "../api/secretary/configuration/fields/delete",
                {
                    "token": Cookies.get("token"),
                    "form-type": action.what,
                    "id": action.id,
                },
                (data) => {
                    console.log(data);
                    switch (data.status) {
                        case "OK":
                            action.item.parentNode.removeChild(action.item);
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                            $("#modal-edit-new").modal("hide");
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                        break;
                    }
                }
            )
        });
}

$(".nav-pills > .nav-item").click(function() {
	var count = $(this.parentNode).data("count");
    if (count == 1)
        $(".nav-pills[data-count=2] .nav-link").attr("class", "nav-link");
    else
        $(".nav-pills[data-count=1] .nav-link").attr("class", "nav-link");
})

$('#modal-edit-new').on('hide.bs.modal', function () {
    $("#modal-edit-new form").attr("style", "display: none");
    $("#modal-delete-button").show();
    $("#modal-edit-new form").attr("class", "validate");
    $("#modal-edit-new form").trigger("reset");
    $("label[for='docs-for-review-input-pdf-file']")[0].innerHTML = "Загрузить PDF...";
    document.getElementById("docs-for-review-input-pdf-file").setAttribute("required", true);
})

document.getElementById("docs-for-review-input-pdf-file").addEventListener("change", function() {
    if (this.files.length == 0)
        $("label[for='docs-for-review-input-pdf-file']")[0].innerHTML = "Загрузить PDF...";
    else {
        if (this.files[0].type == "application/pdf")
            $("label[for='docs-for-review-input-pdf-file']")[0].innerHTML = this.files[0].name;
        else {
            createAlert("Вы должны загрузить только PDF документ!");
            this.value = "";
            $("label[for='docs-for-review-input-pdf-file']")[0].innerHTML = "Загрузить PDF...";
        }
    }
})

document.getElementById("attached-docs-input-latin-name").addEventListener("input", function() {
    if (this.value.indexOf(" ") != -1)
        this.value = this.value.split(" ").join("-");
});

function getOperationalSummary(_type = "all") {
    var _granted = false;
    switch (_type) {
        case "all":
        case "fulltime":
        case "extramural":
            _granted = true;
    }
    if (_granted) {
        $("#modal-spinner").modal();
        $.post(
            "../api/secretary/configuration/docs/get",
            {
                token: Cookies.get("token"),
                type: "operational",
                enrollee: _type
            },
            (data) => {
                switch (data.status) {
                    case "OK":
    					setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                        download(`data:application/pdf;base64,${data.doc}`, `Оперативная сводка.pdf`, "appication/pdf");
                    break;
                    default:
    					setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                        createAlert(`На сервере произошла ошибка. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
            }
        )
    } else
        createAlert("Неправильный тип запроса!");
}

function getListOfEnrollees(_type = "fulltime", _hostel = false, _onlyOriginal = false) {
    var _granted = false;
    switch (_type) {
        case "fulltime":
        case "extramural":
            _granted = true;
    }
    if (_granted) {
        $("#modal-spinner").modal();
        $.post(
            "../api/secretary/configuration/docs/get",
            {
                token: Cookies.get("token"),
                type: "enrollee",
                enrollee: _type,
                hostel: _hostel ? 1 : 0,
                original: _onlyOriginal ? 1: 0
            },
            (data) => {
                switch (data.status) {
                    case "OK":
    					setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                        download(`data:application/pdf;base64,${data.doc}`, `Список абитуриентов.pdf`, "appication/pdf");
                    break;
                    default:
    					setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                        createAlert(`На сервере произошла ошибка. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
            }
        )
    } else
        createAlert("Неправильный тип запроса!");
}

function getHostelList(_type = "enrollees") {
    switch (_type) {
        case "enrollees":
            $("#modal-spinner").modal();
            $.post(
                "../api/secretary/configuration/docs/get",
                {
                    token: Cookies.get("token"),
                    type: "hostel",
                    enrollee: _type
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                            download(`data:application/pdf;base64,${data.doc}`, `Список абитуриентов на общежитие.pdf`, "appication/pdf");
                        break;
                        default:
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                            createAlert(`На сервере произошла ошибка. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                        break;
                    }
                }
            );
        break;
        case "analysis":
            createConfirm("Внимание! Анализационный список представляет анализ одинаковых ФИО. Система требует уникальные адреса электронной почты для каждого абитуриента, но ФИО - неуникальные данные. Этот список нужен, в первую очередь для того, чтобы выявить тех абитуриентов, которые подали заявление на несколько специальностей. Обратите внимание на то, что совпадение ФИО не гарантирует, что это один и тот же человек. В любом случае, в списке будут контактные данные абитуриентов.     ", () => {
                $("#modal-spinner").modal();
                $.post(
                    "../api/secretary/configuration/docs/get",
                    {
                        token: Cookies.get("token"),
                        type: "analysis"
                    },
                    (data) => {
                        switch (data.status) {
                            case "OK":
                                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                                download(`data:application/pdf;base64,${data.doc}`, `Анализационный список абитуриентов.pdf`, "appication/pdf");
                            break;
                            default:
                                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                                createAlert(`На сервере произошла ошибка. Побробнее: <b>${data.status}</b>.`, "alert-danger");
                            break;
                        }
                    }
                );
            });
        break;
        default:
            createAlert("Неправильный тип запроса!");
        break;
    }
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
  });

document.getElementById("button-new-news").onclick = function() {
    if ($("#v-pills-configurations-news form")[0].checkValidity() && !$("#field-new-news-text").summernote("isEmpty")) {
        createConfirm(`Вы уверены, что вы хотите выложить новость с заголовком "${document.getElementById("field-new-news-heading").value}"?`, () => {
            $("#modal-spinner").modal();
            $.post(
                "../api/secretary/configuration/news/new",
                {
                    token: Cookies.get("token"),
                    heading: document.getElementById("field-new-news-heading").value,
                    synopsis: document.getElementById("field-new-news-synopsis").value,
                    text: $("#field-new-news-text").summernote("code"),
                    important: document.getElementById("field-new-news-important").checked,
                    group: document.getElementById("field-new-news-group").value
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            var newList = document.createElement("a");
                            newList.setAttribute("class", "list-group-item list-group-item-action news-archive-edit-news");
                            newList.setAttribute("onclick", `editArchivedNews(${data.id})`);
                            newList.innerHTML = `<span>${data.heading}</span>`;
                            document.getElementById("news-archive-list-group").appendChild(newList);
                            createAlert("Новость создана.", "alert-success");
                        break;
                        default:
                            createAlert(`На сервере произошла ошибка. Подробнее: <b>${data.status}</b>.`, "alert-danger");
                        break;
                    }
                    setTimeout(() => { $("#modal-spinner").modal("hide"); }, 350);
                }
            );
        });
    } else
        createAlert("Для того, чтобы создать статью, нужно ее написать.");
};

function editArchivedNews(_id = undefined) {
    if (!(typeof(_id) == "undefined")) {
        $.post(
            "../api/secretary/configuration/news/get",
            {
                token: Cookies.get("token"),
                id: _id
            },
            (data) => {
                console.log(data);
                switch (data.status) {
                    case "OK":
                        $("#modal-edit-news").modal();
                        document.getElementById("field-edit-news-heading").value = data.heading;
                        document.getElementById("filed-edit-news-synopsis").value = data.synopsis;
                        $("#field-edit-news-text").summernote("code", data.text);
                        document.getElementById("filed-edit-news-important").checked = data.important;
                        document.getElementById("field-edit-news-id").innerHTML = _id;
                        document.getElementById("field-edit-news-group").value = data.group == null ? "0" : data.group;
                    break;
                    default:
                        createAlert(`На сервере произошла ошибка. Подробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
            }
        )
    } else
        createAlert("Вы не передали уникальный идентификатор новости!", "alert-danger");
}

document.getElementById("modal-edit-news-delete").onclick = function() {
    createConfirm("Вы уверены, что хотите удалить новость?", () => {
        var id = document.getElementById("field-edit-news-id").innerHTML;
        $.post(
            "../api/secretary/configuration/news/delete",
            {
                token: Cookies.get("token"),
                id: id
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        $(`.news-archive-edit-news[onclick="editArchivedNews(${id})"]`).remove();
                        $("#modal-edit-news").modal("hide");
                        createAlert("Новость удалена с сервера.", "alert-success");
                    break;
                    default:
                        createAlert(`На сервере произошла ошибка. Подробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
            }
        )
    });
}

document.getElementById("modal-edit-news-save").onclick = function() {
    createConfirm("Вы уверены, что хотите изменить новость?", () => {
        var id = document.getElementById("field-edit-news-id").innerHTML;
        $("#modal-spinner").modal(); 
        $.post(
            "../api/secretary/configuration/news/edit",
            {
                token: Cookies.get("token"),
                id: id,
                heading: document.getElementById("field-edit-news-heading").value,
                synopsis: document.getElementById("filed-edit-news-synopsis").value,
                text: $("#field-edit-news-text").summernote("code"),
                important: document.getElementById("filed-edit-news-important").checked,
                group: document.getElementById("field-edit-news-group").value
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        $(`.news-archive-edit-news[onclick="editArchivedNews(${id})"]`)[0].children[0].innerHTML = data.heading;
                        $("#modal-edit-news").modal("hide");
                        createAlert("Новость изменена.", "alert-success");
                    break;
                    default:
                        createAlert(`На сервере произошла ошибка. Подробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 350);
            }
        )
    });
}