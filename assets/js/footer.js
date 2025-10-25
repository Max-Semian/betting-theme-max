/**
 * Footer Menu Accordion for Mobile Devices
 */

document.addEventListener('DOMContentLoaded', function() {
    const footerMenu = document.querySelector('.footer-menu');
    if (!footerMenu) return;

    let accordionInitialized = false;

    function initAccordion() {
        const menuItems = footerMenu.querySelectorAll('.menu-item-has-children');
        
        menuItems.forEach(item => {
            const link = item.querySelector(':scope > a');
            const subMenu = item.querySelector('.sub-menu');
            
            if (!link || !subMenu) return;

            // Wrap link and toggle button in a header div (only once)
            if (!item.querySelector('.footer-menu-header')) {
                const headerDiv = document.createElement('div');
                headerDiv.className = 'footer-menu-header';
                
                // Create toggle button with chevron icon
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'accordion-toggle';
                toggleBtn.setAttribute('aria-label', 'Toggle submenu');
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.innerHTML = '<svg class="chevron-icon" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                
                // Insert header before the link, then move link inside
                item.insertBefore(headerDiv, link);
                headerDiv.appendChild(link);
                headerDiv.appendChild(toggleBtn);
                
                // Make the entire header clickable
                headerDiv.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isActive = item.classList.contains('active');
                    
                    // Close all other items (optional - remove if you want multiple open)
                    menuItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            const otherSubMenu = otherItem.querySelector('.sub-menu');
                            const otherToggle = otherItem.querySelector('.accordion-toggle');
                            if (otherSubMenu) {
                                otherSubMenu.style.maxHeight = null;
                            }
                            if (otherToggle) {
                                otherToggle.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });
                    
                    // Toggle current item
                    item.classList.toggle('active');
                    toggleBtn.setAttribute('aria-expanded', !isActive);
                    
                    if (!isActive) {
                        subMenu.style.maxHeight = subMenu.scrollHeight + 'px';
                    } else {
                        subMenu.style.maxHeight = null;
                    }
                });
            }
        });
        
        accordionInitialized = true;
    }

    function destroyAccordion() {
        const menuItems = footerMenu.querySelectorAll('.menu-item-has-children');
        
        menuItems.forEach(item => {
            const headerDiv = item.querySelector('.footer-menu-header');
            if (headerDiv) {
                const link = headerDiv.querySelector('a');
                if (link) {
                    // Move link back to original position
                    item.insertBefore(link, headerDiv);
                }
                // Remove header wrapper
                headerDiv.remove();
            }
            
            const subMenu = item.querySelector('.sub-menu');
            if (subMenu) {
                subMenu.style.maxHeight = null;
            }
            
            item.classList.remove('active');
        });
        
        accordionInitialized = false;
    }

    function handleResize() {
        const isMobile = window.innerWidth <= 899;
        
        if (isMobile && !accordionInitialized) {
            initAccordion();
        } else if (!isMobile && accordionInitialized) {
            destroyAccordion();
        }
    }

    // Initial check
    handleResize();

    // Listen to resize events
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(handleResize, 250);
    });
});
