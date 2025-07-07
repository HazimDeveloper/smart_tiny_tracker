const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
});

// Form submission handling - now just submits normally without popup
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        // Validate form data
        const category = document.querySelector('input[name="category"]:checked');
        const amount = document.querySelector('input[name="amount"]').value;
        
        if (!category) {
            e.preventDefault();
            alert('Please select a category.');
            return;
        }
        
        if (!amount || amount <= 0) {
            e.preventDefault();
            alert('Please enter a valid amount.');
            return;
        }
        
        // Form is valid, let it submit normally
        // The PHP script will handle the redirect to cashflow.php
    });
});