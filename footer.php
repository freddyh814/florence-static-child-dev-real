<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Florence_Static_Child
 */

?>

<footer id="colophon" class="site-footer">
    <div class="container footer-grid">

        <!-- Column 1: Brand & Contact -->
        <div class="footer-col footer-brand">
            <div class="footer-logo">
                <span class="logo-text">FLORENCE</span>
                <span class="logo-text-sub">INTERNATIONAL</span>
            </div>
            <div class="footer-contact">
                <p class="contact-item">
                    <strong>Sales:</strong> <a
                        href="mailto:sales@florenceinternational.health">sales@florenceinternational.health</a>
                </p>
                <p class="contact-item">
                    <strong>Samples:</strong> <a
                        href="mailto:samples@florenceinternational.health">samples@florenceinternational.health</a>
                </p>
                <p class="contact-item">
                    <a href="tel:+18005550199">1-800-555-0199</a>
                </p>
            </div>
            <div class="footer-trust">
                <span>FDA-compliant importing</span>
                <span>•</span>
                <span>USMCA support</span>
            </div>
        </div>

        <!-- Column 2: Get Started (Grouped Actions) -->
        <div class="footer-col footer-nav">
            <h4 class="footer-heading">Get Started</h4>
            <ul class="footer-links footer-actions-list">
                <li><a href="/request-samples/" class="action-link">Request Samples</a></li>
                <li><a href="/quote/" class="action-link">Request a Quote</a></li>
                <li><a href="/contact/" class="action-link">Schedule a Meeting</a></li>
            </ul>
        </div>

        <!-- Column 3: Company & Resources -->
        <div class="footer-col footer-nav">
            <h4 class="footer-heading">Company</h4>
            <ul class="footer-links">
                <li><a href="/about/">About Us</a></li>
                <li><a href="/careers/">Careers</a></li>
                <li><a href="/contact/">Contact</a></li>
            </ul>

            <h4 class="footer-heading" style="margin-top: 24px;">Resources</h4>
            <ul class="footer-links">
                <li><a href="/compliance/">Compliance</a></li>
                <li><a href="/logistics/">Logistics</a></li>
                <li><a href="/faqs/">FAQs</a></li>
            </ul>
        </div>

        <!-- Column 4: Operations Map (Restored) -->
        <div class="footer-col footer-map">
            <h4 class="footer-heading">Operations Footprint</h4>
            <div class="footer-map__embed" aria-label="Interactive map of Florence International logistics hubs">
                <div class="footer-map__canvas" id="operations-map-canvas" role="presentation" aria-hidden="true"></div>
            </div>
            <div class="footer-locations">
                <span>Shanghai</span> <span class="sep">•</span>
                <span>Los Angeles</span> <span class="sep">•</span>
                <span>New York</span> <span class="sep">•</span>
                <span>Laredo</span>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> Florence International. All rights reserved.
            </div>
            <div class="footer-policies">
                <a href="/privacy-policy/">Privacy Policy</a>
                <a href="/terms/">Terms</a>
                <a href="/cookie-policy/">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<!-- Initialize Map Script (Inline for simplicity, or ensure parent enqueues it) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof L !== 'undefined' && document.getElementById('operations-map-canvas')) {
            var map = L.map('operations-map-canvas', {
                center: [30, -100],
                zoom: 3,
                scrollWheelZoom: false,
                attributionControl: false,
                zoomControl: true
            });
            // CartoDB Positron (Clean)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 19
            }).addTo(map);

            // Locations
            var locations = [
                { lat: 31.2304, lng: 121.4737, title: "Shanghai" },
                { lat: 34.0522, lng: -118.2437, title: "Los Angeles" },
                { lat: 40.7128, lng: -74.0060, title: "New York" },
                { lat: 27.5036, lng: -99.5076, title: "Laredo" },
                { lat: 39.7392, lng: -104.9903, title: "Denver" }
            ];

            locations.forEach(function (loc) {
                L.circleMarker([loc.lat, loc.lng], {
                    color: '#2563eb',
                    fillColor: '#2563eb',
                    fillOpacity: 0.8,
                    radius: 6
                }).addTo(map).bindPopup(loc.title);
            });
        }
    });
</script>

<?php wp_footer(); ?>
</body>

</html>