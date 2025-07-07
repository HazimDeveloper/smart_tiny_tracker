const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
});
function handleSubmit() {
  const target = 2000; 
  const input = parseFloat(document.getElementById("amount").value);
  
  if (isNaN(input) || input <= 0) {
    alert("Please enter a valid amount!");
    return;
  }

  const remaining = Math.max(0, target - input);
  const daysLeft = Math.ceil(remaining / 100); 

  document.getElementById("remaining").textContent = `RM ${remaining}`;
  document.getElementById("daysLeft").textContent = daysLeft;

  document.getElementById("resultBox").style.display = "block";
}