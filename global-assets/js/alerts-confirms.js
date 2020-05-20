function createAlert(_message = "None", _type = "alert-warning") {
    var mainDiv = document.createElement("div"),
        buttonDismiss = document.createElement("button"),
        spanDismiss = document.createElement("span"),
        spanMessage = document.createElement("span"),
        id = `alert-${Date.now()}`;

    mainDiv.setAttribute("class", `alert ${_type} pulse animated`);
    mainDiv.setAttribute("role", "alert");
    mainDiv.setAttribute("id", id);
    buttonDismiss.setAttribute("type", "button");
    buttonDismiss.setAttribute("class", "close");
    buttonDismiss.setAttribute("data-dismiss", "alert");
    buttonDismiss.setAttribute("aria-label", "Close");
    spanDismiss.setAttribute("aria-hidden", "true");
    spanDismiss.innerHTML = "×";
    buttonDismiss.appendChild(spanDismiss);
    spanMessage.innerHTML = _message;
    mainDiv.appendChild(buttonDismiss);
    mainDiv.appendChild(spanMessage);

    document.getElementById("alerts-area").appendChild(mainDiv);
    setTimeout(() => {
        if (document.getElementById(id) !== null)
            document.getElementById(id).remove();
    }, 3000);
}

function createConfirm(_message = "None", _lambda) {
    if (typeof(_lambda) === "function") {
        var modal = document.createElement("div"),
            modalDialog = document.createElement("div"),
            modalContent = document.createElement("div"),
            modalHeader = document.createElement("div"),
            modalTitle = document.createElement("h4"),
            modalBody = document.createElement("div"),
            modalMessage = document.createElement("p"),
            modalFooter = document.createElement("div"),
            buttonDismiss = document.createElement("button"),
            buttonOk = document.createElement("button"),
            id = `modal-confirm-${Date.now()}`;

        modal.setAttribute("class", "modal fade");
        modal.setAttribute("role", "dialog");
        modal.setAttribute("tabindex", "-1");
        modal.setAttribute("id", id);
        modal.setAttribute("data-backdrop", "static");
        modal.setAttribute("style", "z-index: 10000000;");
        modalDialog.setAttribute("class", "modal-dialog");
        modalDialog.setAttribute("role", "document");
        modalContent.setAttribute("class", "modal-content shadow");
        modalHeader.setAttribute("class", "modal-header");
        modalTitle.setAttribute("class", "modal-title");
        modalTitle.innerHTML = "Подтвердите действие";
        modalBody.setAttribute("class", "modal-body");
        modalMessage.innerHTML = `${_message}`;
        modalFooter.setAttribute("class", "modal-footer");
        buttonDismiss.setAttribute("class", "btn btn-light");
        buttonDismiss.setAttribute("type", "button");
        buttonDismiss.setAttribute("data-dismiss", "modal");
        buttonDismiss.innerHTML = "Отменить";
        buttonOk.setAttribute("class", "btn btn-primary");
        buttonOk.setAttribute("type", "button");
        buttonOk.setAttribute("data-dismiss", "modal");
        buttonOk.onclick = _lambda;
        buttonOk.innerHTML = "Подтвердить";

        modalFooter.appendChild(buttonDismiss);
        modalFooter.appendChild(buttonOk);
        modalBody.appendChild(modalMessage);
        modalHeader.appendChild(modalTitle);
        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalDialog.appendChild(modalContent);
        modalContent.appendChild(modalFooter);
        modal.appendChild(modalDialog);
        document.getElementsByTagName("body")[0].appendChild(modal);

        $(`#${id}`).modal();
        $(`#${id}`).on('hidden.bs.modal', function() {
            setTimeout(() => { document.getElementById(id).remove(); }, 500);
          });
    } else
        return false;
}