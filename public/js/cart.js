const cartCheckBoxs = document.querySelectorAll('.cartCheckBox');
const orderButton = document.getElementById('btn-submit');

cartCheckBoxs.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        let isCheck = false;

        cartCheckBoxs.forEach(checkbox => {
            if (checkbox.checked) {
                isCheck = true;
            }
        });

        orderButton.disabled = !isCheck;
    });
});
