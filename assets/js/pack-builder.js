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

    // 2. Add Clear Button (only if not already added)
    const table = summaryBody.closest('table');
    if (table && !document.querySelector('.build-pack__clear')) {
      const clearBtn = document.createElement('button');
      clearBtn.type = 'button';
      clearBtn.className = 'btn btn-secondary build-pack__clear';
      clearBtn.textContent = 'Clear Pack';
      clearBtn.style.marginTop = '16px';
      clearBtn.style.fontSize = '12px';
      clearBtn.style.padding = '8px 16px';
      table.parentNode.insertBefore(clearBtn, table.nextSibling);

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
    if (!selections.size) {
      const row = document.createElement('tr');
      row.className = 'build-pack__empty';
      const cell = document.createElement('td');
      cell.colSpan = 4;
      cell.textContent = builder.dataset.emptyMessage || 'Add components to start configuring your pack.';
      row.appendChild(cell);
      summaryBody.appendChild(row);
      countTarget.textContent = '0';
      casesTarget.textContent = '0';
      return;
    }

    let totalQty = 0;
    let totalCases = 0;

    selections.forEach((item, name) => {
      const row = document.createElement('tr');
      const qty = item.qty;
      const cases = Math.max(1, Math.ceil(qty / item.units));

      totalQty += qty;
      totalCases += cases;

      row.innerHTML = `
        <td>${name}</td>
        <td>${qty}</td>
        <td>${cases}</td>
        <td><button type="button" class="build-pack__remove" data-pack-remove="${name}">Remove</button></td>
      `;

      summaryBody.appendChild(row);
    });

    countTarget.textContent = totalQty.toString();
    casesTarget.textContent = totalCases.toString();
  };

  const addComponent = (name, units) => {
    if (!name || !units) return;
    const existing = selections.get(name) || { qty: 0, units: parseInt(units, 10) || 1 };
    existing.qty += 1;
    selections.set(name, existing);
    refreshSummary();
  };

  const removeComponent = (name) => {
    if (!selections.has(name)) {
      return;
    }
    selections.delete(name);
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
