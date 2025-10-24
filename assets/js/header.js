/**
 * Header JavaScript
 * 
 * @package Betting_Theme_Max
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initHeaderMenu();
    });

    /**
     * Initialize header menu functionality
     */
    function initHeaderMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const menuItems = document.querySelectorAll('.menu-item-has-children');
        const body = document.body;

        // Mobile menu toggle
        if (menuToggle && navigation) {
            menuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                navigation.classList.toggle('toggled');
                const isExpanded = navigation.classList.contains('toggled');
                this.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                
                // Prevent body scroll when menu is open
                if (isExpanded) {
                    body.style.overflow = 'hidden';
                } else {
                    body.style.overflow = '';
                }
            });
        }

        // Mobile submenu toggle
        const primaryMenu = document.querySelector('.primary-menu');
        
        menuItems.forEach(function(item) {
            const link = item.querySelector('a');
            const submenu = item.querySelector('.sub-menu');
            
            if (link && submenu) {
                // Create submenu header with back button and parent title
                const submenuHeader = document.createElement('div');
                submenuHeader.className = 'submenu-header';
                submenuHeader.innerHTML = `
                    <button class="submenu-back" aria-label="Back">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <span class="submenu-title">${link.textContent}</span>
                `;
                
                // Insert header at the beginning of submenu
                submenu.insertBefore(submenuHeader, submenu.firstChild);
                
                // Open submenu on parent click
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 1024) {
                        e.preventDefault();
                        item.classList.add('open');
                        if (primaryMenu) {
                            primaryMenu.classList.add('submenu-active');
                        }
                    }
                });
                
                // Close submenu on back button click
                const backButton = submenuHeader.querySelector('.submenu-back');
                backButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    item.classList.remove('open');
                    if (primaryMenu) {
                        primaryMenu.classList.remove('submenu-active');
                    }
                });
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.main-navigation') && 
                !e.target.closest('.mobile-menu-toggle')) {
                if (navigation && navigation.classList.contains('toggled')) {
                    navigation.classList.remove('toggled');
                    body.style.overflow = '';
                    if (menuToggle) {
                        menuToggle.setAttribute('aria-expanded', 'false');
                    }
                }
            }
        });

        // Close menu on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navigation && navigation.classList.contains('toggled')) {
                navigation.classList.remove('toggled');
                body.style.overflow = '';
                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuToggle.focus();
                }
            }
        });

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 1024) {
                    // Reset mobile menu state on desktop
                    if (navigation && navigation.classList.contains('toggled')) {
                        navigation.classList.remove('toggled');
                        body.style.overflow = '';
                        if (menuToggle) {
                            menuToggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                    
                    // Close all open submenus
                    menuItems.forEach(function(item) {
                        item.classList.remove('open');
                    });
                }
            }, 250);
        });

        // Smooth scroll for anchor links
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href !== '#' && href !== '#0') {
                    const target = document.querySelector(href);
                    
                    if (target) {
                        e.preventDefault();
                        
                        // Close mobile menu if open
                        if (navigation && navigation.classList.contains('toggled')) {
                            navigation.classList.remove('toggled');
                            body.style.overflow = '';
                            if (menuToggle) {
                                menuToggle.setAttribute('aria-expanded', 'false');
                            }
                        }
                        
                        // Smooth scroll to target
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        
                        // Update URL without jumping
                        if (history.pushState) {
                            history.pushState(null, null, href);
                        }
                    }
                }
            });
        });
    }

})();
