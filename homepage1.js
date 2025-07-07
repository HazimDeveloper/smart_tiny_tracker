// Toggle search bar
const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});
var swiper = new Swiper(".about-row", {
    spaceBetween: 25,
    loop:true,
    centeredSlides:true,
    autoplay:{
        delay:2000,
        disableOnInteraction:false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
    },
  });
  var swiper = new Swiper(".services-row", {
    spaceBetween: 30,
    loop:true,
    centeredSlides:true,
    autoplay:{
        delay:7000,
        disableOnInteraction:false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
  nextEl: ".swiper-button-next",
  prevEl: ".swiper-button-prev",
},
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 1,
      },
      1024: {
        slidesPerView: 1,
      },
    },
  });
  var swiper = new Swiper(".review-row", {
    spaceBetween: 30,
    loop:true,
    centeredSlides:true,
    autoplay:{
        delay:2500,
        disableOnInteraction:false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
    },
  });
  document.addEventListener("DOMContentLoaded", function () {
  const loginBtn = document.getElementById("loginChoiceBtn");

  loginBtn.addEventListener("click", function () {
    const userType = confirm("Are you a customer? Click OK for Customer or Cancel for Admin.");

    if (userType) {
      // OK clicked(cust)
      window.location.href = "login.php";
    } else {
      // Cancel clicked (admin)
      window.location.href = "adminLogin.php";
    }
  });
});