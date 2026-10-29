document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.nav-links');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', String(open));
    });
  }

  const comment = document.getElementById('comment_text');
  const counter = document.getElementById('char-count');
  if (comment && counter) {
    const update = () => { counter.textContent = String(comment.value.length); };
    comment.addEventListener('input', update);
    update();
  }

  // Friendly client-side feedback; PHP validates every submitted value again.
  document.querySelectorAll('form').forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        form.reportValidity();
      }
    });
  });
});
