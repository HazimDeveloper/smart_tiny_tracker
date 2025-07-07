// Toggle search bar
const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.addEventListener("DOMContentLoaded", function () {
  const forgotPassForm = document.querySelector("form");

  forgotPassForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // Show popup
    alert("A verification code has sent to ********36g.gmail.com");

    // direct to reset page
    window.location.href = "verifyAdmin.html";
  });
});