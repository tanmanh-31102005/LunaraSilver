/**
 * Lunara Mobile Sticky Add-to-Cart Bar (Phase 19.42 - 19.44)
 */

export function initMobileStickyBar() {
    const stickyBar = document.querySelector('#mobileStickyBar');
    if (!stickyBar) return;

    const mainCta = document.querySelector('.detail-cta') || document.querySelector('#detail-quantity');
    const footer = document.querySelector('.site-footer');

    if (!mainCta) return;

    let isCtaVisible = true;
    let isFooterVisible = false;

    function updateStickyState() {
        if (!isCtaVisible && !isFooterVisible) {
            stickyBar.classList.add('mobile-sticky-bar--visible');
            stickyBar.setAttribute('aria-hidden', 'false');
        } else {
            stickyBar.classList.remove('mobile-sticky-bar--visible');
            stickyBar.setAttribute('aria-hidden', 'true');
        }
    }

    // Observer for main CTA form
    const ctaObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            isCtaVisible = entry.isIntersecting;
            updateStickyState();
        });
    }, {
        root: null,
        threshold: 0.1
    });

    ctaObserver.observe(mainCta);

    // Observer for footer (never obstruct footer)
    if (footer) {
        const footerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                isFooterVisible = entry.isIntersecting;
                updateStickyState();
            });
        }, {
            root: null,
            threshold: 0.05
        });

        footerObserver.observe(footer);
    }
}
