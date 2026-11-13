document.querySelectorAll('[data-confirm]').forEach((element) => {
  element.addEventListener('click', (event) => {
    if (!window.confirm(element.dataset.confirm)) event.preventDefault();
  });
});
document.querySelectorAll('[data-filter]').forEach((input) => {
  input.addEventListener('input', () => {
    const term = input.value.toLowerCase().trim();
    document.querySelectorAll('[data-filter-item]').forEach((item) => {
      item.hidden = term !== '' && !item.textContent.toLowerCase().includes(term);
    });
  });
});
