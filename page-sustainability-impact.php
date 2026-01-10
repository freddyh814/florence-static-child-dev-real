<?php
/**
 * Template Name: Sustainability Impact
 */

get_header();
?>

<main class="sustainability-page">

    <!-- 1. Compact Hero -->
    <section class="calculator-hero">
        <div class="container">
            <span class="eyebrow">Sustainability</span>
            <h1 class="headline-lg">Track the environmental advantage of your near-shore strategy.</h1>
            <p class="subhead">Input your volume to see how Florence's Mexico-to-U.S. lanes help cut carbon, reduce
                freight miles, and minimize waste compared to long-haul ocean freight.</p>
        </div>
    </section>

    <!-- 2. Tracker Interface -->
    <section class="sustainability-tracker" data-sustainability-tracker>
        <div class="container">

            <div class="calculator-form">
                <div class="calculator-inputs-row">
                    <!-- Volume Input -->
                    <div class="input-group">
                        <label>Monthly Case Volume</label>
                        <input type="number" min="1" value="1000" placeholder="e.g. 1000" data-sustainability-volume>
                    </div>

                    <!-- Category Input -->
                    <div class="input-group">
                        <label>Product Category</label>
                        <select data-sustainability-category>
                            <option value="gowns">Gowns</option>
                            <option value="packs">OR Packs</option>
                            <option value="masks">Masks</option>
                            <option value="mixed">Mixed Products</option>
                        </select>
                    </div>

                    <!-- Assumptions Text (Inline with inputs on desktop if space permits, or below) -->
                    <!-- For this layout, we'll keep inputs in a row and text below -->
                </div>

                <div class="calculator-assumptions">
                    <small><strong>How it works:</strong> Adjust the inputs above to estimate your sustainability impact
                        when switching from overseas freight to near-shore replenishment. Estimates are based on typical
                        distances, freight modes, and packaging weights.</small>
                </div>
            </div>

            <div class="calculator-results-grid">

                <!-- CO2 Emissions -->
                <article class="result-card result-card--sustainability">
                    <div class="result-card__header">
                        <p class="result-label">CO₂ Emissions</p>
                    </div>
                    <div class="result-card__body">
                        <div class="sus-comparison">
                            <div class="sus-metric">
                                <span class="sus-label">Near-shore</span>
                                <strong class="sus-value" data-co2-near>–</strong>
                            </div>
                            <div class="sus-metric">
                                <span class="sus-label">Long-haul</span>
                                <strong class="sus-value" data-co2-long>–</strong>
                            </div>
                        </div>
                        <p class="result-delta" data-co2-delta>–</p>
                        <p class="result-note">Estimated monthly CO₂ reduction using near-shore operations.</p>
                    </div>
                </article>

                <!-- Freight Miles -->
                <article class="result-card result-card--sustainability">
                    <div class="result-card__header">
                        <p class="result-label">Freight Miles</p>
                    </div>
                    <div class="result-card__body">
                        <div class="sus-comparison">
                            <div class="sus-metric">
                                <span class="sus-label">Near-shore</span>
                                <strong class="sus-value" data-miles-near>–</strong>
                            </div>
                            <div class="sus-metric">
                                <span class="sus-label">Long-haul</span>
                                <strong class="sus-value" data-miles-long>–</strong>
                            </div>
                        </div>
                        <p class="result-delta" data-miles-delta>–</p>
                        <p class="result-note">Estimated reduction in total freight miles per month.</p>
                    </div>
                </article>

                <!-- Waste Footprint -->
                <article class="result-card result-card--sustainability">
                    <div class="result-card__header">
                        <p class="result-label">Waste Footprint</p>
                    </div>
                    <div class="result-card__body">
                        <div class="sus-comparison">
                            <div class="sus-metric">
                                <span class="sus-label">Near-shore</span>
                                <strong class="sus-value" data-waste-near>–</strong>
                            </div>
                            <div class="sus-metric">
                                <span class="sus-label">Long-haul</span>
                                <strong class="sus-value" data-waste-long>–</strong>
                            </div>
                        </div>
                        <p class="result-delta" data-waste-delta>–</p>
                        <p class="result-note">Reduced waste from minimizing containerization.</p>
                    </div>
                </article>

                <!-- Packaging Footprint -->
                <article class="result-card result-card--sustainability">
                    <div class="result-card__header">
                        <p class="result-label">Packaging Footprint</p>
                    </div>
                    <div class="result-card__body">
                        <div class="sus-comparison">
                            <div class="sus-metric">
                                <span class="sus-label">Near-shore</span>
                                <strong class="sus-value" data-packaging-near>–</strong>
                            </div>
                            <div class="sus-metric">
                                <span class="sus-label">Long-haul</span>
                                <strong class="sus-value" data-packaging-long>–</strong>
                            </div>
                        </div>
                        <p class="result-delta" data-packaging-delta>–</p>
                        <p class="result-note">Lower packaging footprint from streamlined handling.</p>
                    </div>
                </article>

            </div>

            <div class="sustainability-summary-box">
                <p data-sustainability-summary>Enter volume and category above to help us calculate your estimated
                    impact.</p>
            </div>

        </div>
    </section>
</main>

<?php get_footer(); ?>