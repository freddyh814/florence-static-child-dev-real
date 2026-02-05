<?php
/**
 * Template Name: Logistics & Lead Times
 */

get_header();
?>

<main class="logistics-page">

    <!-- 1. HERO & MAP SECTION (TINTED OVERVIEW) -->
    <section class="page-section section-tint-overview" id="hero-map">
        <div class="container two-col-grid">

            <!-- Left: Hero Copy -->
            <div class="hero-copy">
                <h1 class="headline-xl">Logistics & Lead Times</h1>
                <p class="subhead">
                    Our near-shore model keeps your inventory a drive away instead of an ocean away. We stage finished
                    goods at our partner facility in Mexico, move shipments through controlled border lanes, and deliver
                    straight into your distribution network.
                </p>
                <p>
                    This gives you faster replenishment, steadier forecasting, and fewer surprises. Below are our
                    standard lead-time ranges, MOQs, packaging details, and shipping options so your materials team can
                    plan with real confidence.
                </p>
                <div class="btn-group" style="margin-top: 24px;">
                    <a href="<?php echo esc_url(home_url('/request-samples/')); ?>" class="btn btn-primary">Request
                        samples</a>
                </div>
            </div>

            <!-- Right: Map Card -->
            <div class="map-card-wrapper">
                <div class="logistics-card white-card">
                    <h2 class="card-title">Current Delivery ETA Map</h2>
                    <p class="card-desc">Live view of 2–5 day coverage when we ship from Jalisco, MX. Customer services
                        updates this data daily so sourcing teams can plan replenishment windows with confidence.</p>

                    <div class="map-visual">
                        <!-- Placeholder for map visual/image -->
                        <div class="map-placeholder"
                            style="background: #e2e8f0; height: 200px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                            [Interactive Map Visualization]
                        </div>
                    </div>

                    <div class="map-legend">
                        <h4>2–3 day coverage</h4>
                        <p>Texas, Southwest, and border-region IDNs receive replenishment in 2–3 business days thanks to
                            daily departures from Jalisco and cross-dock hubs in Laredo.</p>
                        <ul class="micro-list">
                            <li><span class="status-dot status-success"></span> 98% on-time performance to Dallas–Fort
                                Worth, Austin, San Antonio, and Phoenix metro facilities.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. LEAD TIME BANDS -->
    <section class="page-section" id="lead-times">
        <div class="container">
            <h2 class="section-title">Standard Lead-Time Bands</h2>
            <p class="section-lead">Predictable windows based on order volume and SKU classification.</p>

            <div class="lead-time-grid">
                <!-- Band 1 -->
                <article class="lead-time-card active-band">
                    <div class="band-header">
                        <span class="band-title">Fast Track</span>
                        <span class="band-days">2–5 Days</span>
                    </div>
                    <div class="band-body">
                        <p>In-stock finished goods for immediate replenishment.</p>
                        <ul class="check-list">
                            <li>Core SKUs (Gowns, Masks)</li>
                            <li>
                                < 5 Pallets</li>
                            <li>LTL / Parcel carrier</li>
                        </ul>
                    </div>
                </article>

                <!-- Band 2 -->
                <article class="lead-time-card">
                    <div class="band-header">
                        <span class="band-title">Standard Production</span>
                        <span class="band-days">14–21 Days</span>
                    </div>
                    <div class="band-body">
                        <p>Made-to-order from raw material stock.</p>
                        <ul class="check-list">
                            <li>High volume orders</li>
                            <li>Full truckload (FTL)</li>
                            <li>Custom sterile packs</li>
                        </ul>
                    </div>
                </article>

                <!-- Band 3 -->
                <article class="lead-time-card">
                    <div class="band-header">
                        <span class="band-title">Volume Program</span>
                        <span class="band-days">45–60 Days</span>
                    </div>
                    <div class="band-body">
                        <p>Large-scale production planning and safety stock buildup.</p>
                        <ul class="check-list">
                            <li>Annual tender allocation</li>
                            <li>Private label programs</li>
                            <li>Custom material imports</li>
                        </ul>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- 3. PACKAGING & PALLETIZATION (TINTED PANEL) -->
    <section class="page-section section-tint-packaging" id="packaging">
        <div class="container">
            <h2 class="section-title">Packaging & Palletization Specs</h2>

            <div class="logistics-card tinted-card">
                <div class="specs-grid">
                    <div class="spec-col">
                        <h3>Pallet Standards</h3>
                        <ul class="spec-list">
                            <li><strong>Type:</strong> 40x48 Standard GMA (Grade A or B)</li>
                            <li><strong>Max Height:</strong> 96" (double stacked) or 50" (single)</li>
                            <li><strong>Wrap:</strong> Clear stretch wrap, corner boards required</li>
                            <li><strong>Labels:</strong> SSCC-18 Pallet Label on 2 adjacent sides</li>
                        </ul>
                    </div>
                    <div class="spec-col">
                        <h3>Carton Markings</h3>
                        <ul class="spec-list">
                            <li><strong>GTIN-14:</strong> Encoded barcode (ITF-14)</li>
                            <li><strong>Human Readable:</strong> SKU, Lot, Mfg Date, Exp Date, Qty</li>
                            <li><strong>Weight:</strong> Gross/Net in KG and LBS</li>
                            <li><strong>COO:</strong> "Made in Mexico" / "Hecho en México"</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer-note">
                    <span class="status-dot status-neutral"></span>
                    Custom pallet profiles available for automated warehouses (demands >500 pallets/yr).
                </div>
            </div>

        </div>
    </section>

    <!-- 4. FULFILLMENT & RMA -->
    <section class="page-section section-tint-fulfillment" id="fulfillment">
        <div class="container two-col-grid">

            <div class="logistics-card white-card border-accent-neutral">
                <h3>Managed Freight (DDP)</h3>
                <p>Florence handles all logistics from factory to your dock. We act as the Importer of Record (IOR) and
                    manage all customs brokerage.</p>
                <div class="feature-row">
                    <span class="feature-item">Customs Cleared</span>
                    <span class="feature-item">Live Tracking</span>
                    <span class="feature-item">Single Invoice</span>
                </div>
            </div>

            <div class="logistics-card white-card border-accent-warm">
                <h3>Returns & Quality Holds (RMA)</h3>
                <p>In the rare event of a quality concern, we deploy a rapid RMA process.</p>
                <ul class="plain-list">
                    <li><strong>Response:</strong> &lt; 24 hours initial assessment</li>
                    <li><strong>Hold:</strong> Immediate lot trace &amp; freeze</li>
                    <li><strong>Disposition:</strong> Credit, replace, or rework</li>
                </ul>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-secondary btn-sm">Report an
                    Issue</a>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>