/**
 * Slow-Hide Sticky Header (Parallax Effect)
 * 
 * - Fixed header that moves up slower than scroll (parallax hide).
 * - Returns smoothly on scroll up.
 * - Respects reduced motion.
 * - Prevents layout jump via body padding.
 */
(function () {
    // Feature check & Guardrails
    const header = document.querySelector('.sleek-header');
    if (!header) return;

    // Respect reduced motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (prefersReducedMotion.matches) {
        header.style.position = 'sticky';
        header.style.top = '0';
        return;
    }

    // State
    let lastScrollY = window.scrollY;
    let currentTranslateY = 0;
    let headerHeight = header.offsetHeight;
    let ticking = false;
    const SPEED_FACTOR = 0.4; // 0.4px movement per 1px scroll

    // Initialization
    function init() {
        // Enforce fixed position
        header.style.position = 'fixed';
        header.style.top = '0';
        header.style.left = '0';
        header.style.width = '100%';
        header.style.zIndex = '1000';
        header.style.transition = 'transform 0.1s linear'; // Slight smoothing, but mostly via rAF
        header.style.willChange = 'transform';

        // Initial measurement
        updateDimensions();

        // Listeners
        window.addEventListener('resize', debounce(updateDimensions, 100));
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // Measure and set overlap prevention
    function updateDimensions() {
        const adminBar = document.getElementById('wpadminbar');
        const adminBarHeight = adminBar ? adminBar.offsetHeight : 0;

        // Adjust fixed position to account for Admin Bar
        header.style.top = `${adminBarHeight}px`;

        headerHeight = header.offsetHeight;

        // Padding must account for the visual space taken
        // But since header is moved down by top property, it pushes visual flow?
        // No, 'fixed' pulls it out of flow. Padding replaces that space.
        // The space we need to reserve is headerHeight.
        document.body.style.paddingTop = `${headerHeight}px`;
    }

    // Scroll Handler
    function onScroll() {
        if (!ticking) {
            window.requestAnimationFrame(updateHeader);
            ticking = true;
        }
    }

    // Animation Loop
    function updateHeader() {
        const scrollY = window.scrollY;
        const delta = scrollY - lastScrollY;

        // Parallax Logic
        // We subtract delta * scale. 
        // Moving Down (Positive Delta) -> Translate becomes more negative (moves up)
        // Moving Up (Negative Delta) -> Translate becomes less negative (moves down)

        // Only apply parallax if we are not at the very top (bounce protection)
        if (scrollY > 0) {
            if (delta > 0) {
                // Scrolling Down: Hide slowly
                currentTranslateY -= delta * SPEED_FACTOR;
            } else {
                // Scrolling Up: Show slowly (or 1:1? Prompt says "smoothly". Parallax feel implies consistent speed)
                // Let's keep the speed factor for consistent "weight"
                currentTranslateY -= delta * SPEED_FACTOR;
            }
        } else {
            currentTranslateY = 0;
        }

        // Clamping
        // Cannot be lower than 0 (fully visible)
        // Cannot be higher than -headerHeight (fully hidden)
        currentTranslateY = Math.max(Math.min(currentTranslateY, 0), -headerHeight);

        // Apply
        // Use a tiny threshold to avoid micro-jitters at 0
        if (Math.abs(currentTranslateY) < 0.5) currentTranslateY = 0;

        header.style.transform = `translate3d(0, ${currentTranslateY}px, 0)`;

        lastScrollY = scrollY;
        ticking = false;
    }

    // Utils
    function debounce(func, wait) {
        let timeout;
        return function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, arguments), wait);
        };
    }

    // Start
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
