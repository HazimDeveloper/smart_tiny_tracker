const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.addEventListener("DOMContentLoaded", function () {
  const ctx = document.getElementById("cashflowChart");

  if (!ctx) {
    console.error("Canvas element not found");
    return;
  }

  if (typeof Chart === 'undefined') {
    console.error("Chart.js not loaded");
    return;
  }

  // Check if data exists
  if (typeof cashflowData === 'undefined' || typeof categoryLabels === 'undefined') {
    console.error("Data not available");
    return;
  }

  // Filter out categories with zero amounts for better visualization
  const filteredData = [];
  const filteredLabels = [];
  const filteredColors = [];
  
  const colors = ['orange', 'violet', 'red', 'blue', 'green'];
  
  cashflowData.forEach((amount, index) => {
    if (amount > 0) {
      filteredData.push(amount);
      filteredLabels.push(categoryLabels[index]);
      filteredColors.push(colors[index]);
    }
  });

  // If no data, show a message
  if (filteredData.length === 0) {
    const chartContainer = ctx.parentElement;
    chartContainer.innerHTML = '<p style="text-align: center; font-size: 2rem; color: #04182d; margin-top: 50px;">No spending data available yet.<br>Start tracking your expenses!</p>';
    return;
  }

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: filteredLabels,
      datasets: [{
        label: 'Expenses',
        data: filteredData,
        backgroundColor: filteredColors,
        borderWidth: 2,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: false // We're using custom legend
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const percentage = ((context.parsed / total) * 100).toFixed(1);
              return `${context.label}: RM ${context.parsed.toFixed(2)} (${percentage}%)`;
            }
          }
        }
      }
    }
  });
});

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
});