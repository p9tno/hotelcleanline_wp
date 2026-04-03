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
    
    // 2. Media Swiper
    let speed = 3000;
    let delay = 8000;
    
    const mediaContainer = document.querySelector('.media');
    if (mediaContainer) {
        initSwiper('.media_swiper_js', {
            slidesPerView: 1,
            spaceBetween: 20,
            speed: speed,
            loop: false,
            autoplay: {
                delay: delay,
            },
            navigation: {
                nextEl: safeGetElement('.icon_arrow_right_sm', mediaContainer),
                prevEl: '.icon_arrow_left_sm',
            },
            pagination: {
                el: safeGetElement('.swiper-pagination', mediaContainer),
                clickable: true,
            },
            breakpoints: {
                768: {
                    spaceBetween: 24,
                    slidesPerView: 2,
                    simulateTouch: false,
                },
            }
        });
    } else {
        console.warn('Media container not found');
    }
    
    // 3. Partners Swiper
    const partnersContainer = document.querySelector('.partners');
    if (partnersContainer) {
        initSwiper('.partners_swiper_js', {
            slidesPerView: 1,
            spaceBetween: 6,
            speed: speed,
            loop: false,
            autoplay: {
                delay: delay,
            },
            navigation: {
                nextEl: safeGetElement('.icon_arrow_right_sm', partnersContainer),
                prevEl: safeGetElement('.icon_arrow_left_sm', partnersContainer),
            },
            pagination: {
                el: safeGetElement('.swiper-pagination', partnersContainer),
                clickable: true,
            },
            breakpoints: {
                768: {
                    spaceBetween: 40,
                    slidesPerView: 2,
                    simulateTouch: false,
                },
            }
        });
    } else {
        console.warn('Partners container not found');
    }
    
    // 4. Banner Swiper
    const bannerContainer = document.querySelector('.banner');
    if (bannerContainer) {
        initSwiper('.banner_swiper_js', {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: speed,
            loop: false,
            autoplay: {
                delay: delay,
            },
            effect: "creative",
            creativeEffect: {
                prev: {
                    shadow: true,
                    translate: [0, 0, -400],
                },
                next: {
                    translate: ["100%", 0, 0],
                },
            },
            navigation: {
                nextEl: safeGetElement('.icon_arrow_right_sm', bannerContainer),
                prevEl: safeGetElement('.icon_arrow_left_sm', bannerContainer),
            },
            pagination: {
                el: safeGetElement('.swiper-pagination', bannerContainer),
                clickable: true,
            },
            breakpoints: {
                768: {
                    simulateTouch: false,
                },
            }
        });
    } else {
        console.warn('Banner container not found');
    }
    
    // 5. Hscroll Swiper (без родительского контейнера)
    const hscrollContainer = document.querySelector('.hscroll_swiper_js');
    if (hscrollContainer) {
        initSwiper('.hscroll_swiper_js', {
            slidesPerView: 1,
            spaceBetween: 6,
            speed: 40000,
            loop: true,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
                waitForTransition: false,
            },
            allowTouchMove: false,
            simulateTouch: false,
            watchSlidesProgress: true,
            updateOnWindowResize: true,
            observer: true,
            observeParents: true,
            breakpoints: {
                768: {
                    spaceBetween: 16,
                    slidesPerView: 1,
                },
            },
            on: {
                init: function() {
                    console.log('Hscroll Swiper initialized');
                    this.autoplay.start();
                },
                transitionEnd: function() {
                    // Перезапускаем автоплей после завершения перехода
                    this.autoplay.stop();
                    this.autoplay.start();
                },
            }
        });
    } else {
        console.warn('Hscroll Swiper container not found');
    }
    
});