const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
  });
  
document.getElementById('useMoneyForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const userConfirm = confirm("Do you have another transaction?");
  
  if (userConfirm) {
    // Reload same page
    window.location.href = "usemoney.php";
  } else {
    // Go to cashflow page
    window.location.href = "cashflow.php";
  }
});