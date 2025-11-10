const openModal = document.getElementById('openModal');
const closeModal = document.getElementById('closeModal');
const modalOverlay = document.getElementById('modalOverlay');

// Ouvrir le popup
openModal.addEventListener('click', (e) => {
  e.preventDefault();
  modalOverlay.classList.add('active'); // 👈 affiche le modal
});

// Fermer via le bouton "X"
closeModal.addEventListener('click', () => {
  modalOverlay.classList.remove('active'); // 👈 cache le modal
});

// Fermer en cliquant à l’extérieur du popup
modalOverlay.addEventListener('click', (e) => {
  if (e.target === modalOverlay) {
    modalOverlay.classList.remove('active');
  }
});
