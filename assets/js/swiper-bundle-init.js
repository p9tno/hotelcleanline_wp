$(document).ready(function() {

    const firstscreenContainer = document.querySelector('.firstscreen');
    const firstscreen = new Swiper('.firstscreen_swiper_js', {
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
            nextEl: firstscreenContainer.querySelector('.icon_arrow_right_sm'),
            prevEl: firstscreenContainer.querySelector('.icon_arrow_left_sm'),
        },
        pagination: {
            el: firstscreenContainer.querySelector('.swiper-pagination'),
            clickable: true,
        },
    });

    let speed = 3000;
    let delay = 8000;

    const mediaContainer = document.querySelector('.media');
    const media = new Swiper('.media_swiper_js', {
        slidesPerView: 1,
        spaceBetween: 20,
        speed: speed,
        loop: false,
        autoplay: {
            delay: delay,
        },
        
        navigation: {
            nextEl: mediaContainer.querySelector('.icon_arrow_right_sm'),
            prevEl: '.icon_arrow_left_sm',
        },
        pagination: {
            el: mediaContainer.querySelector('.swiper-pagination'),
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

    const partnersContainer = document.querySelector('.partners');
    const partners = new Swiper('.partners_swiper_js', {
        slidesPerView: 2,
        spaceBetween: 6,
        speed: speed,
        loop: false,
        autoplay: {
            delay: delay,
        },
        
        navigation: {
            nextEl: partnersContainer.querySelector('.icon_arrow_right_sm'),
            prevEl: partnersContainer.querySelector('.icon_arrow_left_sm'),
        },

        pagination: {
            el: partnersContainer.querySelector('.swiper-pagination'),
            clickable: true,
        },
        
        breakpoints: {
            768: {
                spaceBetween: 40,
                slidesPerView: 4,
                simulateTouch: false,
            },

        }
    });

    const bannerContainer = document.querySelector('.banner');
    const banner = new Swiper('.banner_swiper_js', {
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
            nextEl: bannerContainer.querySelector('.icon_arrow_right_sm'),
            prevEl: bannerContainer.querySelector('.icon_arrow_left_sm'),
        },

        pagination: {
            el: bannerContainer.querySelector('.swiper-pagination'),
            clickable: true,
        },
        
        breakpoints: {
            768: {
                simulateTouch: false,
            },

        }
    });

    const hscroll = new Swiper('.hscroll_swiper_js', {
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
                // console.log('Swiper initialized');
                this.autoplay.start();
            },
            transitionStart: function() {
                // console.log('Transition STARTED');
            },
            transitionEnd: function() {
                // console.log('Transition ENDED - restarting autoplay');
                // КРИТИЧЕСКИ ВАЖНО: принудительно перезапускаем
                this.autoplay.stop();
                this.autoplay.start();
            },
            // autoplayStop: function() {
            //     console.log('Autoplay STOPPED - restarting');
            //     setTimeout(() => {
            //         this.autoplay.start();
            //     }, 100);
            // }
        }
    });
});
