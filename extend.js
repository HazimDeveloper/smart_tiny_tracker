const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
  });

function submitExtend() {
  const amount = document.getElementById("goalAmount").value;
  const date = document.getElementById("goalDate").value;

  if (!amount || !date) {
    alert("Please fill in all fields!");
    return;
  }

alert(`Goal extended!\nAmount: ${amount}\nDue: ${date}`);
}