var app = {
    pageScroll: '',
    lgWidth: 1200,
    mdWidth: 992,
    smWidth: 768,
    resized: false,
    iOS: function () {
        return navigator.userAgent.match( /iPhone|iPad|iPod/i );
    },
    touchDevice: function () {
        return navigator.userAgent.match( /iPhone|iPad|iPod|Android|BlackBerry|Opera Mini|IEMobile/i );
    }
};

function isLgWidth() {
    return $( window ).width() >= app.lgWidth;
} // >= 1200
function isMdWidth() {
    return $( window ).width() >= app.mdWidth && $( window ).width() < app.lgWidth;
} //  >= 992 && < 1200
function isSmWidth() {
    return $( window ).width() >= app.smWidth && $( window ).width() < app.mdWidth;
} // >= 768 && < 992
function isXsWidth() {
    return $( window ).width() < app.smWidth;
} // < 768
function isIOS() {
    return app.iOS();
} // for iPhone iPad iPod
function isTouch() {
    return app.touchDevice();
} // for touch device

console.log('pathname: ', window.location.pathname);
console.log('url: ', window.location.href);
console.log('origin: ', window.location.origin);

window.onload = function () {
    console.log('onload');

    // new Toast({
    //     text: `danger`,
    //     autohide: true,
    //     theme: 'danger', // danger success primary
    //     autohide: false
    // });
    // new Toast({
    //     text: `success`,
    //     autohide: true,
    //     theme: 'success', // danger success primary
    //     autohide: false
    // });
    // new Toast({
    //     text: `primary`,
    //     autohide: true,
    //     theme: 'primary', // danger success primary
    //     autohide: false
    // });

    function preloader() {
        $(()=>{

            setTimeout( () => {
                let p = $('#preloader');
                p.addClass('hide');

                setTimeout( () => {
                    p.remove()
                },300);

            },600);
        });
    }
    preloader();
    // setTimeout( ()=> preloader(),15000 )
}

$(document).ready(function() {
    // console.log('ready');

    window.addEventListener('resize', () => {
        // Запрещаем выполнение скриптов при смене только высоты вьюпорта (фикс для скролла в IOS и Android >=v.5)
        if (app.resized == screen.width) { return; }
        app.resized = screen.width;
        // console.log('resize');
        // console.log(screen.width);
        checkOnResize();
    });

    function checkOnResize() {
        if (isLgWidth()) {
            // console.log('isLgWidth');
        } else {
            // console.log('isLgWidth else');
        }
    }

    function backHistory() {
        $("#back-btn").click(function (e) {
            e.preventDefault();
            window.history.back();
        });
    }
    backHistory();

    function scrollPage () {
        $(".toTop").on("click","a", function (event) {
            event.preventDefault();
            let id  = $(this).attr('href');
            let top = $(id).offset().top;
            $('body,html').animate({scrollTop: top}, 1500);
        });

        $(window).scroll(function(){
            if($(window).scrollTop()>500){
                $('.toTop').fadeIn(900)
            }else{
                $('.toTop').fadeOut(700)
            }
        });
    }
    scrollPage();

    function showModal() {
        $('.show_modal_js').on('click', function (e) {
            e.preventDefault();
            let id  = $(this).attr('href');
            console.log(id);
            $(id).modal('show');
        });

        const modalTagProducts = $('#tag-products');
        $(modalTagProducts).on('hide.bs.modal', () => {
            modalTagProducts.find('.modal-body').html('');
        });

    }
    showModal();


    function openMobileNav() {
        $('.header__toggle').click(function(event) {
            // console.log('Показ меню');
            $('.navbar').toggleClass('navbar_open');
            $('.header__toggle').toggleClass('header__toggle_open');
            $( 'body' ).toggleClass( 'nav-open' );
        });
    };
    openMobileNav();

    // для фильтрации
    function collapsed() {
        let toggle = $('[data-collapse]');

        toggle.on('click', function() {
            let id = $(this).data('collapse'),
            body = $('[data-collapse-body="'+id+'"]'),
            wrap = body.closest('[data-collapse-wrapper]');

            if (!id) {
                // $('[data-collapse-wrapper]').removeClass('open');
                body = $(this).parent().find('[data-collapse-body]');
                $(this).toggleClass('open');
                if ($(this).hasClass('open')) {
                    body.slideDown();
                } else {
                    body.slideUp();
                }
            } else if (id === 'all') {
                body.slideDown();
                toggle.addClass('open');
            } else {
                body.slideToggle();
                $(this).toggleClass('open');
            }
        });
    }
    collapsed();

    function doTabs () {
        $('.init-tabs').each(function() {
            let ths = $(this);
            ths.find('.tab__item').not(':first').hide();
            ths.find('.tab').click(function() {
                ths.find('.tab').removeClass('active').eq($(this).index()).addClass('active');
                ths.find('.tab__item').hide().eq($(this).index()).fadeIn()
            }).eq(0).addClass('active');
        });
    }
    doTabs();

    function stikyMenu() {
        let firstSection = $('main section:first');
        let header = $('header');
        let currentTop = $(window).scrollTop();

        // Проверяем, есть ли секции в main
        if ($('main section').length === 0) {
            console.warn('Секции не найдены внутри main');
            return;
        }

        setNavbarPosition();

        $(window).scroll(function () {
            setNavbarPosition();
        });

        function setNavbarPosition() {
            currentTop = $(window).scrollTop();

            if (firstSection.length > 0) {
                let firstSectionBottom = firstSection.offset().top + firstSection.outerHeight();
                
                // Добавляем небольшой отступ для плавности (опционально)
                let threshold = firstSectionBottom - 10;
                
                if (currentTop > threshold) {
                    header.addClass('stiky');
                } else {
                    header.removeClass('stiky');
                }
            }
        }
    }
    stikyMenu();

    function initAOS() {
        // Добавляем анимацию к заголовкам
        // document.querySelectorAll('.section__title').forEach(title => {
        //     title.setAttribute('data-aos', 'fade-up');
        //     // Можно добавить дополнительные атрибуты для тонкой настройки
        //     title.setAttribute('data-aos-duration', '1200');
        //     title.setAttribute('data-aos-delay', '200');
        //     title.setAttribute('data-aos-easing', 'ease-out-cubic');
        // });

        // Настройки для разных типов элементов
        const animations = {
            '.section__title': {
                animation: 'fade-up',
                // duration: 1200,
                // delay: 200,
                // offset: 40
            },
            // '.section__subtitle': {
            //     animation: 'fade-up',
            //     duration: 1000,
            //     delay: 300
            // },
            // '.card': {
            //     animation: 'fade-in',
            //     duration: 800,
            //     delay: 100
            // }
        };
        
        // Применяем анимации ко всем элементам
        Object.entries(animations).forEach(([selector, config]) => {
            document.querySelectorAll(selector).forEach(element => {
                if (config.animation) {
                    element.setAttribute('data-aos', config.animation);
                }
                if (config.duration) {
                    element.setAttribute('data-aos-duration', config.duration);
                }
                if (config.delay) {
                    element.setAttribute('data-aos-delay', config.delay);
                }
                if (config.offset) {
                    element.setAttribute('data-aos-offset', config.offset);
                }
            });
        });
        
        // Единая инициализация AOS
        AOS.init({
            disable: function() {
                return window.innerWidth < 768;
            },
            offset: 40,
            delay: 0,
            duration: 1200,
            easing: 'ease-out-cubic',
            once: true,
            mirror: false,
            throttleDelay: 99,
            debounceDelay: 50,
            anchorPlacement: 'top-bottom'
        });
    }

    initAOS();


    // <a class="scroll_js" href="#id"></a>
    function scroolTo() {
        $(".scroll_js").on("click", function (event) {
            event.preventDefault();
            let id  = $(this).attr('href');
            console.log(id);

            let top = $(id).offset().top;
            $('body,html').animate({scrollTop: top}, 1500);
        });
    };
    scroolTo();

    function initSectionNavigation() {
        let isHomepage = window.location.pathname === '/';
        let homepageUrl = window.location.origin + '/';
        
        $('.menu-scroll a').on('click', function(e) {
            e.preventDefault();
            
            let href = $(this).attr('href');
            let hashPart = href.split('#')[1];
            
            if (hashPart) {
                if (isHomepage) {
                    $('.navbar').removeClass('navbar_open');
                    $('.header__toggle').removeClass('header__toggle_open');
                    $( 'body' ).removeClass( 'nav-open' );
                    smoothScroll('#' + hashPart);
                } else {
                    window.location.href = homepageUrl + '?section=' + hashPart;
                }
            }
        });
        
        let sectionParam = new URLSearchParams(window.location.search).get('section');
        if (sectionParam) {
            let target = '#' + sectionParam;
            console.log(target);
            
            if ($(target).length) {
         
                smoothScroll(target);
                
            } else {
                $(window).on('load', function() {
                    smoothScroll(target);
                });
            }
            
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.pathname);
            }
        }
        
        function smoothScroll(target) {
            let $target = $(target);
            
            if ($target.length) {
                let headerHeight = $('header').outerHeight() || 0;
                let targetPosition = $target.offset().top - headerHeight - 30;
                
                $('html, body').animate({
                    scrollTop: targetPosition
                }, 1500);
            }
        }
    }

    initSectionNavigation();
})

