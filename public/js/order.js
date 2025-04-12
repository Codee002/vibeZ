function formConfirm(delivery, payMethod) {
    let check = 1;
    const deliveryInput = document.querySelectorAll('input[name=' + delivery + ']')
    const payMethodInput = document.getElementById(payMethod)
    const errors = document.getElementById('errors')
    const errorsContainer = errors.parentElement
    let errorMessage = ""

    console.log(deliveryInput)
    if (deliveryInput.length == 0) {
        errorMessage = "<li>Vui lòng chọn địa chỉ nhận hàng</li>"
        console.log(errorMessage)
        check = 0;
    }
    let radioCheck = 0;
    deliveryInput.forEach(e => {
        if (e.checked) {
            radioCheck = 1;
        }
    })
    if (radioCheck == 0) {
        errorMessage = "<li>Vui lòng chọn địa chỉ nhận hàng</li>"
        console.log(errorMessage)
        check = 0;
    }



    if (payMethodInput.value === "") {
        errorMessage += "<li>Vui lòng chọn phương thức thanh toán</li>"
        console.log(errorMessage)
        check = 0;
    }

    errorMessage = errorMessage.replace(/<br>$/, '')
    errors.innerHTML = errorMessage;
    if (check == 0) {
        errorsContainer.classList.add("alert-danger", 'alert', 'mb-4')
        window.scrollTo(0, 0);
        return false;
    }
    return true;
}
// formConfirm('delivery', 'payMethod')
