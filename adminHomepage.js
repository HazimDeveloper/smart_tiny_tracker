const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
});