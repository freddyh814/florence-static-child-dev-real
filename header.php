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
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>
    <div style="background-color: #333; color: white; text-align: center; padding: 10px; font-weight: bold; width: 100%;">test</div>

    <?php
    $brand_logo = get_theme_file_uri('assets/images/logo-wordmark.svg');
    if (has_custom_logo()) {
        $logo_id = get_theme_mod('custom_logo');
        $logo_src = wp_get_attachment_image_src($logo_id, 'full');
        if ($logo_src) {
            $brand_logo = $logo_src[0];
        }
    }

    $nav_groups = [
        [
            'title' => __('Products', 'florence-static'),
            'summary' => __('Gowns, masks, packs, PPE', 'florence-static'),
            'links' => [
                ['label' => __('Isolation & Surgical Gowns', 'florence-static'), 'url' => home_url('/shop/?product_cat=gowns')],
                ['label' => __('Face Masks & Respiratory', 'florence-static'), 'url' => home_url('/shop/?product_cat=masks')],
                ['label' => __('Drapes & Procedure Packs', 'florence-static'), 'url' => home_url('/shop/?product_cat=drapes')],
                ['label' => __('Gloves & Accessories', 'florence-static'), 'url' => home_url('/shop/?product_cat=accessories')],
                ['label' => __('Private Label Programs', 'florence-static'), 'url' => home_url('/manufacturing-partner/#private-label')],
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
                ['label' => __('Partner Portal', 'florence-static'), 'url' => home_url('/partner-portal/')],
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
                <!-- Top Bar: Branding Text + Language Toggle + Mobile Toggle -->
                <div class="sleek-header__top-bar">
                    <div class="brand-text-wrapper">
                        <div class="brand-text">
                            <span class="brand-line-1">Nearshore surgical textiles</span>
                            <span class="brand-separator"></span>
                            <span class="brand-line-2">U.S. importer of record</span>
                        </div>
                        <div class="language-toggle" data-language-switch>
                            <button type="button" class="is-active" data-lang-button="en">EN</button>
                            <button type="button" data-lang-button="es">ES</button>
                        </div>
                    </div>

                    <button class="sleek-header__toggle" type="button" aria-expanded="false"
                        aria-controls="mega-navigation" data-slim-toggle>
                        <span></span><span></span><span></span>
                    </button>
                </div>

                <!-- Bottom Bar: Navigation -->
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
                    <div class="mega-nav__cta">
                        <a class="btn btn-primary"
                            href="<?php echo esc_url(home_url('/request-samples/')); ?>"><?php esc_html_e('Request Samples', 'florence-static'); ?></a>
                        <a class="btn btn-secondary"
                            href="<?php echo esc_url(home_url('/request-quote/')); ?>"><?php esc_html_e('Contact', 'florence-static'); ?></a>
                    </div>
                </nav>
            </div>
        </div>
    </header>