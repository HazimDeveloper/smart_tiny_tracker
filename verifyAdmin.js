// Toggle search bar
const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.addEventListener("DOMContentLoaded", function () {
  const forgotPassForm = document.querySelector("form");
  const cancelBtn = document.querySelector(".btnCancel");

  // Redirect to reset page on submit
  forgotPassForm.addEventListener("submit", function (e) {
    e.preventDefault();
    window.location.href = "resetAdmin.html";
  });

  // Redirect to login page on cancel click
  cancelBtn.addEventListener("click", function (e) {
    e.preventDefault();
    window.location.href = "adminLogin.html";
  });
});