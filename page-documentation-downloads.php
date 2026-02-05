<?php
/**
 * Template Name: Documentation Downloads
 */

get_header();
?>

<main class="compliance-page">

    <!-- Hero Section -->
    <section class="page-hero page-hero--compact compliance-hero">
        <div class="container">
            <h1 class="headline-xl">Documentation Hub</h1>
            <p class="subhead">Central access for all technical files. Share this link as the single source of truth for
                FDA registration proof, packaging specs, and certificates.</p>
        </div>
    </section>

    <!-- Downloads Section -->
    <section class="page-section page-section--light compliance-section compliance-downloads" id="downloads">
        <div class="container">

            <div class="doc-downloads">

                <!-- 1. FDA / U.S. Compliance -->
                <details class="compliance-accordion">
                    <summary>
                        <span class="accordion-title">FDA / U.S. Compliance</span>
                        <span class="accordion-desc">Registration, listings, and import authorization</span>
                    </summary>
                    <div class="accordion-content">
                        <ul class="doc-list">
                            <li>FDA Establishment Registration</li>
                            <li>Device Listing certificates</li>
                            <li>510(k) summaries (if applicable)</li>
                            <li>Letter of Authorization (LOA) for import</li>
                            <li>ESG / FDA Importer ID (for transparency)</li>
                        </ul>
                    </div>
                </details>

                <!-- 2. Quality & Manufacturing -->
                <details class="compliance-accordion">
                    <summary>
                        <span class="accordion-title">Quality &amp; Manufacturing</span>
                        <span class="accordion-desc">ISO 13485, sterilization, and testing reports</span>
                    </summary>
                    <div class="accordion-content">
                        <ul class="doc-list">
                            <li>ISO 13485 certificate</li>
                            <li>ISO 9001 certificate (if applicable)</li>
                            <li>GMP compliance letter</li>
                            <li>Sterilization validation reports (EtO / Steam)</li>
                            <li>Biocompatibility testing</li>
                            <li>Viral penetration testing (ASTM F1671)</li>
                            <li>Synthetic blood penetration testing</li>
                            <li>Flammability testing</li>
                            <li>Cytotoxicity / irritation testing</li>
                            <li>Shelf-life validation summary</li>
                            <li>Environmental monitoring summary</li>
                        </ul>
                    </div>
                </details>

                <!-- 3. Standards & Performance -->
                <details class="compliance-accordion">
                    <summary>
                        <span class="accordion-title">Standards &amp; Performance</span>
                        <span class="accordion-desc">AAMI and ASTM performance charts</span>
                    </summary>
                    <div class="accordion-content">
                        <ul class="doc-list">
                            <li>AAMI PB70 level certifications for gowns</li>
                            <li>ASTM F2100 mask performance charts</li>
                            <li>Filtration and breathability reports</li>
                            <li>Material safety data sheets (MSDS)</li>
                            <li>Latex-free declarations</li>
                            <li>Country-of-origin certification</li>
                        </ul>
                    </div>
                </details>

                <!-- 4. Product Documentation (Nested) -->
                <details class="compliance-accordion">
                    <summary>
                        <span class="accordion-title">Product Documentation</span>
                        <span class="accordion-desc">Specs, IFUs, and safety data</span>
                    </summary>
                    <div class="accordion-content">

                        <details class="sub-accordion">
                            <summary>Product Specification Sheets</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Dimensions, materials, compliance standards</li>
                                    <li>Sterility status, color, weight, thickness</li>
                                    <li>Reference photo</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Pack Configuration Sheets</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Standard pack layouts</li>
                                    <li>Premium pack layouts</li>
                                    <li>Custom pack capabilities</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Instructions for Use (IFU)</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Sterile product IFUs</li>
                                    <li>Patient-contact material IFUs</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>UDI / GTIN Information</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Labeling examples and barcode formatting</li>
                                    <li>GMDN codes (optional)</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Safety &amp; Handling</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Storage requirements and disposal instructions</li>
                                    <li>Latex/chemical avoidance notes</li>
                                </ul>
                            </div>
                        </details>

                    </div>
                </details>

                <!-- 5. Logistics (Nested) -->
                <details class="compliance-accordion">
                    <summary>
                        <span class="accordion-title">Logistics, Packaging &amp; Supply Chain</span>
                        <span class="accordion-desc">Pallet specs, lead times, and customs</span>
                    </summary>
                    <div class="accordion-content">

                        <details class="sub-accordion">
                            <summary>Packaging &amp; Palletization Specs</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Case pack, dimensions, and weight</li>
                                    <li>Pallet pattern, height, and weight</li>
                                    <li>HTS code, country of origin, labeling format</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Lead Times &amp; MOQs</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Standard lead-time bands</li>
                                    <li>Surge capacity details</li>
                                    <li>Production scheduling window and MOQ per SKU</li>
                                    <li>Emergency replenishment pathways</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Logistics Flow Diagram</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Manufacturing → QA → CEDIS → Border crossing → U.S. 3PL → Customer</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Certificates of Conformance</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Sample CoC for hospital reference</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Border / Customs Compliance</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>USMCA eligibility statement</li>
                                    <li>Certificate of Origin</li>
                                    <li>Importer/Exporter ID numbers</li>
                                </ul>
                            </div>
                        </details>

                    </div>
                </details>

                <!-- 6. Corporate & Legal -->
                <details class="compliance-accordion">
                    <summary>
                        <span class="accordion-title">Corporate &amp; Legal</span>
                        <span class="accordion-desc">Business entity, insurance, and policies</span>
                    </summary>
                    <div class="accordion-content">

                        <details class="sub-accordion">
                            <summary>Corporate Overview</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>EIN, CAGE code, DUNS number</li>
                                    <li>Business registration documents (optional)</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Insurance Certificates</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>General liability</li>
                                    <li>Product liability</li>
                                    <li>Workers comp</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Ethical &amp; Compliance Policies</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Code of Conduct</li>
                                    <li>Anti-bribery and corruption statement</li>
                                    <li>Supply chain transparency policy</li>
                                    <li>Environmental impact statement</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Terms &amp; Conditions</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Sales terms and warranty</li>
                                    <li>Returns/claims policy</li>
                                </ul>
                            </div>
                        </details>

                        <details class="sub-accordion">
                            <summary>Privacy &amp; Cookie Policies</summary>
                            <div class="sub-accordion-content">
                                <ul class="doc-list">
                                    <li>Privacy policy</li>
                                    <li>Cookie policy</li>
                                </ul>
                            </div>
                        </details>

                    </div>
                </details>
            </div>

            <!-- NOTARIZED CTA -->
            <div class="notarized-cta">
                <div class="notarized-cta__content">
                    <h3>Need signed or notarized copies?</h3>
                    <p>We provide authenticated documents for government tenders and legal review. Please request
                        specific certifications via our compliance desk.</p>
                </div>
                <div class="notarized-cta__action">
                    <a href="mailto:compliance@florenceinternational.health" class="btn btn-secondary btn-sm">Request
                        authenticated copies</a>
                </div>
            </div>

            <!-- ACCORDION SCRIPT -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const details = document.querySelectorAll('.compliance-accordion');

                    details.forEach((targetDetail) => {
                        targetDetail.addEventListener('click', () => {
                            // Close close other open details
                            details.forEach((detail) => {
                                if (detail !== targetDetail) {
                                    detail.removeAttribute('open');
                                }
                            });
                        });
                    });
                });
            </script>
        </div>
    </section>

</main>

<?php get_footer(); ?>