$(".send-form").click(function() {
    var id = $(this).data("id"),
        form = document.getElementById(`v-pills-${id}`).children[1];
    if (form.checkValidity()) {
        var collect = [];
        for (var item of form)
            collect.push({
                type: item.getAttribute("type"),
                id: item.id,
                name: item.getAttribute("placeholder"),
                value: item.getAttribute("type") == "checkbox" || item.getAttribute("type") == "radio" ? item.checked : item.value
            });
        $("#modal-spinner").modal();
        $.post(
            "api/push",
            {
                payload: JSON.stringify(collect),
                id: id
            },
            (data) => {
                console.log(data);
                switch (data.status) {
                    case "OK":
                        createAlert("Ваша форма успешно отправлена!", "alert-success");
                        setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                    break;
                    default:
                        createAlert(`На сервере произошла ошибка. Подробнее: <b>${data.status}</b>.`, "alert-danger");
                        setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                    break;
                }
            }
        );
    } else
        createAlert("Внимание! Не все обязательные поля были заполнены!");
});