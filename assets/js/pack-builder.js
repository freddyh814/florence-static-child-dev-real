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
  const stateLabel = builder.querySelector('.build-pack__state');
  const previewPanel = builder.querySelector('.build-pack__preview');
  const previewName = builder.querySelector('.preview-name');

  // Create Toast Container
  let toastContainer = document.createElement('div');
  toastContainer.className = 'build-pack__toast-container';
  builder.appendChild(toastContainer);

  const selections = new Map();

  // --- Helpers ---
  const showToast = (message) => {
    // Remove existing
    const existing = builder.querySelector('.build-pack__toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'build-pack__toast is-active';
    toast.innerHTML = `
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
        <line x1="12" y1="9" x2="12" y2="13"/>
        <line x1="12" y1="17" x2="12.01" y2="17"/>
      </svg>
      <span>${message}</span>
    `;
    builder.appendChild(toast);

    setTimeout(() => {
      toast.classList.remove('is-active');
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  };

  const updateState = () => {
    if (!stateLabel) return;
    const count = Array.from(selections.values()).reduce((sum, item) => sum + item.qty, 0);
    const dot = stateLabel.querySelector('.state-dot');
    const text = stateLabel.querySelector('.state-text');

    if (count === 0) {
      stateLabel.setAttribute('data-pack-state', 'idle');
      text.textContent = 'Empty Pack';
    } else if (count > 0 && count < 3) { // Arbitrary threshold for "Building" vs "Ready"
      stateLabel.setAttribute('data-pack-state', 'building');
      text.textContent = 'Building...';
    } else {
      stateLabel.setAttribute('data-pack-state', 'ready');
      text.textContent = 'Ready to Quote';
    }
  };

  const checkGuardrails = () => {
    const items = Array.from(selections.values());
    if (items.length < 2) return;

    // 1. Mixed Sterile/Non-Sterile
    const hasSterile = items.some(i => i.sterile === true);
    const hasNonSterile = items.some(i => i.sterile === false);

    if (hasSterile && hasNonSterile) {
      showToast('Tip: Mixing sterile and non-sterile items complicates assembly.');
      return;
    }

    // 2. Level Incompatibility (Simple check)
    const levels = items.map(i => i.level).filter(l => l && l !== 'N/A');
    if (levels.includes('Level 4') && levels.includes('Level 1')) {
      showToast('Notice: Combining Level 1 and Level 4 gowns is uncommon.');
    }
  };

  // --- Interactivity ---
  const handleHover = (name, units, level, sterile) => {
    if (!previewPanel || !previewName) return;
    previewName.textContent = `${name} (${level !== 'N/A' ? level : ''} ${sterile ? 'Sterile' : 'Non-Sterile'})`;
    previewPanel.classList.add('is-visible');
  };

  const handleLeave = () => {
    if (!previewPanel) return;
    previewPanel.classList.remove('is-visible');
  };

  // --- Core Logic ---
  const refreshSummary = () => {
    summaryBody.innerHTML = '';
    const quoteBtn = document.querySelector('.build-pack__btn--primary');

    updateState();

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

    // Sort items by name for consistency
    const sortedKeys = Array.from(selections.keys()).sort();

    sortedKeys.forEach((name) => {
      const item = selections.get(name);
      const row = document.createElement('tr');
      const qty = item.qty;
      const cases = Math.ceil(qty / item.units);

      totalQty += qty;
      totalCases += cases;

      // Build quote payload: "ItemName:Qty"
      quoteItems.push(`${encodeURIComponent(name)}:${qty}`);

      row.innerHTML = `
        <td>
            <div style="display:flex; flex-direction:column;">
                <span style="font-weight:600; color:#334155; font-size:13px;">${name}</span>
                <span style="font-size:11px; color:#94a3b8;">${item.category} • ${item.level !== 'N/A' ? item.level : (item.sterile ? 'Sterile' : 'Non-Sterile')}</span>
            </div>
        </td>
        <td style="vertical-align:top; padding-top:12px;">${qty}</td>
        <td style="vertical-align:top; padding-top:12px;">${cases}</td>
        <td style="text-align:right; vertical-align:top; padding-top:10px;">
            <button type="button" class="build-pack__remove" data-pack-remove="${name}" aria-label="Remove item" 
            style="background:none; border:none; color:#ef4444; font-size:11px; font-weight:600; cursor:pointer;">Remove</button>
        </td>
      `;

      summaryBody.appendChild(row);
    });

    countTarget.textContent = totalQty.toString();
    casesTarget.textContent = totalCases.toString();

    // Update Quote Link with Payload
    if (quoteBtn && quoteBtn.tagName === 'A') {
      const baseUrl = quoteBtn.getAttribute('data-base-url') || '/request-quote/';
      const finalUrl = `${baseUrl}?pack_items=${quoteItems.join('|')}&total_cases=${totalCases}`;
      quoteBtn.href = finalUrl;
    }
  };

  const addComponent = (dataset) => {
    const { packComponent: name, packUnits: units, packCategory: category, packSterile, packLevel: level } = dataset;

    if (!name || !units) return;
    const parsedUnits = parseInt(units, 10) || 1;
    const isSterile = packSterile === 'true';

    // Safety check for invalid units
    if (parsedUnits <= 0) return;

    const existing = selections.get(name) || { qty: 0, units: parsedUnits, category, sterile: isSterile, level };
    existing.qty += 1; // Increment by 1 unit

    // Animate add
    const btn = Array.from(components).find(b => b.dataset.packComponent === name);
    if (btn) {
      btn.classList.add('is-active');
      setTimeout(() => btn.classList.remove('is-active'), 200);
    }

    selections.set(name, existing);

    checkGuardrails();
    refreshSummary();

    // Hide hint if exists
    const hint = document.querySelector('.build-pack__hint');
    if (hint) {
      hint.style.opacity = '0';
      setTimeout(() => hint.remove(), 500);
      localStorage.setItem('fl_pack_hint_seen', 'true');
    }
  };

  const removeComponent = (name) => {
    if (!selections.has(name)) {
      return;
    }
    selections.delete(name); // Remove entire item row for simplicity
    checkGuardrails();
    refreshSummary();
  };

  // --- Initialization ---

  // 1. First time hint
  if (!localStorage.getItem('fl_pack_hint_seen')) {
    const firstItem = components[0];
    if (firstItem) {
      const hint = document.createElement('div');
      hint.className = 'build-pack__hint is-visible';
      hint.textContent = 'Start by adding a base gown or drape';
      firstItem.style.position = 'relative';
      firstItem.appendChild(hint);
    }
  }

  // 2. Event Listeners
  components.forEach((btn) => {
    // Hover Preview
    btn.addEventListener('mouseenter', () => {
      handleHover(
        btn.dataset.packComponent,
        btn.dataset.packUnits,
        btn.dataset.packLevel,
        btn.dataset.packSterile === 'true'
      );
    });
    btn.addEventListener('mouseleave', handleLeave);

    // Click Add
    btn.addEventListener('click', () => addComponent(btn.dataset));

    // Drag Start
    btn.addEventListener('dragstart', (event) => {
      // Pass all data needed
      const payload = {
        name: btn.dataset.packComponent,
        units: btn.dataset.packUnits,
        category: btn.dataset.packCategory,
        sterile: btn.dataset.packSterile,
        level: btn.dataset.packLevel
      };
      event.dataTransfer.setData('text/plain', JSON.stringify(payload));
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
        const raw = event.dataTransfer.getData('text/plain');
        if (!raw) return;

        const payload = JSON.parse(raw);
        // Map payload back to dataset-like structure for consistency
        const dataset = {
          packComponent: payload.name,
          packUnits: payload.units,
          packCategory: payload.category,
          packSterile: payload.sterile,
          packLevel: payload.level
        };
        addComponent(dataset);
      } catch (error) {
        console.error('Drop error', error);
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
      alert('Generating PDF summary... (This would trigger a backend generation service)');
    });
  }

  // Clean up any remaining visual fixes just in case
  const clearBtn = document.querySelector('.build-pack__clear');
  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      selections.clear();
      refreshSummary();
    });
  }

  refreshSummary();
});
