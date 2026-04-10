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
    function preloader() {
        $(()=>{

            setTimeout( () => {
                let p = $('#preloader');
                p.addClass('hide');

                setTimeout( () => {
                    p.remove()
                },1000);

            },1000);
        });
    }
    preloader();
    // setTimeout( ()=> preloader(),15000 )
}

$(document).ready(function() {
    console.log('ready');
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
            console.log('isLgWidth');
        } else {
            console.log('isLgWidth else');
        }
        // или создаем функцию
        // test();
    }

    function test() {
        if (isLgWidth()) {
            console.log('isLgWidth');
        } else {
            console.log('isLgWidth else');
        }
    }

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


    function showMore(classItem, btn, start = 1, show = 1) {
        let item = $(''+ classItem +'');
        let count = item.length;

        item.addClass('d-none');
        $('' + classItem + ':lt(' + start + ')').removeClass('d-none');

        if (start >= count) {
            $(`${btn}`).parent().remove();
        }

        $(btn).click(function(e) {
            e.preventDefault();
            $(this).addClass('loading');

            let load = $(this).data('load');
            let more = $(this).data('more');

            start = (start + show <= count) ? start + show : count;

            $(this).text(load);

            setTimeout(() => {
                $(''+ classItem +':lt(' + start + ')').removeClass('d-none');
                if ($(''+ classItem +':not(.d-none)').length == count) {
                    $(this).parent().remove();
                }
                $(this).removeClass('loading');
                $(this).text(more);
            }, 500);
        });
    }
    // showMore('.vacancies__item', '.show_more_v_js');

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

    // https://www.demo2s.com/javascript/jquery-not-this.html
    // .collapse
    //     .collapse__title
    //     .collapse__body
    function collapsedActiveOne() {
        $('.collapse__title').on('click', function() {
            let body = $(this).parent().find('.collapse__body');
            $('.collapse__body').not(body).slideUp();
            $(body).slideToggle();

            let toggle = $(this).parent().find('.collapse__title');
            $('.collapse__title').not(toggle).removeClass('open');
            $(toggle).toggleClass('open');
        })
    }
    // collapsedActiveOne();

    function doTabs () {
        $('.tabs__wrapper').each(function() {
            let ths = $(this);
            ths.find('.tab__item').not(':first').hide();
            ths.find('.tab').click(function() {
                ths.find('.tab').removeClass('active').eq($(this).index()).addClass('active');
                ths.find('.tab__item').hide().eq($(this).index()).fadeIn()
            }).eq(0).addClass('active');
        });
    }
    doTabs();

    // function doDrop() {
    //     $('.drop__toggle').on('click', function() {
    //         // $('.drop__list').toggleClass('open');
    //         $(this).toggleClass('active');
    //         $(this).closest('.drop').find('.drop__list').toggleClass('open');
    //     });
    // };
    // doDrop();

    // function initSelect2 () {
    //     function addIcon(icon) {
    //         if (!icon.id) {
    //             return icon.text;
    //         }
    //         let $icon = $(
    //             '<span><span></span><i></i></span>'
    //         );
    //         $icon.find("span").text(icon.text);
    //         $icon.find("i").attr("class", "icon_" + icon.element.value.toLowerCase());
    //         return $icon;
    //     }

    //     $('.select').select2({
    //         placeholder: $(this).data('placeholder'),
    //         minimumResultsForSearch: Infinity,
    //         // templateSelection: addIcon,
    //     });

    //     // $('.select').on('change',function() {
    //     //     let val = $(this).val();
    //     //     let form = $(this).closest('.form');
    //     //     let phone = form.find('.form__row_phone_js');
    //     //     let mail = form.find('.form__row_email_js');

    //     //     if ( val == 'mail'){
    //     //         mail.removeClass('form__row_hide');
    //     //         mail.find('input').prop('required',true);

    //     //         phone.addClass('form__row_hide');
    //     //         phone.find('input').prop('required',false);

    //     //     } else {
    //     //         mail.addClass('form__row_hide');
    //     //         mail.find('input').prop('required',false);

    //     //         phone.removeClass('form__row_hide');
    //     //         phone.find('input').prop('required',true);
    //     //     }
    //     // })
    // }
    // initSelect2();

    // $(function(){
    //     $(".tel").mask("+7 ( 9 9 9 ) - 9 9 9 - 9 9 - 9 9");
    // });

    // function initTwentytwenty () {
    //     $(".twentytwenty-container").twentytwenty({
    //         default_offset_pct: 0.42, // сколько показывать 'изображение до' в процентах (максимально 1) сразу после загрузки страницы
    //         orientation: 'horizontal', // ориентация слайдера ('horizontal' или 'vertical')
    //         before_label: 'До', // подпись 'до'
    //         after_label: 'После', // подпись 'после'
    //         no_overlay: true, // не показывать затемнение с надписями 'до' и 'после'
    //         move_slider_on_hover: false, // двигать "бегунок" слайдера вместе с курсором мыши
    //         move_with_handle_only: true, // двигать слайдер только за его "бегунок"
    //         click_to_move: false // разрешить перемещение "бегунка" слайдера по клику на изображении
    //     });
    // }
    // // initTwentytwenty(); добавить пример и стили



    function addDataFancybox() {
        let item = $('.itemForDataFancybox_js');
        let num = 0;
        item.each(function(index, el) {
            $(this).find('a').attr('data-fancybox', num);
            num++;
        });
    }
    addDataFancybox();

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



    function uploadYoutubeVideoForModal() {
        if ( $( ".youtubeModal_js" ) ) {

            $( '.youtubeModal_js' ).on( 'click', function () {
                $('#modalVideo').modal('show');

                let wrapp = $( this ).closest( '.youtubeModal_js' );
                let videoId = wrapp.attr( 'id' );
                let iframe_url = "https://www.youtube.com/embed/" + videoId + "?autoplay=1&autohide=1";

                // доп параметры для видоса
                // if ( $( this ).data( 'params' ) ) iframe_url += '&' + $( this ).data( 'params' );

                // Высота и ширина iframe должны быть такими же, как и у родительского блока
                let iframe = $( '<iframe/>', {
                    'frameborder': '0',
                    'src': iframe_url,
                    'allow': "autoplay"
                } )
                $(".modalVideo__wraper").append(iframe);

                $("#modalVideo").on('hide.bs.modal', function () {
                    $(".modalVideo__wraper").html('');
                });

            } );
        }
    };
    // uploadYoutubeVideoForModal();

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
            // $('.hamburger').removeClass('hamburger_open');
            // $('.header__nav').removeClass('header__nav_open');
            // $( 'body' ).removeClass( 'nav-open' );
        });
    };
    scroolTo();

    function hideNav() {
        $(".header__nav").on('mouseenter', function() {
            // console.log('mouse on');
        });

        $(".header__nav").on('mouseleave', function() {
            // $('.hamburger').removeClass('hamburger_open');
            // $('.header__nav').removeClass('header__nav_open');
            // $( 'body' ).removeClass( 'nav-open' );
        });
    }
    hideNav();


    // Scroll to ID
    function menuScroll(menuItem) {
        menuItem.find('a[href^="#"]').click(function () {
            var scroll_el = $(this).attr('href'),
                time = 500;
            if ($(scroll_el).length != 0) {
                $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, time);
                $(this).addClass('active');
            }
            return false;
        });
    }
    // menuScroll($('.js-scroll-to'));


    // --------------------------------------------------------------------
    // Деление чисел на разряды Например из строки 10000 получаем 10 000
    // Использование: thousandSeparator(1000) или используем переменную.
    // function thousandSeparator(str) {
    //     var parts = (str + '').split('.'),
    //         main = parts[0],
    //         len = main.length,
    //         output = '',
    //         i = len - 1;
    //
    //     while(i >= 0) {
    //         output = main.charAt(i) + output;
    //         if ((len - i) % 3 === 0 && i > 0) {
    //             output = ' ' + output;
    //         }
    //         --i;
    //     }
    //
    //     if (parts.length > 1) {
    //         output += '.' + parts[1];
    //     }
    //     return output;
    // };
    //
    // console.log(thousandSeparator(700));
    // --------------------------------------------------------------------

})

document.addEventListener('DOMContentLoaded', () => {
    
    // Функция для генерации HTML карточки товара (полностью соответствует PHP шаблону)
    function generateProductCard(product) {
        // Используем готовый HTML изображения из PHP
        let imageHTML = product.thumbnail_html || '';
        
        // Fallback если нет HTML изображения
        if (!imageHTML && product.thumbnail_medium) {
            imageHTML = `<img src="${product.thumbnail_medium}" alt="${product.title}" loading="lazy">`;
        } else if (!imageHTML) {
            imageHTML = `<img src="<?php echo $no_img_url; ?>" alt="${product.title}" loading="lazy">`;
        }
        
        // Используем готовую отформатированную цену из PHP
        const priceHTML = product.price_formatted || '';
        
        // Определяем, доступен ли товар для покупки
        const isDisabled = product.stock_status !== 'instock' ? 'disabled' : '';
        
        // Возвращаем HTML карточки (полностью соответствует PHP шаблону)
        return `
            <div class="product" id="product-${product.id}">
                <div class="product__header">
                    <a class="product__img img" href="${product.permalink}">
                        ${imageHTML}
                    </a>
                </div>
                <div class="product__body product_padding">
                    <a class="product__title" href="${product.permalink}">${product.title}</a>
                </div>
                <div class="product__footer product_padding">
                    <div class="product__price">${priceHTML}</div>
                    <div class="product__button">
                        <button class="btn" ${isDisabled}>
                            <span>Купить</span>
                            <i class="icon_basket"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Функция для генерации контента модального окна
    function setModalContent(categoryName, tagName, products, tagDescription = '') {
        let productsHTML = '';
        
        if (products && products.length > 0) {
            products.forEach(product => {
                productsHTML += generateProductCard(product);
            });
        } else {
            productsHTML = '<div class="no-products">В этой категории пока нет товаров</div>';
        }
        
        // Формируем заголовок в формате "category_name / tag_name"
        const titleText = categoryName ? `${categoryName} / ${tagName}` : tagName;
        
        return `
            <div class="modal-title" id="myModalLabel">${titleText}</div>
            <div class="product__grid scrolled">
                ${productsHTML}
            </div>
        `;
    }
    
    // Обработчик клика по .show_tag_products_js
    const tagTriggers = document.querySelectorAll('.show_tag_products_js');
    
    if (tagTriggers.length > 0) {
        tagTriggers.forEach((trigger) => {
            trigger.addEventListener('click', (e) => {
                // Получаем ID метки и категории
                let tagId = null;
                let categoryId = null;
                
                // Из data-атрибутов
                if (trigger.dataset.tagId) {
                    tagId = parseInt(trigger.dataset.tagId);
                }
                if (trigger.dataset.categoryId) {
                    categoryId = parseInt(trigger.dataset.categoryId);
                }
                
                console.log('tagId: ', tagId);
                console.log('categoryId: ', categoryId);
                
                // Проверяем наличие productsCombinations
                if (typeof productsCombinations === 'undefined') {
                    console.error('productsCombinations не определен');
                    return;
                }
                
                // Ищем комбинацию в данных
                let combo = null;
                if (tagId && categoryId) {
                    combo = productsCombinations.find(c => c.category_id === categoryId && c.tag_id === tagId);
                }
                
                // Если не нашли, ищем только по tagId
                // if (!combo && tagId) {
                //     combo = productsCombinations.find(c => c.tag_id === tagId);
                // }
                
                console.log('combo: ', combo);
                
                // Если нашли комбинацию, вставляем данные в модальное окно
                if (combo) {
                    const modal = document.querySelector('#tag-products');
                    const modalBody = modal ? modal.querySelector('.modal-body') : null;
                    
                    if (modalBody) {
                        // Обновляем содержимое модального окна
                        modalBody.innerHTML = setModalContent(
                            combo.category_name,
                            combo.tag_name,
                            combo.products,
                            combo.tag_description
                        );
                        
                        $(modal).modal('show');
                      
                    } else {
                        console.error('Модальное окно #tag-products или его .modal-body не найдены');
                    }
                } else {
                    console.error('Не найдены товары для этой комбинации', { tagId, categoryId });
                }
            });
        });
    } else {
        console.log('Элементы .show_tag_products_js не найдены');
    }
});
