const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.addEventListener("DOMContentLoaded", function () {
  const ctx = document.getElementById("cashflowChart").getContext("2d");

  if (!ctx || typeof Chart === 'undefined') {
    console.error("Chart context not found or Chart.js not loaded.");
    return;
  }

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: categoryLabels,
      datasets: [{
        label: 'Expenses',
        data: cashflowData,
        backgroundColor: ['orange', 'violet', 'red', 'blue', 'green'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.label}: RM ${context.parsed}`;
            }
          }
        }
      }
    }
  });
});

console.log("Category Labels:", categoryLabels);
console.log("Cashflow Data:", cashflowData);
console.log("Chart.js loaded:", typeof Chart !== 'undefined');

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
});