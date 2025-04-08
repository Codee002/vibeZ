function formConfirm(delivery, payMethod) {
    let check = 1;
    const deliveryInput = document.getElementById(delivery)
    const payMethodInput = document.getElementById(payMethod)
    const errors = document.getElementById('errors')
    const errorsContainer = errors.parentElement
    console.log(errorsContainer)
    let errorMessage = ""

    if (deliveryInput.value.trim() === "") {
        errorMessage = "<li>Vui lòng chọn địa chỉ nhận hàng</li><br>"
        console.log(errorMessage)
        check = 0;
    }


    if (payMethodInput.value === "") {
        errorMessage += "<li>Vui lòng chọn phương thức thanh toán</li><br>"
        console.log(errorMessage)
        check = 0;
    }

    errorMessage = errorMessage.replace(/<br>$/, '')
    errors.innerHTML = errorMessage;
    if (check == 0) {
        errorsContainer.classList.add("alert-danger", 'alert' ,'mb-4')
        window.scrollTo(0, 0);
        return false;
    }
    return true;
}

// formConfirm('delivery', 'payMethod')