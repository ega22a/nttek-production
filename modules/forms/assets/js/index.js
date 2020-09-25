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
                value: item.getAttribute("type") == "checkbox" ? item.checked : item.value
            });
        $("#modal-spinner").modal();
        $.post(
            "api/push",
            {
                payload: JSON.stringify(collect)
            },
            (data) => {
                switch (data.status) {
                    case "OK":

                    break;
                    default:

                    break;  
                }
            }
        );
    } else
        createAlert("Внимание! Не все обязательные поля были заполнены!");
});