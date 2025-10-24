/**
 * Main JavaScript file
 *
 * @package Betting_Theme_Max
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        
        // Mobile menu toggle (if needed)
        initMobileMenu();
        
        // Smooth scroll for anchor links
        initSmoothScroll();
    });

    /**
     * Mobile menu functionality
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-navigation');

        if (menuToggle && navigation) {
            menuToggle.addEventListener('click', function() {
                navigation.classList.toggle('toggled');
                this.setAttribute('aria-expanded', 
                    this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
                );
            });
        }
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href !== '#' && href !== '#0') {
                    const target = document.querySelector(href);
                    
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    }

})();
