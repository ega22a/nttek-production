$(".nav-pills > .nav-item").click(function() {
	var count = $(this.parentNode).data("count");
    if (count == 1)
        $(".nav-pills[data-count=2] .nav-link").attr("class", "nav-link");
    else
        $(".nav-pills[data-count=1] .nav-link").attr("class", "nav-link");
});

$(".button-enrollee-delete").click(function() {
    var id = $(this.parentElement.parentElement).data("id"),
        parent = this.parentElement.parentElement;
    createConfirm("Вы уверены, что вы хотите удалить все данные об абитуриенте? Если вы это сделаете, то обратного действия не будет.", () => {
        $.post(
            "../api/secretary/statements/delete",
            {
                token: Cookies.get("token"),
                id: id
            },
            (data) => {
                switch (data.status) {
                    case "OK":
                        createAlert("Абитуриент успешно удален, ровно как и все его документы!", "alert-success");
                        parent.remove();
                    break;
                    default:
                        createAlert(`Произошла ошибка на сервере. Подробнее: <b>${data.status}</b>`);
                    break;
                }
            }
        );
    });
});

$(".button-enrollee-archive").click(function() {
    var id = $(this).data("id");
    createConfirm("Подтвердите скачивание архива документов абитуриента.", () => {
        $("#modal-spinner").modal();
        $.post(
            "../api/secretary/statements/get-archive",
            {
                token: Cookies.get("token"),
                id: id
            },
            (data) => {
                setTimeout(() => { $("#modal-spinner").modal("hide"); }, 350);
                switch (data.status) {
                    case "OK":
                        download(`data:application/zip;base64,${data.archive}`, `${data.name}.zip`, "appication/zip");
                    break;
                    default:
                        createAlert(`Произошла ошибка на сервере. Подробнее: <b>${data.status}</b>`);
                    break;
                }
            }
        );
    });
});

$(".button-enrollee-receipt").click(function() {
    var id = $(this).data("id");
    $.post(
        "../api/secretary/statements/get-docs",
        {
            token: Cookies.get("token"),
            id: id,
            type: "receipt"
        },
        (data) => {
            switch (data.status) {
                case "OK":
                    download(`data:application/pdf;base64,${data.doc}`, `Расписка.pdf`, "appication/pdf");
                break;
                default:
                    createAlert(`Произошла ошибка на сервере. Подробнее: <b>${data.status}</b>`);
                break;
            }
        }
    );
});

$(".button-enrollee-statement").click(function() {
    var id = $(this).data("id");
    $.post(
        "../api/secretary/statements/get-docs",
        {
            token: Cookies.get("token"),
            id: id,
            type: "statement"
        },
        (data) => {
            switch (data.status) {
                case "OK":
                    download(`data:application/pdf;base64,${data.doc}`, `Заявление.pdf`, "appication/pdf");
                break;
                default:
                    createAlert(`Произошла ошибка на сервере. Подробнее: <b>${data.status}</b>`);
                break;
            }
        }
    );
});

$(".button-enrollee-edit").click(function() {
    location.href = `s-edit?id=${$(this.parentNode.parentNode).data("id")}`;
});

$(".possible-contract-button").click(function() {
    $.post(
        "../api/secretary/statements/possible-contract",
        {
            token: Cookies.get("token"),
            id: $(this).data("id"),
            possible: !$(this).hasClass("text-info")
        },
        (data) => {
            switch (data.status) {
                case "OK":
                    $(this).toggleClass("text-info");
                break;
                default:
                    createAlert(`Произошла ошибка на сервере. Подробнее: <b>${data.status}</b>`);
                break;
            }
        }
    )
});