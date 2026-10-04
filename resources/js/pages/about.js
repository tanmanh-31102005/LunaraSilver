/**
 * Lunara Silver — Luxury Editorial About Page
 * Handles IntersectionObserver scroll reveals & smooth hero interaction
 */

export function initAboutPage() {
    const aboutPage = document.querySelector('.about-page');
    if (!aboutPage) return;

    // Check user accessibility preference for reduced motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // 1. Intersection Observer for Scroll Reveals
    const revealElements = aboutPage.querySelectorAll('.about-reveal');
    if (revealElements.length > 0) {
        if (prefersReducedMotion || !('IntersectionObserver' in window)) {
            // Immediately reveal without animation
            revealElements.forEach((el) => el.classList.add('is-visible'));
        } else {
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -40px 0px',
            });

            revealElements.forEach((el) => revealObserver.observe(el));
        }
    }

    // 2. Smooth Scroll for Hero Editorial CTA
    const heroCta = aboutPage.querySelector('#heroScrollCta');
    if (heroCta) {
        heroCta.addEventListener('click', (e) => {
            const targetId = heroCta.getAttribute('href');
            if (targetId && targetId.startsWith('#')) {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    if (prefersReducedMotion) {
                        targetElement.scrollIntoView();
                    } else {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start',
                        });
                    }
                }
            }
        });
    }
}
