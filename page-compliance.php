<?php
/**
 * Template Name: Compliance Library
 * 
 * A custom template to enforce strict text wrapping, professional layout,
 * and specific content hierarchy for the Compliance Library.
 */

get_header();
?>

<main class="compliance-page">

    <!-- 1. HERO SECTION -->
    <section class="compliance-hero">
        <div class="container mobile-stack">
            <div class="compliance-hero__content">
                <h1 class="headline-xl"><?php esc_html_e('Compliance Library', 'florence-static'); ?></h1>
                <p class="subhead">
                    This library keeps every document buyers and regulators ask for straight from the source.
                    We use FDA accurate language (registered/listed for establishments and devices; 510(k) cleared only
                    where applicable)
                    and never label PPE as FDA approved. Verify everything here and mirror the file names across
                    WordPress, quotes, and shared folders.
                </p>
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo esc_url(home_url('/documentation-downloads/')); ?>">
                        <?php esc_html_e('View compliance documents', 'florence-static'); ?>
                    </a>
                    <a class="btn btn-secondary" href="<?php echo esc_url(home_url('/contact/')); ?>">
                        <?php esc_html_e('Talk with compliance', 'florence-static'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. U.S. REGULATORY STATUS (MOVED TO TOP) -->
    <section class="compliance-section" id="fda-importer">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Priority Status</span>
                <h2 class="section-title">U.S. Regulatory Status</h2>
                <p class="section-lead">Current registration and listing status for U.S. Import and Manufacturing
                    entities.</p>
            </div>

            <div class="compliance-grid compliance-grid--2col">
                <article class="compliance-card status-card display-active">
                    <div class="card-header">
                        <h3>FDA Establishment Registration</h3>
                        <span class="status-pill">Active</span>
                    </div>
                    <div class="card-body">
                        <p>Importer (U.S.) and manufacturer (Mexico) registration numbers with prefilled RL links.</p>
                        <a href="#" class="btn-link">Verify Registration &rarr;</a>
                    </div>
                </article>

                <article class="compliance-card status-card display-active">
                    <div class="card-header">
                        <h3>FDA Device Listings</h3>
                        <span class="status-pill">Listed</span>
                    </div>
                    <div class="card-body">
                        <p>List by product family with product codes (FXX, FYA, etc.) and listing IDs.</p>
                        <a href="#" class="btn-link">View Listings &rarr;</a>
                    </div>
                </article>

                <article class="compliance-card status-card">
                    <div class="card-header">
                        <h3>510(k) Summaries</h3>
                        <span class="status-pill mode-applicable">Applicable Devices Only</span>
                    </div>
                    <div class="card-body">
                        <p>Upload only if you have clearance; include K number or note "Not applicable" for Class I
                            exempt.</p>
                        <a href="#" class="btn-link">Download 510(k) &rarr;</a>
                    </div>
                </article>

                <article class="compliance-card status-card">
                    <div class="card-header">
                        <h3>Importer of Record</h3>
                        <span class="status-pill">Verified</span>
                    </div>
                    <div class="card-body">
                        <p>PDF outlining importer role, U.S. Agent, EIN, and compliance contacts.</p>
                        <a href="#" class="btn-link">Download Statement &rarr;</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- 3. QUALITY SYSTEMS & CERTIFICATIONS -->
    <section class="compliance-section alt-bg" id="iso13485">
        <div class="container">
            <h2 class="section-title">Quality Systems & Certifications</h2>
            <div class="compliance-grid compliance-grid--4col">

                <article class="compliance-card simple-card">
                    <h3>ISO 13485:2016</h3>
                    <p class="meta">Medical Device Quality Management</p>
                    <p>Covers Intercambio Global Latinoaméricascope and expiry.</p>
                    <a href="#" class="card-action">View Certificate</a>
                </article>

                <article class="compliance-card simple-card">
                    <h3>Sterilization Validation</h3>
                    <p class="meta">ISO 11135 / ISO 11137</p>
                    <p>Method (EO or Gamma), SAL 10^-6, lab, and issuance date.</p>
                    <a href="#" class="card-action">View Validation</a>
                </article>

                <article class="compliance-card simple-card">
                    <h3>Internal QA Summary</h3>
                    <p class="meta">Audit & Controls</p>
                    <p>Audit cadence, key controls, and responsible team structure.</p>
                    <a href="#" class="card-action">Download Overview</a>
                </article>

                <article class="compliance-card simple-card">
                    <h3>GMP Compliance</h3>
                    <p class="meta">21 CFR Part 820</p>
                    <p>Declaration of conformity to U.S. Good Manufacturing Practices.</p>
                    <a href="#" class="card-action">View Letter</a>
                </article>

            </div>
        </div>
    </section>

    <!-- 4. STANDARDS & TEST REPORTS -->
    <section class="compliance-section" id="barrier-testing">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Standards & Test Reports</h2>
                <p class="section-lead">Pair every performance claim with a current lab report.</p>
            </div>

            <div class="compliance-grid compliance-grid--3col">

                <!-- Gowns -->
                <article class="compliance-card report-card">
                    <h3>Surgical & Isolation Gowns</h3>
                    <div class="report-list-wrap">
                        <ul class="report-list">
                            <li>
                                <a href="#">AAMI PB70 Level 1 (IGL_2025-10)</a>
                            </li>
                            <li>
                                <a href="#">AAMI PB70 Level 2 (IGL_2025-10)</a>
                            </li>
                            <li>
                                <a href="#">AAMI PB70 Level 3 (IGL_2025-10)</a>
                            </li>
                            <li>
                                <a href="#">ASTM F1671 Viral Penetration (Level 4)</a>
                            </li>
                        </ul>
                    </div>
                </article>

                <!-- Masks -->
                <article class="compliance-card report-card">
                    <h3>Surgical Masks</h3>
                    <div class="report-list-wrap">
                        <ul class="report-list">
                            <li>
                                <a href="#">ASTM F2100 Level 1 Report</a>
                            </li>
                            <li>
                                <a href="#">ASTM F2100 Level 2 Report</a>
                            </li>
                            <li>
                                <a href="#">ASTM F2100 Level 3 Report</a>
                            </li>
                        </ul>
                    </div>
                </article>

                <!-- Packs -->
                <article class="compliance-card report-card">
                    <h3>Procedure Packs</h3>
                    <div class="report-list-wrap">
                        <ul class="report-list">
                            <li>
                                <a href="#">BOM Pack Standard Verification</a>
                            </li>
                            <li>
                                <a href="#">Sterility Pack Premium Verification</a>
                            </li>
                        </ul>
                    </div>
                </article>

            </div>

            <div class="naming-convention-note">
                <strong>Doc naming format:</strong>
                &lt;Standard&gt;_&lt;Product&gt;_&lt;Entity&gt;_&lt;YYYY-MM&gt;_vX.Y.pdf
            </div>
        </div>
    </section>

    <!-- 5. LABELING & IFUs -->
    <section class="compliance-section alt-bg">
        <div class="container">
            <h2 class="section-title">Labeling & Instructions for Use (IFU)</h2>
            <div class="compliance-grid compliance-grid--3col">
                <article class="compliance-card">
                    <h3>UDI & GTIN Samples</h3>
                    <p>Carton, inner pack, and sterile pack labels with GTIN, lot, expiry, and AAMI/ASTM level.</p>
                    <a href="#" class="btn-link">View Label Pack</a>
                </article>
                <article class="compliance-card">
                    <h3>Instructions for Use</h3>
                    <p>Bilingual IFUs for gowns, masks, drapes, and accessory kits.</p>
                    <a href="#" class="btn-link">View IFUs</a>
                </article>
                <article class="compliance-card">
                    <h3>UDI Data Table</h3>
                    <p>SKU, device identifier, production identifier, performance level, and label version.</p>
                    <a href="#" class="btn-link">Download Data Sheet</a>
                </article>
            </div>
        </div>
    </section>

    <!-- 6. DOCUMENTATION HUB (GATEWAY) -->
    <section class="compliance-section" id="downloads">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Documentation Hub</h2>
                <p class="section-lead">Central access for all technical files. Share this link as the single source of
                    truth.</p>
                <a class="btn btn-primary" href="<?php echo esc_url(home_url('/documentation-downloads/')); ?>">Open
                    Full Hub</a>
            </div>

            <div class="compliance-grid compliance-grid--4col tiny-gap">
                <!-- Categories -->
                <div class="hub-category">
                    <h4>FDA / U.S. Compliance</h4>
                    <ul>
                        <li>FDA Establishment Registration</li>
                        <li>Device Listing certificates</li>
                        <li>510(k) summaries</li>
                    </ul>
                </div>
                <div class="hub-category">
                    <h4>Quality & Manufacturing</h4>
                    <ul>
                        <li>ISO 13485 certificate</li>
                        <li>Sterilization validation</li>
                        <li>Biocompatibility testing</li>
                    </ul>
                </div>
                <div class="hub-category">
                    <h4>Product Specs</h4>
                    <ul>
                        <li>Spec Sheets & Dimensions</li>
                        <li>Pack Configurations</li>
                        <li>Material Safety (MSDS)</li>
                    </ul>
                </div>
                <div class="hub-category">
                    <h4>Logistics</h4>
                    <ul>
                        <li>Packaging & Palletization</li>
                        <li>Lead Times & MOQs</li>
                        <li>Customs Compliance</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. OPERATIONAL & CORPORATE (COLLAPSIBLE) -->
    <section class="compliance-section alt-bg">
        <div class="container">
            <h2 class="section-title">Operational / Internal Reference</h2>

            <details class="compliance-accordion">
                <summary>Logistics, Packaging & Supply Chain</summary>
                <div class="accordion-content">
                    <div class="compliance-grid compliance-grid--3col">
                        <div>
                            <h4>Packaging Specs</h4>
                            <ul>
                                <li>Case pack, dimensions, and weight</li>
                                <li>Pallet pattern, height, and weight</li>
                                <li>HTS code, country of origin</li>
                            </ul>
                        </div>
                        <div>
                            <h4>Lead Times & MOQs</h4>
                            <ul>
                                <li>Standard lead-time bands</li>
                                <li>Surge capacity details</li>
                                <li>Replenishment pathways</li>
                            </ul>
                        </div>
                        <div>
                            <h4>Logistics Flow</h4>
                            <ul>
                                <li>Mfg &rarr; QA &rarr; CEDIS &rarr; Border &rarr; U.S. 3PL</li>
                                <li>Certificates of Conformance</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </details>

            <details class="compliance-accordion">
                <summary>Corporate & Legal Documentation</summary>
                <div class="accordion-content">
                    <div class="compliance-grid compliance-grid--3col">
                        <div>
                            <h4>Corporate Overview</h4>
                            <ul>
                                <li>EIN, CAGE code, DUNS number</li>
                                <li>Business registration documents</li>
                            </ul>
                        </div>
                        <div>
                            <h4>Insurance</h4>
                            <ul>
                                <li>General / Product liability</li>
                                <li>Workers comp</li>
                            </ul>
                        </div>
                        <div>
                            <h4>Policies</h4>
                            <ul>
                                <li>Code of Conduct</li>
                                <li>Anti-bribery / Supply Chain</li>
                                <li>Privacy & Terms</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </details>

        </div>
    </section>

    <!-- 8. CROSS REFERENCE TABLE -->
    <section class="compliance-section" id="regional-compliance">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Cross Reference (Mexico to U.S.)</h2>
                <p class="section-lead">Mapping Mexican Clave Sector Salud codes to Florence SKUs.</p>
            </div>

            <div class="table-responsive-wrapper">
                <table class="compliance-table">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Florence SKU</th>
                            <th>GTIN</th>
                            <th class="col-desc">Description</th>
                            <th>Sterility</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>[Clave]</td>
                            <td>[SKU]</td>
                            <td>[GTIN]</td>
                            <td>[Description]</td>
                            <td>[Sterile/Non]</td>
                            <td>[Level]</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-actions">
                <a href="#" class="btn btn-secondary btn-sm">Download CSV Master</a>
            </div>
        </div>
    </section>

    <!-- 9. VERIFICATION WORKFLOW -->
    <section class="compliance-section" id="verification-steps">
        <div class="container">
            <h2 class="section-title">How to Verify Our Regulatory Status</h2>

            <div class="steps-container">
                <div class="step-item">
                    <span class="step-num">1</span>
                    <div class="step-content">
                        <h4>Check FDA Registration</h4>
                        <p>Use prefilled FDA RL links for both entities. Confirm status is "Active".</p>
                        <a href="#" class="step-link">Open FDA Database (Importer)</a>
                        <a href="#" class="step-link">Open FDA Database (Mfg)</a>
                    </div>
                </div>

                <div class="step-item">
                    <span class="step-num">2</span>
                    <div class="step-content">
                        <h4>Confirm Device Listings</h4>
                        <p>Match Product Code (e.g. FYA) and Device Class to the RL detail page.</p>
                    </div>
                </div>

                <div class="step-item">
                    <span class="step-num">3</span>
                    <div class="step-content">
                        <h4>Match Test Reports</h4>
                        <p>Ensure the test date precedes the first sale and names the correct model.</p>
                    </div>
                </div>

                <div class="step-item">
                    <span class="step-num">4</span>
                    <div class="step-content">
                        <h4>Verify Update Cadence</h4>
                        <p>Library reviewed quarterly. FDA data refreshes weekly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. FOOTER NOTES / DOCUMENT CONTROL -->
    <section class="compliance-section page-section--note">
        <div class="container">
            <div class="footer-notes-grid">
                <div class="note-block">
                    <h5>Directions for Buyers</h5>
                    <ul>
                        <li>Need a doc? Email <a
                                href="mailto:compliance@florenceinternational.health">compliance@florenceinternational.health</a>
                        </li>
                        <li>Use this library for quotes/bids. Do not duplicate.</li>
                    </ul>
                </div>
                <div class="note-block">
                    <h5>Regulatory Note</h5>
                    <p>Registration is not FDA approval. We use accurate terms: registered/listed. Approval applies to
                        PMA devices, not Class I/II PPE.</p>
                </div>
            </div>

            <!-- Internal Checklist (Collapsed Default) -->
            <details class="internal-checklist">
                <summary>Internal Document Control Checklist</summary>
                <ul>
                    <li>Log every document source, owner, and review date.</li>
                    <li>Ensure product claims reference a library doc.</li>
                    <li>Replace PDFs immediately on renewal.</li>
                </ul>
            </details>
        </div>
    </section>

</main>

<?php get_footer(); ?>