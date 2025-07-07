// Toggle search bar
const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});
document.addEventListener("DOMContentLoaded", function () {
  const registerForm = document.querySelector("form");

  registerForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // Show popup registered
    alert("You've successfully reset your password");

    // akan redirect to login page after registered
    window.location.href = "login.html";
  });
});