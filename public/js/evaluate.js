// Sao đánh giá
const productReviews = document.querySelectorAll('.product-review');
productReviews.forEach(reviewContainer => {
    const stars = reviewContainer.querySelectorAll('.star-rating .star');
    const selectedRatingInput = reviewContainer.querySelector('.selected_rating');
    // console.log(stars, selectedRatingInput)


    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            const ratingValue = parseInt(this.dataset.rating);
            highlightStars(stars, ratingValue);
            console.log(stars, ratingValue)

        });

        star.addEventListener('click', function () {
            const ratingValue = parseInt(this.dataset.rating);
            setSelectedRating(selectedRatingInput, ratingValue);
        });

        star.addEventListener('mouseout', function () {
            const currentRating = parseInt(selectedRatingInput.value);
            highlightStars(stars, currentRating);
        });
    });

    // Hiển thị 5 sao mờ ban đầu cho mỗi đánh giá
    highlightStars(stars, parseInt(selectedRatingInput.value));
});

// Tô màu
function highlightStars(starElements, rating) {
    starElements.forEach(star => {
        const starValue = parseInt(star.dataset.rating);
        if (starValue <= rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

function setSelectedRating(ratingInput, rating) {
    ratingInput.value = rating;
}

// Xem trước ảnh
const imageInputs = document.querySelectorAll('.images');
// const previewContainer = document.getElementById('previewImages');
// console.log(imageInputs)

imageInputs.forEach(image => {
    image.addEventListener('change', function () {
        const previewContainer = image.parentElement.querySelector(".previewImages");
        console.log(image, image.parentElement.querySelector(".previewImages"))
        previewContainer.innerHTML = ''; // Xóa ảnh xem trước cũ

        const files = this.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function (event) {
                const image = document.createElement('img');
                image.src = event.target.result;
                image.style.width = '7rem'; // Tùy chỉnh kích thước ảnh
                previewContainer.appendChild(image);
            }

            reader.readAsDataURL(file);
        }
    });
})

