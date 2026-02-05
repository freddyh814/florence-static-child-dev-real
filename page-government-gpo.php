<?php
/**
 * Template Name: Government & GPO
 */

get_header();
?>

<main class="gov-page">

    <!-- Hero Section -->
    <section class="page-hero page-hero--compact">
        <div class="container">
            <span class="eyebrow">Government & GPO</span>
            <h1 class="headline-lg">Built for hospital supply chains.</h1>
            <p class="subhead">Florence Medical International supports federal, state, and GPO procurement teams with
                compliant PPE supply, clear regulatory documentation, and rapid sample deployment from our Mexico to
                U.S. lanes.</p>

            <!-- Process Indicator -->
            <div class="gov-process-flow">
                <span class="flow-step">Registration</span>
                <span class="flow-arrow">&rarr;</span>
                <span class="flow-step">Documentation</span>
                <span class="flow-arrow">&rarr;</span>
                <span class="flow-step">Samples</span>
                <span class="flow-arrow">&rarr;</span>
                <span class="flow-step">Fulfillment</span>
            </div>
        </div>
    </section>

    <!-- 2. REGISTRATIONS & CODES (Grouped Band) -->
    <div class="gov-group-band band-cool-gray">
        <div class="container">
            <!-- Registrations -->
            <section class="gov-section gov-section--cards">
                <h2 class="section-title">Registrations</h2>
                <div class="gov-grid-cards">
                    <div class="gov-card">
                        <span class="gov-label">SAM UEI</span>
                        <span class="gov-value">[UEI]</span>
                    </div>
                    <div class="gov-card">
                        <span class="gov-label">CAGE</span>
                        <span class="gov-value">[CAGE]</span>
                    </div>
                    <div class="gov-card">
                        <span class="gov-label">DUNS (legacy)</span>
                        <span class="gov-value">[DUNS]</span>
                    </div>
                    <div class="gov-card">
                        <span class="gov-label">Business Size</span>
                        <span class="gov-value">[Small / other classification]</span>
                    </div>
                </div>
            </section>

            <!-- Spacing between sub-sections -->
            <div class="spacer-xl"></div>

            <!-- Our Codes -->
            <section class="gov-section gov-section--cards">
                <h2 class="section-title">Our Codes</h2>
                <div class="gov-grid-cards">
                    <div class="gov-card">
                        <span class="gov-label">NAICS</span>
                        <span class="gov-value">339113, 423450, <span class="text-muted">[additional
                                codes]</span></span>
                    </div>
                    <div class="gov-card">
                        <span class="gov-label">UNSPSC</span>
                        <span class="gov-value">[List primary codes]</span>
                    </div>
                    <div class="gov-card">
                        <span class="gov-label">HCPCS</span>
                        <span class="gov-value">[If applicable]</span>
                    </div>
                    <div class="gov-card">
                        <span class="gov-label">PSC/FSC</span>
                        <span class="gov-value">[Optional]</span>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- 3. COMPLIANCE DOWNLOADS (White Band) -->
    <div class="gov-group-band band-white">
        <div class="container">
            <section class="gov-section gov-section--flat">
                <div class="gov-flat-layout">
                    <div class="gov-flat-content">
                        <h2 class="section-title">Compliance Downloads</h2>
                        <p class="section-lead--compact">Grab capabilities briefs, product masters, and compliance
                            packets directly from our centralized documentation hub.</p>
                    </div>
                    <div class="gov-flat-action">
                        <a href="#" class="btn btn-secondary btn-sm">Open documentation hub</a>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- 4. POINTS OF CONTACT (Cool Band) -->
    <div class="gov-group-band band-cool-gray">
        <div class="container">
            <section class="gov-section gov-section--contacts">
                <h2 class="section-title">Points of Contact</h2>
                <div class="gov-contact-grid">
                    <div class="gov-contact">
                        <h3 class="contact-name">Erin McCall</h3>
                        <p class="contact-role">Government Programs Director</p>
                        <div class="contact-details">
                            <a href="mailto:erin@florenceinternational.health">erin@florenceinternational.health</a>
                            <a href="tel:3035551042">(303) 555-1042</a>
                        </div>
                    </div>
                    <div class="gov-contact">
                        <h3 class="contact-name">Marco Aguilar</h3>
                        <p class="contact-role">Logistics & Compliance Liaison</p>
                        <div class="contact-details">
                            <a href="mailto:marco@florenceinternational.health">marco@florenceinternational.health</a>
                            <a href="tel:4695552098">(469) 555-2098</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Elevated CTA Section -->
    <section class="gov-cta">
        <div class="container text-center">
            <h2 class="section-title">Want to talk about capabilities?</h2>
            <p class="section-lead">We align PPE programs with federal, state, and GPO partners, including compliance
                evidence and replenishment modeling.</p>
            <div class="btn-group centered">
                <a class="btn btn-primary" href="/request-samples/">Request samples</a>
                <a class="btn btn-secondary" href="/contact/">Set up a meeting</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>