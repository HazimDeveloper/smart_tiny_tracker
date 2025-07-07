// Toggle search bar
const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});