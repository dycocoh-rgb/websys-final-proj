// Auto-hide alerts after 4 seconds
document.addEventListener('DOMContentLoaded', function () {
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(function (alert) {
    setTimeout(function () {
      alert.style.opacity = '0';
      alert.style.transition = 'opacity 0.5s';
      setTimeout(function () { alert.remove(); }, 500);
    }, 4000);
  });

  // Role card selection
  const roleCards = document.querySelectorAll('.role-card');
  roleCards.forEach(function (card) {
    card.addEventListener('click', function () {
      roleCards.forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
      const input = document.getElementById('selected_role');
      if (input) input.value = card.dataset.role;
    });
  });

  // Search filter for tables
  const searchInput = document.getElementById('tableSearch');
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      const q = this.value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach(function (row) {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
      });
    });
  }
});
