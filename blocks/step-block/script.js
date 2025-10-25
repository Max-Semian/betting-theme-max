/**
 * Step Block Scroll Animation
 */

document.addEventListener('DOMContentLoaded', function() {
    const stepBlocks = document.querySelectorAll('.step-block__steps');
    
    if (stepBlocks.length === 0) return;

    function updateStepProgress() {
        stepBlocks.forEach(function(stepsContainer) {
            const items = stepsContainer.querySelectorAll('.step-block__item');
            if (items.length === 0) return;

            const containerRect = stepsContainer.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            let activeIndex = -1;
            let progress = 0;

            // Определяем какой шаг активен
            items.forEach(function(item, index) {
                const itemRect = item.getBoundingClientRect();
                const itemCenter = itemRect.top + itemRect.height / 2;
                
                // Шаг считается активным если его центр выше середины экрана
                if (itemCenter <= windowHeight / 2) {
                    activeIndex = index;
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            // Вычисляем прогресс заполнения линии
            if (activeIndex >= 0 && items.length > 1) {
                const firstItem = items[0];
                const lastItem = items[items.length - 1];
                const currentItem = items[activeIndex];
                
                const firstItemRect = firstItem.getBoundingClientRect();
                const lastItemRect = lastItem.getBoundingClientRect();
                const currentItemRect = currentItem.getBoundingClientRect();
                
                // Высота от первого до последнего элемента
                const totalHeight = lastItemRect.top - firstItemRect.top;
                
                // Текущая позиция относительно первого элемента
                const currentHeight = currentItemRect.top - firstItemRect.top;
                
                // Плюс половина высоты текущего элемента для более плавной анимации
                const itemHalfHeight = currentItemRect.height / 2;
                const adjustedHeight = currentHeight + itemHalfHeight;
                
                // Процент заполнения (от 0 до 100%)
                progress = Math.min(100, Math.max(0, (adjustedHeight / totalHeight) * 100));
                
                // Если это последний шаг и он активен, заполняем линию полностью
                if (activeIndex === items.length - 1) {
                    progress = 100;
                }
            }

            // Применяем высоту к псевдоэлементу через CSS переменную
            stepsContainer.style.setProperty('--progress', progress + '%');
            
            // Также можем использовать inline style для ::after через родительский элемент
            const afterElement = stepsContainer.querySelector('::after') || stepsContainer;
            // Поскольку нельзя напрямую управлять ::after, используем CSS переменную
        });
    }

    // Обновляем CSS для поддержки переменной
    const style = document.createElement('style');
    style.textContent = `
        .step-block__steps::after {
            height: var(--progress, 0) !important;
        }
    `;
    document.head.appendChild(style);

    // Инициализация
    updateStepProgress();

    // Обновляем при прокрутке
    let scrollTimer;
    window.addEventListener('scroll', function() {
        if (scrollTimer) {
            window.cancelAnimationFrame(scrollTimer);
        }
        scrollTimer = window.requestAnimationFrame(updateStepProgress);
    });

    // Обновляем при изменении размера окна
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(updateStepProgress, 250);
    });
});
