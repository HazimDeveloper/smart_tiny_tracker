document.addEventListener('DOMContentLoaded', () => { 
const searchIcon = document.getElementById('search');
const searchBox = document.querySelector('.search');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

var goalSwiper = new Swiper(".home-row", {
  slidesPerView: 1,
  spaceBetween: 15,
  loop: true,
  centeredSlides: true,
  speed: 800,
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },
  breakpoints: {
    /* 0: {
      slidesPerView: 2,
      spaceBetween: 14,
    }, */
    768: {
      slidesPerView: 2,
      spaceBetween: 15,
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 15,
    },
  }, 
}); 

const stars = document.querySelectorAll('.star-rating input');
const ratingValue = document.getElementById('ratingValue');

stars.forEach(star => {
  star.addEventListener('change', function () {
    ratingValue.textContent = `You rated ${this.value} star${this.value > 1 ? 's' : ''}.`;
  });
});

document.querySelectorAll('.track').forEach(button => {
  button.addEventListener('click', (e) => {
    const goalCard = e.target.closest('.goal-card');
    const goalTitle = goalCard.querySelector('h3').innerText;
    const goalId = goalCard.dataset.goalId;
    
    const modal = document.getElementById('trackModal');
    const modalButtons = modal.querySelector('.modal-buttons');

    modal.querySelector('h2').innerText = `What would you like to do for ${goalTitle}?`;
    modalButtons.innerHTML = '';     // clear previous buttons

    // Dynamically create Add Money button
      const addBtn = document.createElement('button');
      addBtn.textContent = 'Add Money';
      addBtn.addEventListener('click', () => {
        window.location.href = `addmoney.php?goal_id=${goalId}`;
      });

      // Dynamically create Use Money button
      const useBtn = document.createElement('button');
      useBtn.textContent = 'Use Money';
      useBtn.addEventListener('click', () => {
        window.location.href = `usemoney.php?goal_id=${goalId}`;
      });

      modalButtons.appendChild(addBtn);
      modalButtons.appendChild(useBtn);

      modal.style.display = 'block';
    });
  });
});

document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
    window.location.href = 'logout.php';
});

function closeModal() {
  document.getElementById('trackModal').style.display = 'none';
}