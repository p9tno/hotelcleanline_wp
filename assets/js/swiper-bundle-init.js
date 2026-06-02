$(document).ready(function() {
    
    // Функция для безопасного получения элемента
    function safeGetElement(selector, context = document) {
        if (!context) return null;
        return context.querySelector(selector);
    }
    
    // Функция для безопасной инициализации Swiper
    function initSwiper(containerSelector, config) {
        const container = document.querySelector(containerSelector);
        if (!container) {
            console.warn(`Swiper container "${containerSelector}" not found on the page`);
            return null;
        }
        
        try {
            return new Swiper(containerSelector, config);
        } catch (error) {
            console.error(`Error initializing Swiper "${containerSelector}":`, error);
            return null;
        }
    }
    
    // 1. Firstscreen Swiper
    const firstscreenContainer = document.querySelector('.firstscreen');
    if (firstscreenContainer) {
        initSwiper('.firstscreen_swiper_js', {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 1500,
            loop: true,
            effect: "fade",
            fadeEffect: {
                crossFade: true,
            },
            autoplay: {
                delay: 6000,
            },
            simulateTouch: false,
            navigation: {
                nextEl: safeGetElement('.icon_arrow_right_sm', firstscreenContainer),
                prevEl: safeGetElement('.icon_arrow_left_sm', firstscreenContainer),
            },
            pagination: {
                el: safeGetElement('.swiper-pagination', firstscreenContainer),
                clickable: true,
            },
        });
    } else {
        console.warn('Firstscreen container not found');
    }
        
});