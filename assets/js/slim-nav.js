(function () {
  const toggle = document.querySelector('[data-slim-toggle]');
  const nav = document.querySelector('[data-slim-nav]');
  if (!nav) return;
  const groupToggles = Array.from(nav.querySelectorAll('[data-mega-toggle]'));
  const panels = Array.from(nav.querySelectorAll('[data-mega-panel]'));

  function closePanels() {
    groupToggles.forEach((btn) => btn.classList.remove('is-open'));
    panels.forEach((panel) => panel.classList.remove('is-open'));
  }

  function closeNav() {
    if (toggle) {
      toggle.setAttribute('aria-expanded', 'false');
    }
    nav.classList.remove('open');
    document.body.classList.remove('slim-nav-open');
    closePanels();
  }

  if (toggle) {
    toggle.addEventListener('click', function () {
      const open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.classList.toggle('slim-nav-open', open);
      if (!open) {
        closePanels();
      }
    });
  }

  groupToggles.forEach((btn) => {
    const item = btn.closest('.mega-nav__item');
    const panel = item ? item.querySelector('[data-mega-panel]') : null;
    if (!panel) return;
    /* User requested hover-only behavior. Disabling click toggle.
    btn.addEventListener('click', function (event) {
      event.stopPropagation();
      const shouldOpen = !btn.classList.contains('is-open');
      closePanels();
      if (shouldOpen) {
        btn.classList.add('is-open');
        panel.classList.add('is-open');
      }
    });
    */
  });

  document.addEventListener('click', function (event) {
    if (!nav.contains(event.target) && event.target !== toggle) {
      closePanels();
      if (nav.classList.contains('open')) {
        closeNav();
      }
    }
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      closeNav();
    }
  });

  const poToggle = document.querySelector('[data-portal-po-toggle]');
  const poModal = document.querySelector('[data-portal-po-modal]');
  if (poToggle && poModal) {
    const close = poModal.querySelector('[data-portal-po-close]');
    poToggle.addEventListener('click', function () {
      poModal.classList.add('is-visible');
    });
    if (close) {
      close.addEventListener('click', function () {
        poModal.classList.remove('is-visible');
      });
    }
    poModal.addEventListener('click', function (event) {
      if (event.target === poModal) {
        poModal.classList.remove('is-visible');
      }
    });
  }
})();
