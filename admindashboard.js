// Toggle search bar visibility
const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

// Admin List
const adminList = [
  { name: "Noor Syahilah", role: "Programmer 2", id: "2023645432", activation: "/" },
  { name: "Nur Amnna", role: "Programmer 1", id: "2023624430", activation: "0" },
  { name: "Nur Najihah", role: "Project Manager", id: "2023624442", activation: "0" },
  { name: "Nurul Nuha", role: "Programmer 2", id: "2023324432", activation: "/" }
];

// admin table
const tableBody = document.getElementById("adminTableBody");

if (tableBody) {
  adminList.forEach(admin => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${admin.name}</td>
      <td>${admin.role}</td>
      <td>${admin.id}</td>
      <td>${admin.activation}</td>
    `;
    tableBody.appendChild(row);
  });
}

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
});