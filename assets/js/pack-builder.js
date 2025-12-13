document.addEventListener('DOMContentLoaded', () => {
  const builder = document.querySelector('.build-pack');
  if (!builder) {
    return;
  }

  const components = builder.querySelectorAll('[data-pack-component]');
  const dropzone = builder.querySelector('[data-pack-dropzone]');
  const summaryBody = builder.querySelector('[data-pack-summary]');
  const countTarget = builder.querySelector('[data-pack-count]');
  const casesTarget = builder.querySelector('[data-pack-cases]');
  const pdfBtn = builder.querySelector('[data-pack-pdf]');

  const selections = new Map();

  // Helper: Poll for elements to ensure they exist before modification
  const runVisualFixes = (retries = 10) => {
    // 1. Hide "Configurator" text (Aggressive check)
    const elementsToCheck = document.querySelectorAll('.section-eyebrow, .eyebrow, h6, span, p, div, small');
    let foundConfig = false;
    elementsToCheck.forEach(el => {
      if (el.textContent && (el.textContent.trim().toUpperCase() === 'CONFIGURATOR' || el.textContent.trim().toUpperCase() === 'CPNFIGURATOR')) {
        el.style.display = 'none';
        foundConfig = true;
      }
    });

    // 2. Clear Button Logic
    const clearBtn = document.querySelector('.build-pack__clear');
    if (clearBtn) {
      clearBtn.addEventListener('click', () => {
        selections.clear();
        refreshSummary();
      });
    }


    // 3. Remove "A partner built for accountability" section
    const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
    let foundAccountability = false;
    let foundMilestone = false;

    headings.forEach(h => {
      // Robust text check
      const text = h.textContent ? h.textContent.toLowerCase() : '';

      if (text.includes('partner built for accountability')) {
        const section = h.closest('section') || h.closest('div.page-section') || h.closest('div.florence-section') || h.parentElement.parentElement;
        if (section) {
          section.style.display = 'none';
          foundAccountability = true;
        } else {
          // Direct fallback
          h.style.display = 'none';
          let sibling = h.nextElementSibling;
          while (sibling && (sibling.tagName === 'P' || sibling.tagName === 'UL')) {
            sibling.style.display = 'none';
            sibling = sibling.nextElementSibling;
          }
        }
      }

      // 4. Adjust padding on "Sourcing Milestone" card
      if (text.includes('sourcing milestone')) {
        let card = h.closest('.card') || h.closest('.callout') || h.closest('div[class*="copy"]');
        if (!card && h.parentElement && h.parentElement.classList.contains('callout')) {
          card = h.parentElement;
        }

        if (card) {
          card.style.padding = '48px';
          foundMilestone = true;
        }
      }
    });

    // Retry if critical elements not found and we have retries left
    if ((!foundConfig || !foundAccountability || !foundMilestone) && retries > 0) {
      setTimeout(() => runVisualFixes(retries - 1), 200);
    }
  };

  runVisualFixes();

  const refreshSummary = () => {
    summaryBody.innerHTML = '';
    const quoteBtn = document.querySelector('.build-pack__btn--primary');

    // Clear State Handling
    if (!selections.size) {
      summaryBody.innerHTML = `
        <tr class="build-pack__empty">
            <td colspan="4">
                <div class="build-pack__empty-state">
                    <div class="empty-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <p>Your pack is empty</p>
                    <span>Click + or drag items to start</span>
                </div>
            </td>
        </tr>`;

      countTarget.textContent = '0';
      casesTarget.textContent = '0';

      // Reset Quote Link
      if (quoteBtn && quoteBtn.tagName === 'A') {
        quoteBtn.classList.add('disabled');
        quoteBtn.style.opacity = '0.5';
        quoteBtn.style.pointerEvents = 'none';
        quoteBtn.href = '#';
      }
      return;
    }

    // Active State Handling
    if (quoteBtn) {
      quoteBtn.classList.remove('disabled');
      quoteBtn.style.opacity = '1';
      quoteBtn.style.pointerEvents = 'auto';
    }

    let totalQty = 0;
    let totalCases = 0;
    const quoteItems = [];

    selections.forEach((item, name) => {
      const row = document.createElement('tr');
      const qty = item.qty;
      const cases = Math.ceil(qty / item.units);

      totalQty += qty;
      totalCases += cases;

      // Build quote payload: "ItemName:Qty"
      quoteItems.push(`${encodeURIComponent(name)}:${qty}`);

      row.innerHTML = `
        <td><span style="font-weight:500; color:#334155; font-size:13px;">${name}</span></td>
        <td>${qty}</td>
        <td>${cases}</td>
        <td style="text-align:right;"><button type="button" class="build-pack__remove" data-pack-remove="${name}" aria-label="Remove item">Remove</button></td>
      `;

      summaryBody.appendChild(row);
    });

    countTarget.textContent = totalQty.toString();
    casesTarget.textContent = totalCases.toString();

    // Update Quote Link with Payload
    if (quoteBtn && quoteBtn.tagName === 'A') {
      const baseUrl = quoteBtn.getAttribute('data-base-url') || '/request-quote/';
      // Construct a URL with query params
      const finalUrl = `${baseUrl}?pack_items=${quoteItems.join('|')}&total_cases=${totalCases}`;
      quoteBtn.href = finalUrl;
    }
  };

  const addComponent = (name, units) => {
    if (!name || !units) return;
    const parsedUnits = parseInt(units, 10) || 1;

    // Safety check for invalid units
    if (parsedUnits <= 0) return;

    const existing = selections.get(name) || { qty: 0, units: parsedUnits };
    existing.qty += 1; // Increment by 1 unit
    selections.set(name, existing);
    refreshSummary();
  };

  const removeComponent = (name) => {
    if (!selections.has(name)) {
      return;
    }
    selections.delete(name); // Remove entire item row for simplicity
    refreshSummary();
  };

  components.forEach((btn) => {
    const label = btn.dataset.packComponent;
    const units = btn.dataset.packUnits;

    btn.addEventListener('click', () => addComponent(label, units));

    btn.addEventListener('dragstart', (event) => {
      event.dataTransfer.setData('text/plain', JSON.stringify({ name: label, units }));
    });
  });

  if (dropzone) {
    dropzone.addEventListener('dragover', (event) => {
      event.preventDefault();
      dropzone.classList.add('is-active');
    });

    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('is-active'));

    dropzone.addEventListener('drop', (event) => {
      event.preventDefault();
      dropzone.classList.remove('is-active');
      try {
        const payload = JSON.parse(event.dataTransfer.getData('text/plain'));
        addComponent(payload.name, payload.units);
      } catch (error) {
        // ignore invalid payload
      }
    });
  }

  summaryBody.addEventListener('click', (event) => {
    const button = event.target.closest('[data-pack-remove]');
    if (!button) {
      return;
    }
    removeComponent(button.dataset.packRemove);
  });

  if (pdfBtn) {
    pdfBtn.addEventListener('click', () => {
      alert('PDF summary export coming soon. For now, include this pack in your quote and we\'ll send a formatted PDF.');
    });
  }

  refreshSummary();
});
