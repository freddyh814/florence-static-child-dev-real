<?php
/**
 * Custom sleek header for Florence Static child theme.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
    <style>
        html,
        body.home,
        body {
            background-color: #eaeffa !important;
            background-image: none !important;
        }
    </style>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>
    <?php
    // User requested new transparent logo
    $brand_logo = get_theme_file_uri('assets/images/florence-logo-transparent.png');
    /* 
    if (has_custom_logo()) {
        $logo_id = get_theme_mod('custom_logo');
        $logo_src = wp_get_attachment_image_src($logo_id, 'full');
        if ($logo_src) {
            $brand_logo = $logo_src[0];
        }
    } 
    */

    $nav_groups = [
        [
            'title' => __('Products', 'florence-static'),
            'summary' => __('Gowns, masks, packs, PPE', 'florence-static'),
            'links' => [
                ['label' => __('Isolation & Surgical Gowns', 'florence-static'), 'url' => home_url('/shop/?category=gowns')],
                ['label' => __('Face Masks & Respiratory', 'florence-static'), 'url' => home_url('/shop/?category=masks')],
                ['label' => __('Drapes & Procedure Packs', 'florence-static'), 'url' => home_url('/shop/?category=drapes')],
                ['label' => __('Gloves & Accessories', 'florence-static'), 'url' => home_url('/shop/?category=accessories')],
                ['label' => __('Private Label Programs', 'florence-static'), 'url' => home_url('/shop/?category=private-label')],
            ],
        ],
        [
            'title' => __('Compliance', 'florence-static'),
            'summary' => __('FDA, ISO, documentation', 'florence-static'),
            'links' => [
                ['label' => __('Compliance Overview', 'florence-static'), 'url' => home_url('/compliance/')],
                ['label' => __('ISO 13485 & QA', 'florence-static'), 'url' => home_url('/compliance/#iso13485')],
                ['label' => __('AAMI / ASTM Reports', 'florence-static'), 'url' => home_url('/compliance/#barrier-testing')],
                ['label' => __('FDA Importer Registration', 'florence-static'), 'url' => home_url('/compliance/#fda-importer')],
                ['label' => __('COFEPRIS & USMCA', 'florence-static'), 'url' => home_url('/compliance/#regional-compliance')],
            ],
        ],
        [
            'title' => __('Operations', 'florence-static'),
            'summary' => __('Logistics, manufacturing, calculators', 'florence-static'),
            'links' => [
                ['label' => __('Logistics & Lead Times', 'florence-static'), 'url' => home_url('/logistics/')],
                ['label' => __('Manufacturing Partner', 'florence-static'), 'url' => home_url('/manufacturing-partner/')],
                ['label' => __('Impact Calculator', 'florence-static'), 'url' => home_url('/nearshore-calculator/')],
                ['label' => __('Sustainability', 'florence-static'), 'url' => home_url('/sustainability-impact/')],
            ],
        ],
        [
            'title' => __('Government', 'florence-static'),
            'summary' => __('Federal & GPO readiness', 'florence-static'),
            'links' => [
                ['label' => __('Government & GPO Overview', 'florence-static'), 'url' => home_url('/government-gpo/')],
                ['label' => __('SAM.gov & DLA', 'florence-static'), 'url' => home_url('/government-gpo/#sam')],
                ['label' => __('Federal Supply & TAA', 'florence-static'), 'url' => home_url('/government-gpo/#taa')],
            ],
        ],
        [
            'title' => __('Resources', 'florence-static'),
            'summary' => __('Portal, FAQs, contact', 'florence-static'),
            'links' => [
                ['label' => __('FAQs', 'florence-static'), 'url' => home_url('/faqs/')],
                ['label' => __('About Florence', 'florence-static'), 'url' => home_url('/about/')],
                ['label' => __('Contact & Quotes', 'florence-static'), 'url' => home_url('/request-quote/')],
            ],
        ],
    ];
    ?>
    <header class="sleek-header">
        <div class="sleek-header__container">
            <!-- Left Column: Logo -->
            <div class="header-col-left">
                <a class="sleek-header__logo" href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url($brand_logo); ?>" alt="<?php bloginfo('name'); ?>" width="180"
                        height="36" />
                </a>
            </div>

            <!-- Right Column: Info + Nav -->
            <div class="header-col-right">

                <!-- Center Group: Branding Text + Navigation List -->
                <div class="nav-center-group">
                    <div class="brand-text-wrapper">
                        <div class="brand-text">
                            <span class="brand-line-1">Nearshore surgical textiles</span>
                            <span class="brand-separator"></span>
                            <span class="brand-line-2">U.S. importer of record</span>
                        </div>

                        <!-- Desktop Contact Card (Moved) -->
                        <div class="header-contact-card">
                            <a href="tel:+17206989170" class="contact-link">
                                <svg class="contact-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                    </path>
                                </svg>
                                (720) 698-9170
                            </a>
                            <a href="mailto:ceo@florenceinternational.health" class="contact-link">
                                <svg class="contact-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                ceo@florenceinternational.health
                            </a>
                        </div>

                        <div class="language-toggle" data-language-switch>
                            <button type="button" class="is-active" data-lang-button="en">EN</button>
                            <button type="button" data-lang-button="es">ES</button>
                        </div>
                    </div>

                    <nav class="mega-nav" id="mega-navigation" data-slim-nav>
                        <ul class="mega-nav__list">
                            <?php foreach ($nav_groups as $group): ?>
                                <li class="mega-nav__item">
                                    <button class="mega-nav__toggle" type="button" data-mega-toggle>
                                        <span class="mega-nav__title"><?php echo esc_html($group['title']); ?></span>
                                    </button>
                                    <div class="mega-nav__panel" data-mega-panel>
                                        <div class="mega-nav__panel-inner">
                                            <ul>
                                                <?php foreach ($group['links'] as $link): ?>
                                                    <li><a
                                                            href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <!-- Mobile CTA (Visible on Mobile only via CSS) -->
                        <div class="mega-nav__cta mobile-cta">
                            <a class="btn btn-primary"
                                href="<?php echo esc_url(home_url('/request-samples/')); ?>"><?php esc_html_e('Request Samples', 'florence-static'); ?></a>
                            <a class="btn btn-secondary"
                                href="<?php echo esc_url(home_url('/request-quote/')); ?>"><?php esc_html_e('Contact', 'florence-static'); ?></a>
                        </div>
                    </nav>
                </div>

                <!-- Context Block (Persona, Slogan, Credibility) -->
                <div class="header-context-block">
                    <!-- Trust Icons (Compliance, Logistics, Quality) -->
                    <div class="context-trust-icons">
                        <!-- Shield -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <!-- Globe -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path
                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                            </path>
                        </svg>
                        <!-- Clipboard -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                        <!-- Truck -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                        <!-- Check Circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div class="context-persona">
                        <span class="persona-item is-active">Hospital</span>
                        <span class="persona-sep">|</span>
                        <span class="persona-item is-active">GPO</span>
                        <span class="persona-sep">|</span>
                        <span class="persona-item is-active">Government</span>
                    </div>
                    <div class="context-slogan">Embracing Life’s Needs</div>
                    <div class="context-credibility">Built for hospital supply chains</div>
                </div>

                <!-- Vertical Divider (New) -->
                <div class="header-divider"></div>

                <!-- Right Actions: Desktop CTA + Mobile Toggle -->
                <div class="header-right-actions">
                    <div class="mega-nav__cta desktop-cta">
                        <a class="btn btn-primary"
                            href="<?php echo esc_url(home_url('/request-samples/')); ?>"><?php esc_html_e('Request Samples', 'florence-static'); ?></a>
                        <a class="btn btn-secondary"
                            href="<?php echo esc_url(home_url('/request-quote/')); ?>"><?php esc_html_e('Contact', 'florence-static'); ?></a>
                    </div>

                    <button class="sleek-header__toggle" type="button" aria-expanded="false"
                        aria-controls="mega-navigation" data-slim-toggle>
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>