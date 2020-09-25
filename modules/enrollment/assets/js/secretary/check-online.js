var enrollee;

$(".nav-pills > .nav-item").click(function() {
	var count = $(this.parentNode).data("count");
    if (count == 1)
        $(".nav-pills[data-count=2] .nav-link").attr("class", "nav-link");
    else
        $(".nav-pills[data-count=1] .nav-link").attr("class", "nav-link");
});

$(".item-enrollee-action").click(function() {
    enrollee = $(this).data("json");
    $("#modal-check-enrollee").modal();
		$("#modal-spinner").modal();
    $.post(
        "../api/secretary/check-online/get-archive",
        {
            token: Cookies.get("token"),
            id: enrollee.id
        },
        (data) => {
            switch (data.status) {
                case "OK":
					setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                    download(`data:application/zip;base64,${data.archive}`, `${data.name}.zip`, "appication/zip");
                break;
                default:
					setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                    createAlert(`На сервере произошла ошибка. Подробнее: <b>${data.status}</b>.`, "alert-danger");
                break;
            }
        }
    );
});

document.getElementById("modal-check-enrollee-incorrect").onclick = function() {
    createConfirm("Вы уверены, что данные некорректны?", () => {
        $("#modal-dismiss-enrollee").modal();
    });
}

document.getElementById("modal-check-enrollee-correct").onclick = function() {
    createConfirm("Вы уверены, что все данные корректны?", () => {
        if (enrollee.type == "budget") {
            $("#modal-avarage-grade").modal();
        } else if (enrollee.type == "contract") {
            $("#modal-spinner").modal();
            $.post(
                "../api/secretary/check-online/confirm",
                {
                    token: Cookies.get("token"),
                    id: enrollee.id,
                    type: "contract",
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            createAlert("Абитуриент успешно зарегистрирован в системе! Ему придет уведомление о заполнении Заявления.", "alert-success");
                            createAlert(`Номер личного дела: <b>${data.key}</b>.`, "alert-success", true);
                            $("#modal-check-enrollee").modal("hide");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                            $(`.item-enrollee-action[data-json='${JSON.stringify(enrollee)}']`).remove();
                            enrollee = "";
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Подробнее: <b>${data.status}</b>`);
                        break;
                    }
                }
            );
        }
    });
}

document.getElementById("modal-dismiss-enrollee-button").onclick = function() {
    if (document.getElementById("modal-dismiss-enrollee-text").value.length != 0)
        createConfirm("Вы уверенны, что вы хотите отправить составленное письмо абитуриенту, а также удалить все его данные с сервера?", () => {
            $.post(
                "../api/secretary/check-online/dismiss",
                {
                    token: Cookies.get("token"),
                    id: enrollee.id,
                    message: document.getElementById("modal-dismiss-enrollee-text").value,
                },
                (data) => {
                    switch (data.status) {
                        case "OK":
                            $("#modal-dismiss-enrollee").modal("hide");
                            $("#modal-check-enrollee").modal("hide");
                            $(`.item-enrollee-action[data-json='${JSON.stringify(enrollee)}']`).remove();
                            enrollee = "";
                        break;
                    }
                }
            );
        });
    else
        createAlert("Обязательно составьте характеризирующее письмо!");
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
        $("#modal-spinner").modal();
        $.post(
            "../api/secretary/check-online/confirm",
            {
                token: Cookies.get("token"),
                id: enrollee.id,
                type: "budget",
                grades: document.getElementById("modal-text-input-average-grade").value
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        createAlert("Абитуриент успешно зарегистрирован в системе! Ему придет уведомление о заполнении Заявления.", "alert-success");
                        createAlert(`Номер личного дела: <b>${data.key}</b>.`, "alert-success", true);
                        $("#modal-check-enrollee").modal("hide");
                        $("#modal-avarage-grade").modal("hide");
                        setTimeout(() => { $("#modal-spinner").modal("hide"); }, 250);
                        $(`.item-enrollee-action[data-json='${JSON.stringify(enrollee)}']`).remove();
                        enrollee = "";
                    break;
                    default:
                        createAlert(`Произошла ошибка на сервере. Подробнее: <b>${data.status}</b>`);
                    break;
                }
            }
        );
    } else
        createAlert("Для того, чтобы посчитать оценку, нужно ввести оценки!");
}
