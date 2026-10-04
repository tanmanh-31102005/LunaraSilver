/**
 * Lunara Luxury Mega Menu & Surface State Machine (Phase 19A)
 *
 * Implements:
 * - Hover with 100ms entry delay & 180ms exit grace period
 * - Zero-flicker panel swapping
 * - Hover corridor bridge support
 * - Single-surface state machine (NONE, MEGA_MENU, SEARCH, CART, MOBILE_NAV)
 * - Keyboard navigation (Tab, Shift+Tab, Escape)
 * - Backdrop soft dimming
 * - Touch & pointer queries
 */

export function initMegaMenu() {
    const header = document.querySelector('.site-header');
    const megaMenu = document.querySelector('#megaMenu');
    const backdrop = document.querySelector('#megaMenuBackdrop');
    const triggers = document.querySelectorAll('[data-mega-trigger]');
    const panels = document.querySelectorAll('[data-mega-panel]');

    if (!header || !megaMenu || triggers.length === 0) {
        return;
    }

    let openTimer = null;
    let closeTimer = null;
    let currentPanelId = null;
    let isOpen = false;
    let lastActiveTrigger = null;

    const OPEN_DELAY = 100;
    const CLOSE_DELAY = 180;

    // Helper: is fine pointer with hover (desktop)
    const canHover = () => window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    /**
     * State Machine: Close other surfaces when Mega Menu opens
     */
    function dismissOtherSurfaces() {
        // 1. Close Search Overlay if open
        const searchOverlay = document.querySelector('#searchOverlay');
        if (searchOverlay && !searchOverlay.hasAttribute('hidden')) {
            const closeBtn = searchOverlay.querySelector('#searchOverlayClose');
            if (closeBtn) {
                closeBtn.click();
            } else {
                searchOverlay.setAttribute('hidden', '');
                document.body.style.overflow = '';
            }
        }

        // 2. Close Cart Drawer if open
        const miniCart = document.querySelector('#miniCart');
        if (miniCart && miniCart.classList.contains('show') && window.bootstrap?.Offcanvas) {
            const bsOffcanvas = window.bootstrap.Offcanvas.getInstance(miniCart);
            bsOffcanvas?.hide();
        }

        // 3. Close Mobile Navigation if open
        const mobileNav = document.querySelector('#mobileNavigation');
        if (mobileNav && mobileNav.classList.contains('show') && window.bootstrap?.Offcanvas) {
            const bsOffcanvas = window.bootstrap.Offcanvas.getInstance(mobileNav);
            bsOffcanvas?.hide();
        }
    }

    /**
     * Activate a specific panel
     */
    function switchPanel(panelId) {
        let found = false;

        panels.forEach(panel => {
            if (panel.dataset.megaPanel === panelId) {
                panel.removeAttribute('hidden');
                panel.classList.add('is-active');
                found = true;
            } else {
                panel.setAttribute('hidden', '');
                panel.classList.remove('is-active');
            }
        });

        triggers.forEach(trigger => {
            const isActive = trigger.dataset.megaTrigger === panelId;
            trigger.setAttribute('aria-expanded', isActive ? 'true' : 'false');
            trigger.classList.toggle('is-mega-active', isActive);
            if (isActive) {
                lastActiveTrigger = trigger;
            }
        });

        currentPanelId = found ? panelId : null;
    }

    /**
     * Open Mega Menu
     */
    function openMenu(panelId, triggerEl) {
        clearTimeout(closeTimer);
        closeTimer = null;

        dismissOtherSurfaces();
        switchPanel(panelId);

        if (!isOpen) {
            megaMenu.removeAttribute('hidden');
            if (backdrop) {
                backdrop.removeAttribute('hidden');
            }

            // Force reflow for smooth CSS transitions
            void megaMenu.offsetWidth;

            megaMenu.classList.add('is-open');
            if (backdrop) {
                backdrop.classList.add('is-active');
            }
            isOpen = true;
        }

        if (triggerEl) {
            lastActiveTrigger = triggerEl;
        }
    }

    /**
     * Close Mega Menu
     */
    function closeMenu() {
        clearTimeout(openTimer);
        clearTimeout(closeTimer);
        openTimer = null;
        closeTimer = null;

        if (!isOpen) return;

        megaMenu.classList.remove('is-open');
        if (backdrop) {
            backdrop.classList.remove('is-active');
        }

        triggers.forEach(trigger => {
            trigger.setAttribute('aria-expanded', 'false');
            trigger.classList.remove('is-mega-active');
        });

        isOpen = false;
        currentPanelId = null;

        // Clean up DOM after transition finishes
        setTimeout(() => {
            if (!isOpen) {
                megaMenu.setAttribute('hidden', '');
                panels.forEach(p => {
                    p.setAttribute('hidden', '');
                    p.classList.remove('is-active');
                });
                if (backdrop) {
                    backdrop.setAttribute('hidden', '');
                }
            }
        }, 200);
    }

    /**
     * Schedule open with debounce delay
     */
    function scheduleOpen(panelId, triggerEl) {
        clearTimeout(closeTimer);
        closeTimer = null;

        if (isOpen) {
            // Already open -> instant swap without delay or re-animating
            switchPanel(panelId);
        } else {
            clearTimeout(openTimer);
            openTimer = setTimeout(() => {
                openMenu(panelId, triggerEl);
            }, OPEN_DELAY);
        }
    }

    /**
     * Schedule close with grace delay
     */
    function scheduleClose() {
        clearTimeout(openTimer);
        openTimer = null;

        clearTimeout(closeTimer);
        closeTimer = setTimeout(() => {
            closeMenu();
        }, CLOSE_DELAY);
    }

    // --- Hover Interactions ---
    triggers.forEach(trigger => {
        const panelId = trigger.dataset.megaTrigger;

        trigger.addEventListener('mouseenter', () => {
            if (!canHover()) return;
            scheduleOpen(panelId, trigger);
        });

        trigger.addEventListener('focusin', () => {
            openMenu(panelId, trigger);
        });
    });

    // When cursor is inside the mega menu or its bridge, stay open!
    megaMenu.addEventListener('mouseenter', () => {
        if (!canHover()) return;
        clearTimeout(closeTimer);
        closeTimer = null;
    });

    megaMenu.addEventListener('mouseleave', (e) => {
        if (!canHover()) return;
        // If moving back to header, let header mouseenter handle it
        scheduleClose();
    });

    // When cursor leaves header, schedule close
    header.addEventListener('mouseleave', (e) => {
        if (!canHover()) return;
        // Check if moving directly into megaMenu
        const related = e.relatedTarget;
        if (related && megaMenu.contains(related)) {
            return;
        }
        scheduleClose();
    });

    // Backdrop click closes immediately
    if (backdrop) {
        backdrop.addEventListener('click', () => {
            closeMenu();
        });
    }

    // Keyboard Accessibility: Escape key closes menu and restores focus
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) {
            closeMenu();
            if (lastActiveTrigger) {
                lastActiveTrigger.focus();
            }
        }
    });

    // Close when focus completely leaves the header and mega menu
    document.addEventListener('focusin', (e) => {
        if (!isOpen) return;
        if (!header.contains(e.target) && !megaMenu.contains(e.target)) {
            closeMenu();
        }
    });

    // Single-Surface coordination: Close Mega Menu when Search opens
    document.querySelectorAll('[data-search-open]').forEach(btn => {
        btn.addEventListener('click', () => {
            closeMenu();
        });
    });

    // Single-Surface coordination: Close Mega Menu when Cart opens
    const miniCart = document.querySelector('#miniCart');
    if (miniCart) {
        miniCart.addEventListener('show.bs.offcanvas', () => {
            closeMenu();
        });
    }

    // Single-Surface coordination: Close Mega Menu when Mobile Nav opens
    const mobileNav = document.querySelector('#mobileNavigation');
    if (mobileNav) {
        mobileNav.addEventListener('show.bs.offcanvas', () => {
            closeMenu();
        });
    }

    // Expose close method globally if needed
    window.LunaraMegaMenu = {
        open: openMenu,
        close: closeMenu,
        isOpen: () => isOpen
    };
}
