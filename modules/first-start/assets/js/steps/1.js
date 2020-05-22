document.getElementById("button-next").onclick = () => {
    var form = document.getElementsByClassName("needs-validation")[0];
    if (form.checkValidity() === true) {
        form.classList.remove("was-validated");
        localStorage.setItem("admin-lastname", document.getElementById("form-lastname").value);
        localStorage.setItem("admin-firstname", document.getElementById("form-firstname").value);
        localStorage.setItem("admin-patronymic", document.getElementById("form-patronymic").value);
        localStorage.setItem("admin-birthday", document.getElementById("form-birthday").value);
        localStorage.setItem("admin-email", document.getElementById("form-email").value);
        localStorage.setItem("admin-telephone", document.getElementById("form-telephone").value);
        localStorage.setItem("admin-login", document.getElementById("form-login").value);
        localStorage.setItem("admin-password", document.getElementById("form-password").value);

        location.href = "?step=2";
    } else
        form.classList.add("was-validated");
}