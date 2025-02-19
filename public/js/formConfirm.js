// Validate email
function emailValidate(id) {
    let input = document.getElementById(id);
    if (input == null)
        return;
    let inputParent = input.parentElement;
    let errorMessage = inputParent.querySelector(".invalid-feedback");
    let checkActiveEmail = document.getElementById("check_active_email");
    input.onchange = (e) => {
        checkActiveEmail.style.display = "none";
    }

    input.onblur = (e) => {
        if (input.value.trim().length == 0) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Vui lòng không để trống !"
        }
        else if (/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(input.value) == false) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Email không hợp lệ !";
        }
        else {
            input.classList.remove("is-invalid");
            errorMessage.textContent = ""
        }
    }
    input.oninput = () => {
        input.classList.remove("is-invalid");
        errorMessage.textContent = "";
    }
}

// Validate phone
function phoneValidate(id) {
    let input = document.getElementById(id);
    if (input == null)
        return;
    let inputParent = input.parentElement;
    let errorMessage = inputParent.querySelector(".invalid-feedback");
    input.onblur = (e) => {
        if (input.value.trim().length == 0) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Vui lòng không để trống !"
        }
        else if (/(84|0[3|5|7|8|9])+([0-9]{8})\b/g.test(input.value) == false) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Số điện thoại không hợp lệ !";
        }
        else {
            input.classList.remove("is-invalid");
            errorMessage.textContent = ""
        }
    }
    input.oninput = () => {
        input.classList.remove("is-invalid");
        errorMessage.textContent = "";
    }
}

// Validate name
function nameValidate(id) {
    let input = document.getElementById(id);
    if (input == null)
        return;
    let inputParent = input.parentElement;
    let errorMessage = inputParent.querySelector(".invalid-feedback");
    input.onblur = (e) => {
        if (input.value.trim().length == 0) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Vui lòng không để trống !"
        }
        else if (/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/i.test(input.value) == false) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Họ tên không hợp lệ !";
        }
        else {
            input.classList.remove("is-invalid");
            errorMessage.textContent = ""
        }
    }
    input.oninput = () => {
        input.classList.remove("is-invalid");
        errorMessage.textContent = "";
    }
}

// Validate address
function addressValidate(id) {
    let input = document.getElementById(id);
    if (input == null)
        return;
    let inputParent = input.parentElement;
    let errorMessage = inputParent.querySelector(".invalid-feedback");
    input.onblur = (e) => {
        if (input.value.trim().length == 0) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Vui lòng không để trống !"
        }
        else if (/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/i.test(input.value) == false) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Địa chỉ không hợp lệ !";
        }
        else {
            input.classList.remove("is-invalid");
            errorMessage.textContent = ""
        }
    }
    input.oninput = () => {
        input.classList.remove("is-invalid");
        errorMessage.textContent = "";
    }
}

// Validate gender
function genderValidate(name) {
    let check = 0;
    let inputs = document.getElementsByName(name);
    if (input == null)
        return;
    let errorMessage;

    inputs.forEach((e) => {
        if (e.checked) {
            check = 1;
        }
        errorMessage = e.parentElement.querySelector(".invalid-feedback");
    })
    if (check == 0) {
        errorMessage.textContent = "Vui lòng không để trống !"
        return false;
    }
    return true;
}

// Validate birthday
function birthdayValidate(id) {
    let check = 1;
    let input = document.getElementById(id);
    if (input == null)
        return;
    let inputParent = input.parentElement;
    let errorMessage = inputParent.querySelector(".invalid-feedback");

    // Lấy ra thời gian
    let date = new Date();
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();
    let dayString = year + "-" + month + "-" + day;

    if (input.value == 0) {
        input.classList.add("is-invalid");
        errorMessage.textContent = "Vui lòng không để trống !"
        check = 0;
    }
    else if (input.value >= dayString) {
        input.classList.add("is-invalid");
        errorMessage.textContent = "Thời gian phải nhỏ hơn ngày hiện tại !"
        check = 0;
    }
    else {
        input.classList.remove("is-invalid");
        errorMessage.textContent = ""
    }
    if (check)
        return true;
    return false;
}

// Validate password
function oldpassValidate(id) {
    let input = document.getElementById(id);
    if (input == null)
        return;
    let inputParent = input.parentElement;
    let errorMessage = inputParent.querySelector(".invalid-feedback");
    input.onblur = (e) => {
        if (input.value.trim().length == 0) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Vui lòng không để trống !"
        }
        else {
            input.classList.remove("is-invalid");
            errorMessage.textContent = ""
        }
    }
    input.oninput = () => {
        input.classList.remove("is-invalid");
        errorMessage.textContent = "";
    }
}
function newpassValidate(id) {
    let input = document.getElementById(id);
    if (input == null)
        return;
    let inputParent = input.parentElement;
    let errorMessage = inputParent.querySelector(".invalid-feedback");
    input.onblur = (e) => {
        if (input.value.trim().length == 0) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Vui lòng không để trống !"
        }
        else if (input.value.length < 8) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Mật khẩu phải lớn hơn 8 ký tự !";
        }
        else {
            input.classList.remove("is-invalid");
            errorMessage.textContent = ""
        }
    }
    input.oninput = () => {
        input.classList.remove("is-invalid");
        errorMessage.textContent = "";
    }
}
function passwordConfirm(id_passconfirm, id_match) {
    let input = document.getElementById(id_passconfirm);
    if (input == null)
        return;
    let match = document.getElementById(id_match)
    let inputParent = input.parentElement;
    let errorMessage = inputParent.querySelector(".invalid-feedback");
    input.onblur = (e) => {
        if (input.value.trim().length == 0) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Vui lòng không để trống !"
        }
        else if (input.value != match.value) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Mật khẩu nhập lại không đúng !";
        }
        else {
            input.classList.remove("is-invalid");
            errorMessage.textContent = ""
        }
    }
    input.oninput = () => {
        input.classList.remove("is-invalid");
        errorMessage.textContent = "";
    }
}
// formConFirm
function formConfirm(arrId = []) {
    let check = 1;
    arrId.forEach((e) => {
        var input = document.getElementById(e);
        var inputParent = input.parentElement;
        var errorMessage = inputParent.querySelector(".invalid-feedback");
        if (input.value.trim().length == 0) {
            input.classList.add("is-invalid");
            errorMessage.textContent = "Vui lòng không để trống !";
            check = 0;
        }

        if (input.classList.contains("is-invalid")) {
            check = 0;
        }
    })
    if (check == 0)
        return false;
    return true;
}



addressValidate("address");
phoneValidate("phone_number");
nameValidate("name");
emailValidate("email");
oldpassValidate("oldpass");
newpassValidate("password");
passwordConfirm("password_confirm", "password");