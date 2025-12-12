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
            <div class="front-hero__copy">
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
                <div class="front-hero__image-wrap">
                    <video class="front-hero__video"
                        poster="<?php echo esc_url($uploads . 'hero_img_front-min.jpg'); ?>" autoplay muted loop
                        playsinline>
                        <source src="<?php echo esc_url($media . 'front-hero.mp4'); ?>" type="video/mp4">
                        <source src="<?php echo esc_url($media . 'front-hero.mov'); ?>" type="video/quicktime">
                    </video>
                    <img class="front-hero__pattern" src="<?php echo esc_url($uploads . 'pattern_pills_right.png'); ?>"
                        alt="" loading="lazy" decoding="async" />
                </div>
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

    <section class="front-capabilities">
        <div class="container">
            <h2 class="section-title">Where Florence makes the difference</h2>
            <p class="section-lead">From product engineering to committee approval and final delivery, our teams stay
                accountable so yours can move faster.</p>
            <div class="front-capabilities__grid">
                <?php foreach ($capability_cards as $card): ?>
                    <article class="front-capabilities__card">
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
    </section>

    <section class="front-solutions"
        style="background: transparent !important; box-shadow: none !important; border: none !important;">
        <div class="container"
            style="background: transparent !important; box-shadow: none !important; border: none !important;">
            <div class="front-solutions__header">
                <h2 class="section-title">Emphasizing nearshore reliability</h2>
                <p class="section-lead">Florence makes sourcing simple. Every product line is documented, staged, and
                    supported by U.S. importer services for quick integration into your network.</p>
            </div>
            <div class="front-solutions__wall ghost-buster" role="list"
                style="background: transparent !important; box-shadow: none !important; border: none !important; backdrop-filter: none !important; -webkit-backdrop-filter: none !important; filter: none !important; outline: none !important;">
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
            </div>
            <div class="build-pack__grid">
                <div class="build-pack__panel build-pack__panel--components">
                    <h3><?php esc_html_e('Components', 'florence-static'); ?></h3>
                    <p><?php esc_html_e('Click or drag an item to include it. Each chip shows the default units per case.', 'florence-static'); ?>
                    </p>
                    <div class="build-pack__components" data-pack-components>
                        <?php foreach ($pack_components as $component): ?>
                            <button type="button" class="build-pack__component"
                                data-pack-component="<?php echo esc_attr($component['name']); ?>"
                                data-pack-units="<?php echo esc_attr($component['units']); ?>" draggable="true">
                                <span class="build-pack__component-title"><?php echo esc_html($component['name']); ?></span>
                                <small><?php echo esc_html($component['category']); ?> ·
                                    <?php echo esc_html(sprintf(__('%d per case', 'florence-static'), $component['units'])); ?></small>
                                <p><?php echo esc_html($component['description']); ?></p>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="build-pack__panel build-pack__panel--summary">
                    <h3><?php esc_html_e('Pack summary', 'florence-static'); ?></h3>
                    <div class="build-pack__drop" data-pack-dropzone>
                        <div class="build-pack__table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th><?php esc_html_e('Component', 'florence-static'); ?></th>
                                        <th><?php esc_html_e('Qty', 'florence-static'); ?></th>
                                        <th><?php esc_html_e('Cases', 'florence-static'); ?></th>
                                        <th><?php esc_html_e('Actions', 'florence-static'); ?></th>
                                    </tr>
                                </thead>
                                <tbody data-pack-summary>
                                    <tr class="build-pack__empty">
                                        <td colspan="4">
                                            <?php esc_html_e('Add components to start configuring your pack.', 'florence-static'); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="build-pack__totals">
                        <p><?php esc_html_e('Total items', 'florence-static'); ?>: <strong data-pack-count>0</strong>
                        </p>
                        <p><?php esc_html_e('Estimated cases', 'florence-static'); ?>: <strong
                                data-pack-cases>0</strong></p>
                        <button type="button" class="btn btn-secondary build-pack__clear"
                            style="font-size: 12px; padding: 4px 12px; margin-left: auto;">
                            <?php esc_html_e('Clear Pack', 'florence-static'); ?>
                        </button>
                    </div>
                    <div class="build-pack__actions">
                        <button type="button" class="build-pack__btn build-pack__btn--ghost"
                            data-pack-pdf><?php esc_html_e('Generate PDF Summary', 'florence-static'); ?></button>
                        <a class="build-pack__btn"
                            href="<?php echo esc_url(home_url('/request-quote/')); ?>"><?php esc_html_e('Request a Quote', 'florence-static'); ?></a>
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
                <h2 class="section-title">Let’s plan your next sourcing milestone.</h2>
                <p class="section-lead">Share your formulary, compliance goals, or logistics challenges. Florence will
                    assemble samples, documentation, and a launch plan tailored to your network.</p>
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo esc_url(home_url('/request-samples/')); ?>">Request
                        samples</a>
                    <a class="btn btn-secondary" href="<?php echo esc_url(home_url('/contact/')); ?>">Schedule a
                        time to meet</a>
                </div>
            </div>
            <?php if ($cta_image_data): ?>
                <figure class="product-cta__media">
                    <img class="product-cta__image" src="<?php echo esc_attr($cta_image_data); ?>"
                        alt="<?php echo esc_attr($cta_image_alt); ?>" loading="lazy" decoding="async" />
                </figure>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
get_footer();
?>