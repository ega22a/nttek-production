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

document.getElementById("button-save").onclick = function() {
    var statement = document.getElementById("form-file-statement").files,
        hostel = "";
    if (document.getElementById("form-file-hostel") !== null)
        hostel = document.getElementById("form-file-hostel").files;
    if (statement.length != 0 && ((typeof(hostel) == "object" && hostel.length != 0) || (typeof(hostel) == "string") && hostel.length == 0)) {
        createConfirm("Вы уверены, что хотите загрузить ваши сканы? Учтите, что если скан окажется недействительным или подложным, то мы оставляем за собой право удалить вашу учетную запись без последующего уведомления. Это означает, что вы автоматически выбываете из приемной кампании. Нажимая кнопку \"Подтвердить\" Вы даете своё полное согласие с вышестоящими условиями.", () => {
            var counter = 0
                form = new FormData();
            form.set("token", Cookies.get("token"));
            for (item of statement) {
                form.set(`statement-${counter}`, item);
                counter++;
            }
            form.set("hostel", hostel[0]);
            $("#modal-spinner").modal();
            $.ajax({
                url: "api/addmission/save-docs",
                data: form,
                processData: false,
                contentType: false,
                type: 'POST',
                success: (data) => {
                    console.log(data);
                    switch (data.status) {
                        case "OK":
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                            createAlert("Данные успешно сохранены! Теперь Вы полностью учавствуйте в приемной кампании!", "alert-success");
                            document.getElementById("col-docs").remove();
                        break;
                        default:
                            createAlert(`Произошла ошибка на сервере. Подробнее: <strong>${data.status}</strong>`, "alert-danger");
                            setTimeout(() => { $("#modal-spinner").modal("hide"); }, 500);
                        break;
                    }
                }
            });
        });
    } else
        createAlert("Вам нужно загрузить документы, чтобы сохранить их!");
}
