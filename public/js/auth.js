// Hide, show Password
let eyeElements = document.querySelectorAll(".pwd-eye");
let inputPassword = document.getElementById("pwd");

eyeElements.forEach((eye) =>
{
    let parent = eye.parentElement;
    eye.onclick = (e) =>
    {
        let passInput = parent.querySelector("input");

        // Ẩn, hiện mật khẩu
        if (passInput.type == "password")
        {
            passInput.type = "text";
            eye.classList.replace("fa-eye", "fa-eye-slash");
        }
        else
        {
            passInput.type = "password";
            eye.classList.replace("fa-eye-slash", "fa-eye");
        }
}})

// Load lại capcha
function reloadCapcha()
{
    $("#capcha-group").load(window.location.href + " #capcha-group > *", function(){});
}