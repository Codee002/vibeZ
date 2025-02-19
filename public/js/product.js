const quantityInputs = document.querySelectorAll('.order__info__product__quantity input');
quantityInputs.forEach(input => {
  const minusButton = input.previousElementSibling;
  const plusButton = input.nextElementSibling;

  minusButton.addEventListener('click', () => {
    if (input.value > 1) {
      input.value--;
    }
  });

  plusButton.addEventListener('click', () => {
    input.value++;
  });
});