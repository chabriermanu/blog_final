 const modalElement = document.querySelector('#commentModal');
if (modalElement) {
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}
addEventListener('click', () => {
    const target = img.dataset.target;
    if (target) openModal(target);
  });