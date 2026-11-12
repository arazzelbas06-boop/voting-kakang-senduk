document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', event => {
      if (!confirm(el.dataset.confirm || 'Apakah kamu yakin?')) event.preventDefault();
    });
  });

  const success = document.querySelector('[data-vote-success]');
  if (success) {
    const colors = ['#d8b66c', '#f0d99e', '#101e39', '#7fb3d5', '#e98b8b'];
    for (let i = 0; i < 28; i++) {
      const piece = document.createElement('span');
      piece.className = 'confetti-piece';
      piece.style.setProperty('--x', `${(Math.random() - 0.5) * 520}px`);
      piece.style.setProperty('--y', `${180 + Math.random() * 180}px`);
      piece.style.setProperty('--r', `${Math.random() * 720 - 360}deg`);
      piece.style.background = colors[i % colors.length];
      success.appendChild(piece);
    }
  }

  const voteForm = document.querySelector('#bulk-vote-form');
  if (voteForm) {
    const boxes = [...voteForm.querySelectorAll('.candidate-checkbox')];
    const count = voteForm.querySelector('#vote-selection-count');
    voteForm.querySelector('button[type="submit"]').textContent = 'Kirim pilihan';
    const updateCount = () => {
      const selected = boxes.filter(box => box.checked).length;
      count.textContent = selected + ' kontestan dipilih';
    };
    boxes.forEach(box => box.addEventListener('change', () => {
      if (box.checked) boxes.filter(other => other !== box).forEach(other => { other.checked = false; });
      updateCount();
    }));
    voteForm.addEventListener('submit', event => {
      if (!boxes.some(box => box.checked)) {
        event.preventDefault();
        alert('Pilih minimal satu kontestan terlebih dahulu.');
      }
    });
  }
});
