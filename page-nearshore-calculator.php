<?php
/**
 * Template Name: Near-Shore Calculator
 */

get_header();
?>

<main class="calculator-page">

    <!-- 1. Compact Hero -->
    <section class="calculator-hero">
        <div class="container">
            <span class="eyebrow">Planning Tool</span>
            <h1 class="headline-lg">Near-Shore Advantage Calculator</h1>
            <p class="subhead">Quantify the lead-time, cost, risk, and carbon benefits of moving your PPE supply closer
                to U.S. hospitals.</p>
        </div>
    </section>

    <!-- 2. Calculator Interface -->
    <section class="nearshore-calculator" data-nearshore-calculator>
        <div class="container">

            <form class="calculator-form" novalidate>
                <div class="calculator-inputs-row">
                    <div class="input-group">
                        <label for="nearshore-volume">Monthly Case Volume</label>
                        <input type="number" id="nearshore-volume" name="nearshore-volume" min="1"
                            placeholder="e.g. 500" required>
                    </div>

                    <div class="input-group">
                        <label for="nearshore-category">Product Category</label>
                        <select id="nearshore-category" name="nearshore-category">
                            <option value="gowns">Gowns</option>
                            <option value="packs">Procedure packs</option>
                            <option value="masks">Masks</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="nearshore-frequency">Delivery Frequency</label>
                        <select id="nearshore-frequency" name="nearshore-frequency">
                            <option value="weekly">Weekly</option>
                            <option value="biweekly">Bi-weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="nearshore-buffer">Emergency Buffer (%)</label>
                        <input type="number" id="nearshore-buffer" name="nearshore-buffer" min="0" max="50" step="1"
                            placeholder="10">
                    </div>

                    <div class="input-group input-group--btn">
                        <button type="button" class="btn btn-primary btn-block" data-nearshore-submit>Calculate</button>
                    </div>
                </div>

                <div class="calculator-assumptions">
                    <small><strong>Assumptions:</strong> Calculations based on Florence near-shore operations (Jalisco
                        to Texas border) versus standard Trans-Pacific ocean freight (Shanghai to Long Beach +
                        rail/truck). Run the calculator to see estimated impact.</small>
                </div>
            </form>

            <div class="calculator-results-grid">

                <!-- Lead Time -->
                <article class="result-card">
                    <div class="result-card__header">
                        <p class="result-label">Lead Time Saved</p>
                    </div>
                    <div class="result-card__body">
                        <h3 class="result-value" data-lead-days>–</h3>
                        <p class="result-delta" data-lead-percent>–</p>
                        <p class="result-note">Estimated reduction versus 60-day ocean average.</p>
                    </div>
                </article>

                <!-- Cost Savings -->
                <article class="result-card">
                    <div class="result-card__header">
                        <p class="result-label">Cost Savings</p>
                    </div>
                    <div class="result-card__body">
                        <h3 class="result-value" data-cost-percent>–</h3>
                        <p class="result-delta" data-cost-annual>–</p>
                        <p class="result-note">Modeled against landed cost per case (USD).</p>
                    </div>
                </article>

                <!-- Risk Reduction -->
                <article class="result-card">
                    <div class="result-card__header">
                        <p class="result-label">Risk Reduction</p>
                    </div>
                    <div class="result-card__body">
                        <h3 class="result-value" data-risk-percent>–</h3>
                        <p class="result-delta" data-risk-text>–</p>
                        <p class="result-note">Lower exposure to port closures and mode volatility.</p>
                    </div>
                </article>

                <!-- Carbon Reduction -->
                <article class="result-card">
                    <div class="result-card__header">
                        <p class="result-label">Carbon Reduction</p>
                    </div>
                    <div class="result-card__body">
                        <h3 class="result-value" data-carbon-percent>–</h3>
                        <p class="result-delta">CO2e Impact</p>
                        <p class="result-note">Truck lanes vs. traditional ocean/air combos.</p>
                    </div>
                </article>

            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>