<?php
/**
 * Template Name: Manufacturing Partner
 * 
 * Custom template to refine hero messaging while preserving
 * the rest of the page layout.
 */

get_header();
?>

<main class="manufacturing-page">
    <section class="page-hero" id="quality">
        <div class="container page-hero__grid">
            <div class="page-hero__copy">
                <h1 class="headline-xl">Jalisco-based manufacturing integrated with U.S. hospital supply chains for
                    speed and reliability.</h1>
                <p class="subhead">Intercambio Global Latinoamérica (IGL) manufactures in Jalisco, while Florence acts
                    as the U.S. importer and distributor. We replace ocean freight with rapid near-shore trucking,
                    managing all FDA compliance and weekly replenishment.</p>
            </div>
            <div class="page-hero__media" aria-hidden="true">
                <div class="page-hero__image-wrap">
                    <img src="<?php echo esc_url(content_url('/uploads/2025/11/warehouse-distribution-centre-1.jpg')); ?>"
                        alt="Florence warehouse operations supporting cross-border logistics" />
                </div>
            </div>
        </div>
    </section>

    <section class="page-section page-section--light">
        <div class="container front-confidence__strip">
            <div class="front-confidence__item">
                <span class="front-confidence__value">20+</span>
                <span class="front-confidence__label">Years in surgical textiles</span>
            </div>
            <div class="front-confidence__item">
                <span class="front-confidence__value">500+</span>
                <span class="front-confidence__label">Skilled associates</span>
            </div>
            <div class="front-confidence__item">
                <span class="front-confidence__value">25M+</span>
                <span class="front-confidence__label">Units produced each year</span>
            </div>
            <div class="front-confidence__item">
                <span class="front-confidence__value">350+</span>
                <span class="front-confidence__label">Product models</span>
            </div>
            <div class="front-confidence__item">
                <span class="front-confidence__value">~12 hrs</span>
                <span class="front-confidence__label">Line-haul to U.S. border</span>
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="container product-compliance__grid">
            <article class="product-compliance__card">
                <h2 class="section-title">What it means for U.S. buyers</h2>
                <ul>
                    <li>Short, predictable trucking lanes replace ocean freight delays</li>
                    <li>OR-grade packs and textiles with transparent specs and supporting docs</li>
                    <li>Florence operates as the Initial Importer, supplying FDA documentation and QA releases</li>
                </ul>
            </article>
            <article class="product-compliance__card">
                <h2 class="section-title">Our Network</h2>
                <ul>
                    <li>Supplying Mexico’s largest systems: IMSS, ISSSTE, PEMEX, SEDENA, INSABI</li>
                    <li>1M+ surgeries supported annually with Florence-branded disposables</li>
                    <li>Distribution network built for national tenders and cross-border programs</li>
                </ul>
            </article>
        </div>
    </section>

    <section class="page-section page-section--light">
        <div class="container product-compliance__grid">
            <article class="product-compliance__card">
                <h2 class="section-title">Brand relationship</h2>
                <p>IGL manufactures under the Florence brand in Mexico. Florence Medical International is the U.S.
                    importer and distributor, providing compliance packets, customer service, and replenishment across
                    North America.</p>
            </article>
        </div>
    </section>

    <section class="page-section">
        <div class="container">
            <div class="page-section__header">
                <h2 class="section-title">Product Families</h2>
            </div>
            <div class="product-family-grid">
                <article class="product-family-card" aria-label="Gowns">
                    <div class="product-family-card__inner">
                        <div class="product-family-card__face product-family-card__face--front">
                            <img src="<?php echo esc_url(content_url('/uploads/2025/08/category_1-min.jpg')); ?>"
                                alt="Disposable surgical gowns staged for inspection" loading="lazy" decoding="async" />
                            <h3>Gowns</h3>
                        </div>
                        <div class="product-family-card__face product-family-card__face--back">
                            <p>AAMI PB70 Levels 1–4, sterile and non-sterile with bilingual packaging.</p>
                            <ul>
                                <li>ULPA-clean production suites</li>
                                <li>Lot tracking + COA on release</li>
                                <li>Colorways + reinforcement options</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="product-family-card" aria-label="Masks">
                    <div class="product-family-card__inner">
                        <div class="product-family-card__face product-family-card__face--front">
                            <img src="<?php echo esc_url(content_url('/uploads/2025/08/category_2-min.jpg')); ?>"
                                alt="Mask production line in Zapopan facility" loading="lazy" decoding="async" />
                            <h3>Masks</h3>
                        </div>
                        <div class="product-family-card__face product-family-card__face--back">
                            <p>ASTM F2100 Levels 1–3 with tie-on, ear loop, visor, and headband variations.</p>
                            <ul>
                                <li>Built-in bioburden monitoring</li>
                                <li>Color and strap customization</li>
                                <li>Cartons labeled with GTIN + UDI</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="product-family-card" aria-label="Procedure packs">
                    <div class="product-family-card__inner">
                        <div class="product-family-card__face product-family-card__face--front">
                            <img src="<?php echo esc_url(content_url('/uploads/2025/08/category_3-min.jpg')); ?>"
                                alt="Pack assembly cells preparing drapes and accessories" loading="lazy"
                                decoding="async" />
                            <h3>Procedure packs</h3>
                        </div>
                        <div class="product-family-card__face product-family-card__face--back">
                            <p>Standard, Esencial, and Premium kits engineered for OR workflows.</p>
                            <ul>
                                <li>Custom BOM support with Florence engineers</li>
                                <li>Kitting under ISO 13485 QA</li>
                                <li>Tray, wrap, and sterile pouch options</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="product-family-card" aria-label="Accessories">
                    <div class="product-family-card__inner">
                        <div class="product-family-card__face product-family-card__face--front">
                            <img src="<?php echo esc_url(content_url('/uploads/2025/08/category_4-min.jpg')); ?>"
                                alt="Accessory apparel staged for loading" loading="lazy" decoding="async" />
                            <h3>Accessories</h3>
                        </div>
                        <div class="product-family-card__face product-family-card__face--back">
                            <p>Caps, footwear, scrubs, and sterile field add-ons staged with core SKUs.</p>
                            <ul>
                                <li>Fixed carton counts for easy replenishment</li>
                                <li>Lot, expiry, and HTS references printed on labels</li>
                                <li>Bundled with gowns or standalone replenishment</li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="page-section" id="facilities">
        <div class="container product-compliance__grid">
            <article class="product-compliance__card" style="max-width:640px;margin:0 auto;">
                <h2 class="section-title">Facility</h2>
                <p><strong>Intercambio Global Latinoamérica S.A. de C.V.</strong><br>
                    Ixtepete 1907, Col. Mariano Otero, C.P. 45067<br>
                    Zapopan, Jalisco, Mexico</p>
                <p>Pallets stage inside IGL’s conditioning and distribution center (CEDIS) for QA release,
                    consolidation, and cross-border trucking to Florence-managed 3PLs or customer docks.</p>
            </article>
        </div>
    </section>

    <section class="page-section page-section--accent" id="partner-form">
        <div class="container">
            <div class="cta-banner">
                <div>
                    <h2 class="section-title">Ready to align your sourcing plan?</h2>
                    <p class="section-lead">Review catalog specs or start a sample request and we will map replenishment
                        to your demand profile.</p>
                </div>
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo esc_url(home_url('/shop/')); ?>">View products</a>
                    <a class="btn btn-secondary" href="<?php echo esc_url(home_url('/request-quote/')); ?>">Request
                        samples</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>