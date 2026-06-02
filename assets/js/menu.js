jQuery(document).ready(function($) {
    // Мобильное меню
    function initMobileMenu() {
        // Добавляем кнопки переключения если их нет
        $('.menu-item-has-children').each(function() {
            const $this = $(this);
            const $link = $this.children('a');
            
            if (!$link.next('.menu-toggle').length) {
                $link.after('<button class="menu-toggle">+</button>');
            }
        });
        
        // Обработчик клика по кнопке
        $(document).off('click', '.menu-toggle').on('click', '.menu-toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $this = $(this);
            const $parentItem = $this.closest('.menu-item-has-children');
            const $subMenu = $parentItem.find('.sub-menu').first();
            
            // Закрываем другие подменю на том же уровне
            $parentItem.siblings().find('.sub-menu').slideUp(300).removeClass('menu-open');
            $parentItem.siblings().find('.menu-toggle').text('+');
            
            // Переключаем текущее подменю
            $subMenu.slideToggle(300).toggleClass('menu-open');
            $this.text($this.text() === '+' ? '-' : '+');
        });
        
        // Закрытие подменю при клике вне меню
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.menu').length) {
                $('.sub-menu').slideUp(300).removeClass('menu-open');
                $('.menu-toggle').text('+');
            }
        });
    }
    
    // Десктопное меню - сбрасываем мобильные стили
    function resetMobileMenu() {
        $('.menu-toggle').remove();
        $('.sub-menu')
            .removeClass('menu-open')
            .css('display', '');
    }
    
    // Проверка при загрузке
    if ($(window).width() < 768) {
        initMobileMenu();
    }
    
    // Проверка при изменении размера
    $(window).on('resize', function() {
        if ($(window).width() < 768) {
            initMobileMenu();
        } else {
            resetMobileMenu();
        }
    });
    
    
});