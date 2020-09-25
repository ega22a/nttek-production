class formGenerator {
    constructor(_placeholder = "") {
        if (!(_placeholder.length == 0))
            if (document.getElementById(_placeholder) !== null)
                this.placeholder = _placeholder;
            else
                return false;
        else
            return false;
    }

    text(_extends = {}) {
        var li = document.createElement("li"),
            id = `text-${makeRandomString(32)}`;
        li.setAttribute("class", "list-group-item");
        li.id = id;
        li.innerHTML = `
            <h5>Текстовое поле</h5>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="${id}-main-name">Наименование поля<span class="text-danger">*</span>:</label>
                    <input class="form-control form-control-sm" requied="" type="text" id="${id}-main-name" placeholder="Например, &quot;Фамилия&quot;">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <select class="custom-select custom-select-sm" id="${id}-type">
                        <option value="" selected="">Выберите тип поля</option>
                        <option value="text">Текстовое поле</option>
                        <option value="number">Числовое поле</option>
                        <option value="tel">Телефон</option>
                        <option value="email">Адрес электронной почты</option>
                        <option value="date">Дата</option>
                        <option value="datetime-local">Дата и время</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12 form-control-sm">
                    <div class="custom-control custom-control-inline custom-switch">
                        <input class="custom-control-input" type="checkbox" id="${id}-required">
                        <label class="custom-control-label" for="${id}-required">Обязательное поле</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12" style="margin-bottom: 0;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text form-control-sm" style="font-size: .875rem;">Идентификатор</span>
                        </div>
                        <input class="form-control form-control-sm" type="text" required="" disabled="" readonly="" value="${id}" id="${id}-id">
                    </div>
                </div>
            </div>
            <button class="btn btn-danger btn-sm float-right" type="button" style="margin-top: 16px;" onclick="createConfirm('Вы уверены, что хотите удалить текстовое поле?', () => { document.getElementById('${id}').remove(); })">Удалить</button>
        `;
        document.getElementById(this.placeholder).appendChild(li);
    }

    radio(_extends = {}) {
        var li = document.createElement("li"),
            id = `radio-${makeRandomString(32)}`;
        li.setAttribute("class", "list-group-item");
        li.id = id;
        li.innerHTML = `
            <h5>Радиокнопки</h5>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="${id}-main-name">Общее наименование радиокнопок<span class="text-danger">*</span>:</label>
                    <input class="form-control form-control-sm" requied="" type="text" id="${id}-main-name" placeholder="Например, &quot;Пол&quot;">
                </div>
            </div>
            <ul class="list-group" style="margin-bottom: 15px;" id="${id}-list-of-radios">
                <li class="list-group-item">
                    <div class="form-row">
                        <div class="form-group col-md-10" style="margin-bottom: 5px;">
                            <input class="form-control form-control-sm" type="text" placeholder="Введите имя...">
                        </div>
                        <div class="d-flex justify-content-center align-items-end form-group col-md-2" style="margin-bottom: 5px;">
                            <button class="btn btn-danger btn-sm" type="button" onclick="$(this).parent().parent().parent()[0].remove();">Удалить</button>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="list-group" style="margin-bottom: 15px;">
                <li class="list-group-item list-group-item-primary text-center" style="cursor: pointer;" onclick="appendDynamic('${id}-list-of-radios', 'radio');">
                    <span class="text-center">Добавить элемент</span>
                </li>
            </ul>
            <div class="form-row">
                <div class="form-group col-md-12" style="margin-bottom: 0;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text form-control-sm" style="font-size: .875rem;">Идентификатор</span>
                        </div>
                        <input class="form-control form-control-sm" type="text" required="" disabled="" readonly="" value="${id}" id="${id}-id">
                    </div>
                </div>
            </div>
            <button class="btn btn-danger btn-sm float-right" type="button" style="margin-top: 16px;" onclick="createConfirm('Вы уверены, что хотите удалить радиокнопки?', () => { document.getElementById('${id}').remove(); })">Удалить</button>
        `;
        document.getElementById(this.placeholder).appendChild(li);
    }

    checkbox(_extends = {}) {
        var li = document.createElement("li"),
            id = `checkbox-${makeRandomString(32)}`;
        li.setAttribute("class", "list-group-item");
        li.id = id;
        li.innerHTML = `
            <h5>Чекбокс</h5>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="${id}-main-name">Наименование чекбокса<span class="text-danger">*</span>:</label>
                    <input class="form-control form-control-sm" requied="" type="text" id="${id}-main-name" placeholder="Например, &quot;Вы студент&quot;?">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12 form-control-sm">
                    <div class="custom-control custom-control-inline custom-switch">
                        <input class="custom-control-input" type="checkbox" id="${id}-required">
                        <label class="custom-control-label" for="${id}-required">Обязательный для заполнения</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12" style="margin-bottom: 0;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text form-control-sm" style="font-size: .875rem;">Идентификатор</span>
                        </div>
                        <input class="form-control form-control-sm" type="text" required="" disabled="" readonly="" value="${id}" id="${id}-id">
                    </div>
                </div>
            </div>
            <button class="btn btn-danger btn-sm float-right" type="button" style="margin-top: 16px;" onclick="createConfirm('Вы уверены, что хотите удалить чекбокс?', () => { document.getElementById('${id}').remove(); })">Удалить</button>
        `;
        document.getElementById(this.placeholder).appendChild(li);
    }

    select(_extends = {}) {
        var li = document.createElement("li"),
            id = `select-${makeRandomString(32)}`;
        li.setAttribute("class", "list-group-item");
        li.id = id;
        li.innerHTML = `
            <h5>Выпадающий список</h5>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="${id}-main-name">Наименование выпадающего списка<span class="text-danger">*</span>:</label>
                    <input class="form-control form-control-sm" requied="" type="text" id="${id}-main-name" placeholder="Например, &quot;Вы студент&quot;">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12 form-control-sm">
                    <div class="custom-control custom-control-inline custom-switch">
                        <input class="custom-control-input" type="checkbox" id="${id}-required">
                        <label class="custom-control-label" for="${id}-required">Обязательный для заполнения</label>
                    </div>
                </div>
                <div class="form-group col-md-12 form-control-sm">
                    <div class="custom-control custom-control-inline custom-switch">
                        <input class="custom-control-input" type="checkbox" id="${id}-multiple">
                        <label class="custom-control-label" for="${id}-multiple">Множественный выбор</label>
                    </div>
                </div>
            </div>
            <ul class="list-group" style="margin-bottom: 15px;" id="${id}-list-of-options">
                <li class="list-group-item" id="${id}-list-of-options-0">
                    <div class="form-row">
                        <div class="form-group col-md-10" style="margin-bottom: 5px;">
                            <input class="form-control form-control-sm" id="${id}-list-of-options-0-name" type="text" placeholder="Введите имя...">
                        </div>
                        <div class="d-flex justify-content-center align-items-end form-group col-md-2" style="margin-bottom: 5px;">
                            <button class="btn btn-danger btn-sm" type="button" onclick="createConfirm('Вы уверены, что хотите удалить элемент выпадающего списка?', () => { $(this).parent().parent().parent()[0].remove(); })">Удалить</button>
                        </div>
                    </div>
                    <div class="custom-control custom-control-inline custom-switch form-control-sm">
                        <input class="custom-control-input" type="checkbox" id="${id}-list-of-options-0-group" onclick="$('#${id}-list-of-options-0-ul-hidden').slideToggle('fast')">
                        <label class="custom-control-label" for="${id}-list-of-options-0-group">Группа элементов</label>
                    </div>
                    <div id="${id}-list-of-options-0-ul-hidden" style="display: none;">
                        <ul class="list-group" style="margin-bottom: 15px;" id="${id}-list-of-options-0-ul">
                            <li class="list-group-item">
                                <div class="form-row">
                                    <div class="form-group col-md-10" style="margin-bottom: 5px;">
                                        <input class="form-control form-control-sm" type="text" id="${id}-list-of-options-0-0-name" placeholder="Введите имя...">
                                    </div>
                                    <div class="d-flex justify-content-center align-items-end form-group col-md-2" style="margin-bottom: 5px;">
                                        <button class="btn btn-danger btn-sm" type="button" onclick="$(this).parent().parent().parent()[0].remove();">Удалить</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group" style="margin-bottom: 15px;">
                            <li class="list-group-item list-group-item-primary text-center" style="cursor: pointer;" onclick="appendDynamic('${id}-list-of-options-0-ul', 'option-second');">
                                <span class="text-center">Добавить элемент</span>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <ul class="list-group" style="margin-bottom: 15px;">
                <li class="list-group-item list-group-item-primary text-center" style="cursor: pointer;" onclick="appendDynamic('${id}-list-of-options', 'option');">
                    <span class="text-center">Добавить элемент</span>
                </li>
            </ul>
            <div class="form-row">
                <div class="form-group col-md-12" style="margin-bottom: 0;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text form-control-sm" style="font-size: .875rem;">Идентификатор</span>
                        </div>
                        <input class="form-control form-control-sm" type="text" required="" disabled="" readonly="" value="${id}" id="${id}-id">
                    </div>
                </div>
            </div>
            <button class="btn btn-danger btn-sm float-right" type="button" style="margin-top: 16px;" onclick="createConfirm('Вы уверены, что хотите удалить выпадающий список?', () => { document.getElementById('${id}').remove(); })">Удалить</button>
        `;
        document.getElementById(this.placeholder).appendChild(li);
    }

    getJSON() {
        if (document.getElementById("v-pills-new-form").children[2].checkValidity()) {
            var _json = [];
            for (var item of document.getElementById(this.placeholder).children) {
                var _piece = {};
                switch (item.id.split("-")[0]) {
                    case "text":
                        _piece = {
                            type: "text",
                            label: item.children[1].children[0].children[1].value,
                            required: item.children[3].children[0].children[0].children[0].checked,
                            id: item.id,
                            additional: item.children[2].children[0].children[0].value
                        }
                    break;
                    case "select":
                        _piece = {
                            type: "select",
                            label: item.children[1].children[0].children[1].value,
                            required: item.children[2].children[0].children[0].children[0].checked,
                            id: item.id,
                            multiple: item.children[2].children[1].children[0].children[0].checked,
                            data: []
                        };
                        for (var _option of item.children[3].children) {
                            var _push = {
                                optgroup: _option.children[1].children[0].checked,
                                value: _option.children[0].children[0].children[0].value,
                                data: []
                            };
                            if (_push.optgroup)
                                for (var _subOption of _option.children[2].children[0].children)
                                    _push.data.push(_subOption.children[0].children[0].children[0].value);
                            _piece.data.push(_push);
                        }
                    break;
                    case "radio":
                        _piece = {
                            type: "radio",
                            label: item.children[1].children[0].children[1].value,
                            id: item.id,
                            data: []
                        }
                        for (var _radioButton of item.children[2].children)
                            _piece.data.push(_radioButton.children[0].children[0].children[0].value);
                    break;
                    case "checkbox":
                        _piece = {
                            type: "checkbox",
                            label: item.children[1].children[0].children[1].value,
                            id: item.id,
                            required: item.children[2].children[0].children[0].children[0].checked
                        }
                    break;
                }
                _json.push(_piece);
            }
            return {
                name: document.getElementById("new-form-name").value,
                collectEmail: document.getElementById("new-checkbox-collect-email").checked,
                forwarding: document.getElementById("new-form-send-to-email").checked,
                email: document.getElementById("new-form-email").value,
                form: JSON.stringify(_json)
            };
        } else
            createAlert("Вы не заполнили данные о форме!");
    }
}

var generator = new formGenerator("new-form-list-of-elements");

document.getElementById("new-form-create-element").onclick = function() {
    generator.placeholder = "new-form-list-of-elements";
    switch (document.getElementById("new-form-select-element").value) {
        case "text":
            generator.text();
        break;
        case "radio":
            generator.radio();
        break;
        case "checkbox":
            generator.checkbox();
        break;
        case "select":
            generator.select();
        break;
        case "":
        default:
            createAlert("Вы не выбрали элемент, который нужно создать!");
        break;
    }
}

document.getElementById("exsisting-form-send-to-email").onclick = function() {
    if (this.checked) {
        document.getElementById("exsisting-form-email").removeAttribute("disabled");
        document.getElementById("exsisting-form-email").setAttribute("required", true);
    } else {
        document.getElementById("exsisting-form-email").setAttribute("disabled", true);
        document.getElementById("exsisting-form-email").removeAttribute("required");
    }
    $("#exsisting-form-email-danger").toggle()
}

document.getElementById("new-form-send-to-email").onclick = function() {
    if (this.checked) {
        document.getElementById("new-form-email").removeAttribute("disabled");
        document.getElementById("new-form-email").setAttribute("required", true);
    } else {
        document.getElementById("new-form-email").setAttribute("disabled", true);
        document.getElementById("new-form-email").removeAttribute("required");
    }
    $("#new-form-email-danger").toggle()
}

function appendDynamic(_id = "", _type = "") {
    if (!(_id.length == 0 || _type.length == 0)) {
        var li = document.createElement("li");
        li.setAttribute("class", "list-group-item")
        switch (_type) {
            case "radio":
                li.innerHTML = `
                    <div class="form-row">
                        <div class="form-group col-md-10" style="margin-bottom: 5px;">
                            <input class="form-control form-control-sm" type="text" placeholder="Введите имя...">
                        </div>
                        <div class="d-flex justify-content-center align-items-end form-group col-md-2" style="margin-bottom: 5px;">
                            <button class="btn btn-danger btn-sm" type="button" onclick="$(this).parent().parent().parent()[0].remove();">Удалить</button>
                        </div>
                    </div>
                `;
                document.getElementById(_id).appendChild(li);
            break;
            case "option":
                li.id = `${_id}-${document.getElementById(_id).children.length}`;
                li.innerHTML = `
                    <div class="form-row">
                        <div class="form-group col-md-10" style="margin-bottom: 5px;">
                            <input class="form-control form-control-sm" id="${_id}-list-of-options-${document.getElementById(_id).children.length}-name" type="text" placeholder="Введите имя...">
                        </div>
                        <div class="d-flex justify-content-center align-items-end form-group col-md-2" style="margin-bottom: 5px;">
                            <button class="btn btn-danger btn-sm" type="button" onclick="createConfirm('Вы уверены, что хотите удалить элемент выпадающего списка?', () => { $(this).parent().parent().parent()[0].remove(); })">Удалить</button>
                        </div>
                    </div>
                    <div class="custom-control custom-control-inline custom-switch form-control-sm">
                        <input class="custom-control-input" type="checkbox" id="${_id}-list-of-options-${document.getElementById(_id).children.length}-group" onclick="$('#${_id}-list-of-options-${document.getElementById(_id).children.length}-ul-hidden').slideToggle('fast')">
                        <label class="custom-control-label" for="${_id}-list-of-options-${document.getElementById(_id).children.length}-group">Группа элементов</label>
                    </div>
                    <div id="${_id}-list-of-options-${document.getElementById(_id).children.length}-ul-hidden" style="display: none;">
                        <ul class="list-group" style="margin-bottom: 15px;" id="${_id}-list-of-options-${document.getElementById(_id).children.length}-ul">
                            <li class="list-group-item">
                                <div class="form-row">
                                    <div class="form-group col-md-10" style="margin-bottom: 5px;">
                                        <input class="form-control form-control-sm" type="text" placeholder="Введите имя...">
                                    </div>
                                    <div class="d-flex justify-content-center align-items-end form-group col-md-2" style="margin-bottom: 5px;">
                                        <button class="btn btn-danger btn-sm" type="button" onclick="$(this).parent().parent().parent()[0].remove();">Удалить</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-primary text-center" style="cursor: pointer;" onclick="appendDynamic('${_id}-list-of-options-${document.getElementById(_id).children.length}-ul', 'option-second');">
                                <span class="text-center">Добавить элемент</span>
                            </li>
                        </ul>
                    </div>
                `;
                document.getElementById(_id).appendChild(li);
            break;
            case "option-second":
                li.innerHTML = `
                    <div class="form-row">
                        <div class="form-group col-md-10" style="margin-bottom: 5px;">
                            <input class="form-control form-control-sm" type="text" placeholder="Введите имя...">
                        </div>
                        <div class="d-flex justify-content-center align-items-end form-group col-md-2" style="margin-bottom: 5px;">
                            <button class="btn btn-danger btn-sm" type="button" onclick="$(this).parent().parent().parent()[0].remove();">Удалить</button>
                        </div>
                    </div>
                `;
                document.getElementById(_id).appendChild(li);
            break;
            default:
                createAlert("В функцию был передан некорректный тип!", "alert-danger");
            break;
        }
    } else
        createAlert("Произошла ошибка при выполнении исходного кода! Обратитесь к системному администратору!", "alert-danger");
}

document.getElementById("new-form-save").onclick = function() {
    var sender = generator.getJSON();
    sender.token = Cookies.get("token");
    $.post(
        "../api/admin/repository/push",
        sender,
        (data) => {
            switch (data.status) {
                case "OK":
                    var li = document.createElement("li");
                    li.setAttribute("class", "list-group-item d-flex justify-content-between align-items-center")
                    li.innerHTML = `
                        <span>${sender.name}</span>
                        <div class="btn-group btn-group-sm float-right" role="group">
                            <button class="btn btn-outline-primary" onclick="exsistingButtonEdit(${data.id}, this);" type="button">Редактировать</button>
                            <button class="btn btn-outline-danger" onclick="exsistingButtonDelete(${data.id}, this);" type="button">Удалить</button>
                        </div>
                    `;
                    document.getElementById("v-pills-forms-storage").children[1].appendChild(li);
                    createAlert("Форма успешно сохранена!", "alert-success");
                break;
                default:
                    createAlert(`На сервере произошла ошибка. Подробнее: <b>${data.status}</b>.`, "alert-danger");
                break;
            }
        }
    );
}

function exsistingButtonDelete(_id, _this) {
    console.log(this);
    createConfirm("Вы уверены, что вы хотите удалить форму? Если вы это сделаете, то обратного пути не будет!", () => {
        $.post(
            "../api/admin/repository/delete",
            {
                token: Cookies.get("token"),
                id: _id
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        createAlert("Форма успешно удалена!", "alert-success");
                        _this.parentNode.parentNode.remove();
                    break;
                    default:
                        createAlert(`На сервере произошла ошибка. Подробнее: <b>${data.status}</b>.`, "alert-danger");
                    break;
                }
            }
        );
    })
};

function exsistingButtonEdit() {
    var id = $(this).data("id");
    createAlert("Функционал пока не реализован.");
};