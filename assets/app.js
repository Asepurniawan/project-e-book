const modal = document.querySelector('#memberModal');
const toast = document.querySelector('#toast');
const form = document.querySelector('#memberForm');
const error = document.querySelector('#formError');

function showToast(message) {
  toast.textContent = message;
  toast.classList.add('show');
  window.setTimeout(() => toast.classList.remove('show'), 3500);
}

function openModal() {
  modal.hidden = false;
  modal.querySelector('input').focus();
}

document.querySelector('#openMember').addEventListener('click', openModal);
document.querySelector('.modal-close').addEventListener('click', () => { modal.hidden = true; });
modal.addEventListener('click', (event) => { if (event.target === modal) modal.hidden = true; });

async function postForm(data) {
  const response = await fetch('api.php', { method: 'POST', body: data });
  const result = await response.json();
  if (!response.ok || !result.success) throw new Error(result.message || 'Permintaan gagal.');
  return result;
}

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  error.textContent = '';
  if (!form.checkValidity()) {
    error.textContent = 'Lengkapi nama dan gunakan email yang valid.';
    form.reportValidity();
    return;
  }
  const data = new FormData(form);
  data.append('action', 'register');
  try {
    const result = await postForm(data);
    modal.hidden = true;
    form.reset();
    showToast(result.message);
  } catch (requestError) {
    error.textContent = requestError.message;
  }
});

document.querySelectorAll('.borrow-button').forEach((button) => {
  button.addEventListener('click', async () => {
    const data = new FormData();
    data.append('action', 'borrow');
    data.append('title', button.dataset.bookTitle);
    try {
      const result = await postForm(data);
      showToast(result.message);
    } catch (requestError) {
      showToast(requestError.message);
    }
  });
});

function filterBooks() {
  const term = document.querySelector('#searchInput').value.toLowerCase().trim();
  const category = document.querySelector('#categoryFilter').value;
  let visible = 0;
  document.querySelectorAll('.book-card').forEach((card) => {
    const matches = (!term || card.dataset.title.includes(term) || card.dataset.author.includes(term))
      && (!category || card.dataset.category === category);
    card.hidden = !matches;
    if (matches) visible += 1;
  });
  document.querySelector('#emptyState').hidden = visible !== 0;
}
document.querySelector('#searchInput').addEventListener('input', filterBooks);
document.querySelector('#categoryFilter').addEventListener('change', filterBooks);
