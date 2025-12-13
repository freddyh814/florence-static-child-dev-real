<?php
/**
 * Front Page template.
 */

get_header();
$uploads = trailingslashit(get_theme_file_uri('assets/images'));
$media = trailingslashit(get_theme_file_uri('assets/media'));

$confidence_items = [
    ['value' => 'FDA-Compliant', 'label' => ''],
    ['value' => 'Denver 3PL', 'label' => ''],
    ['value' => 'USMCA Certified', 'label' => ''],
    ['value' => 'Competitive Pricing', 'label' => ''],
];

$capability_cards = [
    [
        'title' => 'Product portfolio & sourcing',
        'copy' => 'Gowns, masks, packs, and accessories engineered for AAMI PB70 and ASTM F2100 performance with importer-managed QA.',
        'points' => [
            'Sterile and non-sterile SKUs with bilingual packaging',
            'Component matrices tuned to OR, cath lab, OB, and trauma',
            'Private label and colorway options without sacrificing traceability',
        ],
    ],
    [
        'title' => 'Compliance & onboarding',
        'copy' => 'Committee-ready binders, lot traceability, and digital documentation keep sourcing, compliance, and infection prevention aligned.',
        'points' => [
            'ISO 13485, AAMI PB70, ASTM, and ISO 11135 validations on demand',
            'Bilingual IFUs, shelf labels, and ERP/EDI integration support',
            'Rapid sample deployment with matching paperwork in 48 hours',
        ],
    ],
    [
        'title' => 'Logistics & service model',
        'copy' => 'Florence manages forecasting, staging, and OTIF dashboards so clinical teams can focus on care.',
        'points' => [
            'Dallas & Phoenix 3PL hubs plus direct-to-hospital replenishment',
            'Milestone alerts from production through customs and final delivery',
            'Quarterly reviews with dedicated compliance, sourcing, and logistics leads',
        ],
    ],
];

$solution_cards = [
    [
        'title' => 'Surgical and isolation gowns',
        'image' => 'solutions-gowns-v3.svg',
        'summary' => 'Reliable protection from Level 1 to Level 4, built for comfort and compliance. Each batch is verified and ready for delivery.',
        'certifications' => [
            'AAMI PB70 Levels 1–4 compliant',
            'ASTM fluid and seam integrity testing',
            'COFEPRIS sanitary license (active)',
            'FDA importer ID #1748216',
        ],
        'badge' => 'AAMI PB70',
    ],
    [
        'title' => 'Masks and respiratory protection',
        'image' => 'solutions-masks-v3.svg',
        'summary' => 'ASTM F2100 Level 1 to 3 masks plus Florence-qualified N95 and KN95 options with fit-tested performance.',
        'certifications' => [
            'ASTM F2100 Levels 1–3',
            'NIOSH fit-tested program',
            'COFEPRIS airway PPE registration',
            'FDA importer ID #1748216',
        ],
        'badge' => 'ASTM F2100',
    ],
    [
        'title' => 'Procedure and drape packs',
        'image' => 'solutions-packs-v3.svg',
        'summary' => 'Standard, trauma, and cath-lab kits built to your specifications and staged for rapid fulfillment.',
        'certifications' => [
            'AAMI Level 4 barrier fabrics',
            'ASTM F2407 component validation',
            'COFEPRIS kit assembly approval',
            'FDA importer ID #1748216',
        ],
        'badge' => 'Start-to-finish custom',
    ],
    [
        'title' => 'PPE and patient apparel',
        'image' => 'solutions-apparel-v3.svg',
        'summary' => 'Bouffants, footwear, sleeves, and apparel stocked alongside your main packs for consistent and worry-free supply.',
        'certifications' => [
            'AAMI accessory guidance compliant',
            'ASTM abrasion & lint testing',
            'COFEPRIS apparel listing',
            'FDA importer ID #1748216',
        ],
        'badge' => 'Complete catalog',
    ],
];

$pack_components = [
    [
        'name' => __('Level 3 surgical gown set', 'florence-static'),
        'category' => __('Gowns', 'florence-static'),
        'units' =>
            12,
        'description' => __('Includes sterile gown, towel pair, and wrap.', 'florence-static'),
    ],
    [
        'name' => __('Orthopedic drape bundle', 'florence-static'),
        'category' => __('Drapes', 'florence-static'),
        'units' => 8,
        'description' => __('Split leg drapes, fluid pouches, arm board covers.', 'florence-static'),
    ],
    [
        'name' => __('Laparoscopic tubing + camera cover', 'florence-static'),
        'category' => __('Accessories', 'florence-static'),
        'units' => 16,
        'description' => __('Insufflation tubing and universal camera drape.', 'florence-static'),
    ],
    [
        'name' => __('OB / C-section neonatal kit', 'florence-static'),
        'category' => __('Packs', 'florence-static'),
        'units' => 10,
        'description' => __('Includes neonatal towels, bulb syringe, and uterine drape.', 'florence-static'),
    ],
    [
        'name' => __('ENT disposable instrument set', 'florence-static'),
        'category' => __('Packs', 'florence-static'),
        'units' => 18,
        'description' => __('Speculum, suction, and minute drapes for ENT procedures.', 'florence-static'),
    ],
    [
        'name' => __('Bouffants + shoe covers combo', 'florence-static'),
        'category' => __('PPE', 'florence-static'),
        'units' => 40,
        'description' => __('Disposable apparel staged with every OR turn.', 'florence-static'),
    ],
];

$cta_image_id = 35;
$cta_image_alt = get_post_meta($cta_image_id, '_wp_attachment_image_alt', true);
$cta_image_file = get_attached_file($cta_image_id);
$cta_image_data = '';

if (!$cta_image_alt) {
    $cta_image_alt = __('Distribution routes across the United States with hub nodes', 'florence-static');
}

if ($cta_image_file && file_exists($cta_image_file)) {
    $mime_type = wp_get_image_mime($cta_image_file);
    $contents = file_get_contents($cta_image_file);
    if ($contents && $mime_type) {
        $cta_image_data = 'data:' . $mime_type . ';base64,' . base64_encode($contents);
    }
}

?>
<main>
    <section class="front-hero">
        <div class="container front-hero__grid">
            <div class="front-hero__copy hero-pop-card">
                <h1 class="headline-xl">Consistent Supply Proven Quality</h1>
                <p class="subhead">Near-shore manufacturing with U.S. importer accountability. Traceable lots,
                    committee-ready documentation, and delivery in days, not weeks.</p>
                <ul class="front-hero__highlights">
                    <li>ISO 13485 certified manufacturing</li>
                    <li>AAMI PB70 and ASTM F2100 validation included</li>
                    <li>U.S. warehousing with 2 to 5 day delivery</li>
                </ul>
            </div>
            <div class="front-hero__media">
                <div class="front-hero__badge">
                    <span class="front-hero__eyebrow">Importer-led disposable solutions</span>
                </div>
                <div class="front-hero__image-wrap" id="hero-video-wrapper">
                    <video class="front-hero__video"
                        poster="<?php echo esc_url($uploads . 'hero_img_front-min.jpg'); ?>" autoplay muted loop
                        playsinline>
                        <source src="<?php echo esc_url($media . 'front-hero.mp4'); ?>" type="video/mp4">
                        <source src="<?php echo esc_url($media . 'front-hero.mov'); ?>" type="video/quicktime">
                    </video>
                    <button type="button" class="hero-video-fullscreen" id="hero-fullscreen-toggle"
                        aria-label="Enter full screen">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7" />
                        </svg>
                    </button>
                    <button type="button" class="hero-video-volume" id="hero-volume-toggle" aria-label="Unmute">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 5L6 9H2v6h4l5 4V5z"></path>
                            <path d="M23 9l-6 6"></path>
                            <path d="M17 9l6 6"></path>
                        </svg>
                    </button>
                    <img class="front-hero__pattern" src="<?php echo esc_url($uploads . 'pattern_pills_right.png'); ?>"
                        alt="" loading="lazy" decoding="async" />
                </div>
                <script>
                    (function () {
                        var wrapper = document.getElementById('hero-video-wrapper');
                        var btn = document.getElementById('hero-fullscreen-toggle');

                        if (!wrapper || !btn) return;

                        btn.addEventListener('click', function () {
                            if (!document.fullscreenElement) {
                                wrapper.requestFullscreen().catch(err => {
                                    console.error(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                                });
                            } else {
                                document.exitFullscreen();
                            }
                        });

                        document.addEventListener('fullscreenchange', function () {
                            const isFullscreen = document.fullscreenElement === wrapper;
                            wrapper.classList.toggle('is-fullscreen', isFullscreen);

                            if (isFullscreen) {
                                btn.setAttribute('aria-label', 'Exit full screen');
                                btn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/></svg>';
                            } else {
                                btn.setAttribute('aria-label', 'Enter full screen');
                                btn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7" /></svg>';
                            }
                        });

                        // Volume Toggle Logic
                        var volumeBtn = document.getElementById('hero-volume-toggle');
                        var video = wrapper.querySelector('video');

                        if (volumeBtn && video) {
                            volumeBtn.addEventListener('click', function () {
                                video.muted = !video.muted;
                                updateVolumeIcon();
                            });

                            function updateVolumeIcon() {
                                if (video.muted) {
                                    volumeBtn.setAttribute('aria-label', 'Unmute');
                                    volumeBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M23 9l-6 6"></path><path d="M17 9l6 6"></path></svg>';
                                } else {
                                    volumeBtn.setAttribute('aria-label', 'Mute');
                                    volumeBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>';
                                }
                            }
                        }
                    })();
                </script>
                <div class="front-hero__cta btn-group">
                    <a class="btn btn-primary" href="<?php echo esc_url(home_url('/shop/')); ?>">Explore product
                        catalog</a>
                    <a class="btn btn-primary" href="<?php echo esc_url(home_url('/compliance/')); ?>">See
                        compliance program</a>
                    <a class="btn btn-primary" href="<?php echo esc_url(home_url('/request-samples/')); ?>">Request
                        samples</a>
                </div>
            </div>
        </div>
    </section>

    <section class="smart-search">
        <div class="container">
            <h2><?php esc_html_e('Search across Florence', 'florence-static'); ?></h2>
            <p><?php esc_html_e('Find products, compliance documents, logistics data, and key pages instantly.', 'florence-static'); ?>
            </p>
            <form class="smart-search__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="smart-search__input-group">
                    <input type="search" name="s" class="smart-search__input"
                        placeholder="<?php esc_attr_e('Search the entire site: level 3 gowns, OR packs, compliance…', 'florence-static'); ?>"
                        autocomplete="off" aria-label="<?php esc_attr_e('Search the site', 'florence-static'); ?>">
                    <button type="submit"
                        class="smart-search__button"><?php esc_html_e('Search', 'florence-static'); ?></button>
                </div>
                <div class="smart-search__dropdown" hidden>
                    <ul class="smart-search__results"></ul>
                    <div class="smart-search__empty" hidden></div>
                </div>
            </form>
        </div>
    </section>

    <section class="front-confidence">
        <div class="container front-confidence__strip">
            <div class="front-confidence__items">
                <?php foreach ($confidence_items as $item): ?>
                    <div class="front-confidence__item">
                        <span class="front-confidence__value"><?php echo esc_html($item['value']); ?></span>
                        <span class="front-confidence__label"><?php echo esc_html($item['label']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="front-confidence__brand">
                <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo-wordmark.png')); ?>"
                    alt="<?php esc_attr_e('Florence logo', 'florence-static'); ?>" loading="lazy" decoding="async" />
            </div>
        </div>
    </section>

    <section class="front-capabilities" id="florence-difference">
        <div class="container">
            <h2 class="section-title reveal-init">Where Florence makes the difference</h2>
            <p class="section-lead reveal-init">From product engineering to committee approval and final delivery, our
                teams stay
                accountable so yours can move faster.</p>
            <div class="front-capabilities__grid reveal-init-grid">
                <?php foreach ($capability_cards as $index => $card): ?>
                    <article class="front-capabilities__card reveal-init-card" tabindex="0" role="button"
                        aria-pressed="false" style="--stagger: <?php echo $index; ?>;">
                        <h3><?php echo esc_html($card['title']); ?></h3>
                        <p><?php echo esc_html($card['copy']); ?></p>
                        <ul>
                            <?php foreach ($card['points'] as $point): ?>
                                <li><?php echo esc_html($point); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const section = document.getElementById('florence-difference');
                if (!section) return;

                // Progressive Enhancement: Add class to enable animations
                // This ensures if JS fails, content remains visible (default CSS)
                section.classList.add('js-interactions-enabled');

                // 1. Scroll Reveal
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            section.classList.add('is-revealed');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 }); // Lower threshold for easier triggering
                observer.observe(section);

                // 2. Card Interaction
                const grid = section.querySelector('.front-capabilities__grid');
                const cards = section.querySelectorAll('.front-capabilities__card');

                if (grid && cards) {
                    cards.forEach(card => {
                        // Click interaction
                        card.addEventListener('click', (e) => {
                            const isActive = card.classList.contains('is-active');
                            // Clear all
                            cards.forEach(c => {
                                c.classList.remove('is-active');
                                c.setAttribute('aria-pressed', 'false');
                            });
                            grid.classList.remove('has-focus');

                            // Toggle current if it wasn't active
                            if (!isActive) {
                                card.classList.add('is-active');
                                card.setAttribute('aria-pressed', 'true');
                                grid.classList.add('has-focus');
                            }
                        });

                        // Keyboard interaction
                        card.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                e.preventDefault();
                                card.click();
                            } else if (e.key === 'Escape') {
                                cards.forEach(c => {
                                    c.classList.remove('is-active');
                                    c.setAttribute('aria-pressed', 'false');
                                });
                                grid.classList.remove('has-focus');
                            }
                        });
                    });

                    // Clear on outside click
                    document.addEventListener('click', (e) => {
                        if (!grid.contains(e.target)) {
                            cards.forEach(c => {
                                c.classList.remove('is-active');
                                c.setAttribute('aria-pressed', 'false');
                            });
                            grid.classList.remove('has-focus');
                        }
                    });
                }
            });
        </script>
    </section>

    <section class="front-solutions">
        <div class="container">
            <div class="front-solutions__header">
                <h2 class="section-title">Emphasizing nearshore reliability</h2>
                <p class="section-lead">Florence makes sourcing simple. Every product line is documented, staged, and
                    supported by U.S. importer services for quick integration into your network.</p>
            </div>
            <div class="front-solutions__wall ghost-buster" role="list">
                <?php foreach ($solution_cards as $card): ?>
                    <article class="product-card" role="listitem">
                        <div class="product-card__viewport">
                            <button class="product-card__inner" type="button" aria-pressed="false">
                                <span class="product-card__face product-card__face--front">
                                    <span class="product-card__media">
                                        <img src="<?php echo esc_url($uploads . $card['image']); ?>"
                                            alt="<?php echo esc_attr($card['title']); ?>" loading="lazy" decoding="async" />
                                    </span>
                                    <span class="product-card__content">
                                        <?php if (!empty($card['badge'])): ?>
                                            <span class="product-card__badge"><?php echo esc_html($card['badge']); ?></span>
                                        <?php endif; ?>
                                        <h3><?php echo esc_html($card['title']); ?></h3>
                                        <p><?php echo esc_html($card['summary']); ?></p>
                                        <span class="product-card__hint">Click to view certifications</span>
                                    </span>
                                </span>
                                <span class="product-card__face product-card__face--back">
                                    <h3>Certifications &amp; oversight</h3>
                                    <ul class="product-card__certs">
                                        <?php foreach ($card['certifications'] as $certification): ?>
                                            <li><?php echo esc_html($certification); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <span class="product-card__hint">Click to flip back</span>
                                </span>
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="front-solutions__cta">
                <a class="product-card__link" href="<?php echo esc_url(home_url('/product-catalog/')); ?>">Explore
                    full product catalog</a>
            </div>
        </div>
        <script>
            (function () {
                var cards = Array.prototype.slice.call(document.querySelectorAll('.product-card__inner'));
                if (!cards.length) {
                    return;
                }

                function closeAll(except) {
                    cards.forEach(function (card) {
                        if (card === except) {
                            return;
                        }
                        card.classList.remove('is-flipped');
                        card.setAttribute('aria-pressed', 'false');
                    });
                }

                cards.forEach(function (card) {
                    card.addEventListener('click', function (event) {
                        event.stopPropagation();
                        var shouldFlip = !card.classList.contains('is-flipped');
                        closeAll(shouldFlip ? card : null);
                        card.classList.toggle('is-flipped', shouldFlip);
                        card.setAttribute('aria-pressed', shouldFlip ? 'true' : 'false');
                    });
                });

                document.addEventListener('click', function (event) {
                    var target = event.target.closest('.product-card__inner');
                    if (!target) {
                        closeAll(null);
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key !== 'Escape') {
                        return;
                    }
                    var activeCard = cards.find(function (card) {
                        return card.classList.contains('is-flipped');
                    });
                    if (activeCard) {
                        activeCard.classList.remove('is-flipped');
                        activeCard.setAttribute('aria-pressed', 'false');
                        activeCard.focus();
                    }
                });
            })();
        </script>
    </section>

    <section class="build-pack" id="build-your-pack"
        data-empty-message="<?php esc_attr_e('Add components to start configuring your pack.', 'florence-static'); ?>">
        <div class="container">
            <div class="build-pack__header">
                <p class="build-pack__eyebrow"><?php esc_html_e('Configurator', 'florence-static'); ?></p>
                <h2 class="section-title"><?php esc_html_e('Build your own pack', 'florence-static'); ?></h2>
                <p class="section-lead">
                    <?php esc_html_e('Drag Florence components into your tray, see auto case counts, and export the summary before requesting a quote.', 'florence-static'); ?>
                </p>
                <!-- New Trust Line -->
                <p class="build-pack__trust-line" style="color: #ffffff !important;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="trust-icon"
                        style="stroke: #ffffff !important;" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    <span
                        style="color: #ffffff !important;"><?php esc_html_e('Committee-ready documentation • Exportable PDF summary', 'florence-static'); ?></span>
                </p>
            </div>

            <!-- App Canvas Wrapper -->
            <div class="build-pack__canvas">
                <div class="build-pack__grid">
                    <!-- Column 1: Component Selection -->
                    <div class="build-pack__panel build-pack__panel--components">
                        <div class="build-pack__panel-header">
                            <div>
                                <h3><?php esc_html_e('Components', 'florence-static'); ?></h3>
                                <p><?php esc_html_e('Click + or drag items to add to your pack.', 'florence-static'); ?>
                                </p>
                            </div>
                        </div>

                        <div class="build-pack__components" data-pack-components>
                            <?php foreach ($pack_components as $component): ?>
                                <button type="button" class="build-pack__component"
                                    data-pack-component="<?php echo esc_attr($component['name']); ?>"
                                    data-pack-units="<?php echo esc_attr($component['units']); ?>" draggable="true">

                                    <!-- Drag Handle -->
                                    <span class="build-pack__drag-handle" aria-hidden="true">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" opacity="0.4">
                                            <circle cx="9" cy="5" r="2" />
                                            <circle cx="9" cy="12" r="2" />
                                            <circle cx="9" cy="19" r="2" />
                                            <circle cx="15" cy="5" r="2" />
                                            <circle cx="15" cy="12" r="2" />
                                            <circle cx="15" cy="19" r="2" />
                                        </svg>
                                    </span>

                                    <div class="build-pack__component-info">
                                        <div class="build-pack__component-top">
                                            <span
                                                class="build-pack__component-title"><?php echo esc_html($component['name']); ?></span>
                                            <span class="build-pack__add-icon" aria-label="Add item">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="build-pack__component-meta">
                                            <span
                                                class="build-pack__units-pill"><?php echo esc_html(sprintf(__('%d / case', 'florence-static'), $component['units'])); ?></span>
                                        </div>
                                        <p class="build-pack__component-desc">
                                            <?php echo esc_html($component['description']); ?></p>
                                    </div>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Column 2: Pack Summary (Receipt) -->
                    <div class="build-pack__panel build-pack__panel--summary">
                        <!-- Sticky Status Bar -->
                        <div class="build-pack__status-bar">
                            <div class="build-pack__status-group">
                                <div class="build-pack__status-item">
                                    <span class="label"><?php esc_html_e('Total Items', 'florence-static'); ?></span>
                                    <strong class="val" data-pack-count>0</strong>
                                </div>
                                <div class="build-pack__status-item">
                                    <span class="label"><?php esc_html_e('Est. Cases', 'florence-static'); ?></span>
                                    <strong class="val" data-pack-cases>0</strong>
                                </div>
                            </div>
                            <button type="button" class="build-pack__clear">
                                <?php esc_html_e('Clear', 'florence-static'); ?>
                            </button>
                        </div>

                        <div class="build-pack__drop" data-pack-dropzone>
                            <div class="build-pack__table-wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="col-name"><?php esc_html_e('Component', 'florence-static'); ?>
                                            </th>
                                            <th class="col-qty"><?php esc_html_e('Qty', 'florence-static'); ?></th>
                                            <th class="col-cases"><?php esc_html_e('Cases', 'florence-static'); ?></th>
                                            <th class="col-action"></th>
                                        </tr>
                                    </thead>
                                    <tbody data-pack-summary>
                                        <!-- Empty State -->
                                        <tr class="build-pack__empty">
                                            <td colspan="4">
                                                <div class="build-pack__empty-state">
                                                    <div class="empty-icon">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="1.5">
                                                            <path
                                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                            </path>
                                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                                        </svg>
                                                    </div>
                                                    <p><?php esc_html_e('Your pack is empty', 'florence-static'); ?></p>
                                                    <span><?php esc_html_e('Click + or drag items to start', 'florence-static'); ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="build-pack__footer">
                            <div class="build-pack__actions">
                                <a class="build-pack__btn build-pack__btn--primary"
                                    href="<?php echo esc_url(home_url('/request-quote/')); ?>"><?php esc_html_e('Request Quote', 'florence-static'); ?></a>
                                <button type="button" class="build-pack__btn build-pack__btn--secondary"
                                    data-pack-pdf><?php esc_html_e('Generate PDF', 'florence-static'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="front-proof">
        <div class="container front-proof__grid">
            <div>
                <h2 class="section-title">A partner built for accountability</h2>
                <p class="section-lead">Florence blends textile innovation with importer-of-record responsibility,
                    giving sourcing leaders a single point of contact for compliant products, documentation, and
                    logistics.</p>
                <ul class="front-proof__list">
                    <li>Importer credentials, USMCA documentation, and customs coordination</li>
                    <li>Committee-ready sample kits and compliance packets in 48 hours</li>
                    <li>Data-backed OTIF performance with milestone alerts and executive dashboards</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="product-cta">
        <div class="container product-cta__inner">
            <div class="product-cta__content">
                <h2 class="section-title">Let’s plan your next <span class="highlight-text">sourcing milestone.</span>
                </h2>
                <p class="section-lead">Share your formulary, compliance goals, or logistics challenges. Florence will
                    assemble samples, documentation, and a launch plan tailored to your network.</p>

                <!-- Stepper -->
                <div class="product-cta__stepper">
                    <div class="step-item">
                        <span class="step-icon">1</span>
                        <span class="step-label"><?php esc_html_e('Share needs', 'florence-static'); ?></span>
                    </div>
                    <div class="step-separator">→</div>
                    <div class="step-item">
                        <span class="step-icon">2</span>
                        <span
                            class="step-label"><?php esc_html_e('We assemble samples/docs', 'florence-static'); ?></span>
                    </div>
                    <div class="step-separator">→</div>
                    <div class="step-item">
                        <span class="step-icon">3</span>
                        <span class="step-label"><?php esc_html_e('Align delivery plan', 'florence-static'); ?></span>
                    </div>
                </div>

                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo esc_url(home_url('/request-samples/')); ?>">
                        <svg class="btn-icon" width="18" height="18" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" style="margin-right: 8px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <?php esc_html_e('Request samples', 'florence-static'); ?>
                    </a>
                    <a class="btn btn-secondary" href="<?php echo esc_url(home_url('/contact/')); ?>">
                        <svg class="btn-icon" width="18" height="18" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" style="margin-right: 8px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <?php esc_html_e('Schedule a time to meet', 'florence-static'); ?>
                    </a>
                </div>

                <!-- Trust Line -->
                <p class="product-cta__trust">
                    <?php esc_html_e('48-hour sample deployment available • Committee-ready documentation', 'florence-static'); ?>
                </p>
            </div>
            <?php if ($cta_image_data): ?>
                <figure class="product-cta__media">
                    <img class="product-cta__image" src="<?php echo esc_attr($cta_image_data); ?>"
                        alt="<?php echo esc_attr($cta_image_alt); ?>" loading="lazy" decoding="async" />

                    <!-- Map Overlay -->
                    <div class="product-cta__map-overlay">
                        <div class="map-legend">
                            <span class="legend-dot"></span>
                            <?php esc_html_e('3PL hubs • Direct-to-hospital lanes', 'florence-static'); ?>
                        </div>
                    </div>
                </figure>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
get_footer('child');
?>