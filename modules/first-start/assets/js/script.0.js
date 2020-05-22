$(document).ready(() => {
    $("#form-telephone").mask("+7 (000) 000 00-00");
})

document.getElementById("button-generate").onclick = () => {
    var alphabet = "qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM",
        pass = "",
        login = "";
    for (var i = 0; i < 6; i++)
        login += alphabet[Math.round(Math.random() * (alphabet.length - 1))];
    for (var i = 0; i < 12; i++)
        pass += alphabet[Math.round(Math.random() * (alphabet.length - 1))];
    document.getElementById("form-login").setAttribute("value", login);
    document.getElementById("form-login").value = login;
    document.getElementById("form-password").value = pass;
}