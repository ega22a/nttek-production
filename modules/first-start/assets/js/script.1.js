document.getElementById("button-hs-pass").onclick = () => {
    if (document.getElementById("form-password").getAttribute("type") == "text") {
        document.getElementById("form-password").setAttribute("type", "password");
        document.getElementById("i-b-password").setAttribute("class", "far fa-eye");
    } else {
        document.getElementById("form-password").setAttribute("type", "text");
        document.getElementById("i-b-password").setAttribute("class", "far fa-eye-slash");
    }
};