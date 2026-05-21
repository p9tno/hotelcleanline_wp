/**
 * Фильтрация товаров по атрибутам (AJAX)
 */

(function($) {
    'use strict';

    // Конфигурация
    var config = {
        ajaxUrl: filter_ajax.ajax_url,
        nonce: filter_ajax.nonce,
        categoryId: filter_ajax.category_id,
        categorySlug: filter_ajax.category_slug,
    };

    // Элементы DOM
    var $filterRadios = $('.category__list input[type="radio"]');
    var $productGrid = $('.filter__content');
    var $paginationContainer = $('.pagination');
    var $resetButton = $('.filter-reset-js');
    var $preloader = $('.preloaderFilter-js');

    // Инициализация
    function init() {
        bindEvents();
    }

    // Навешивание событий
    function bindEvents() {
        // Изменение радио-кнопок
        $filterRadios.on('change', function() {
            scrollToFilter();
            filterProducts();
        });

        // Кнопка сброса
        $resetButton.on('click', function() {
            resetFilters();
        });

        // Пагинация (делегирование, т.к. пагинация может обновляться)
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            scrollToFilter();
            var href = $(this).attr('href');
            var paged = extractPagedFromUrl(href);
            filterProducts(paged);
        });
    }

    // Прокрутка к фильтрам
    function scrollToFilter() {
        var top = $('#filters').offset().top - 100;
        $('body, html').animate({scrollTop: top}, 700);
    }

    // Извлечение номера страницы из URL
    function extractPagedFromUrl(url) {
        var paged = 1;
        if (url.indexOf('paged=') !== -1) {
            paged = url.split('paged=')[1];
        } else if (url.indexOf('/page/') !== -1) {
            paged = url.split('/page/')[1];
        }
        return parseInt(paged) || 1;
    }

    // Сбор выбранных атрибутов
    function getSelectedAttributes() {
        var attributes = {};
        $('.category__unit').each(function() {
            var $group = $(this);
            var attributeSlug = $group.find('input[type="radio"]').first().data('attribute');
            var selectedValue = $group.find('input[type="radio"]:checked').val();
            if (selectedValue && selectedValue !== '') {
                attributes[attributeSlug] = selectedValue;
            }
        });
        return attributes;
    }

    // AJAX-запрос на фильтрацию
    function filterProducts(paged) {
        paged = paged || 1;
        var attributes = getSelectedAttributes();

        showPreloader();

        $.ajax({
            type: 'POST',
            url: config.ajaxUrl,
            data: {
                action: 'filter_products',
                nonce: config.nonce,
                category_id: config.categoryId,
                attributes: attributes,
                paged: paged,
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateProducts(response.data.html, response.data.pagination);
                } else {
                    console.error('Ошибка фильтрации:', response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX ошибка:', error);
            },
            complete: function() {
                hidePreloader();
            }
        });
    }

    // Сброс фильтров
    function resetFilters() {
        $filterRadios.each(function() {
            if ($(this).val() === '') {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
        filterProducts(1);
    }

    // Обновление сетки товаров и пагинации
    function updateProducts(html, paginationHtml) {
        if ($productGrid.length) {
            $productGrid.html(html);
        }
        if ($paginationContainer.length) {
            if (paginationHtml) {
                $paginationContainer.html(paginationHtml);
            } else {
                $paginationContainer.empty();
            }
        }
    }

    // Показать прелоадер
    function showPreloader() {
        if (!$preloader.length) {
            // Создаём прелоадер, если его нет
            $preloader = $('<div class="preloaderFilter-js"></div>');
            $productGrid.before($preloader);
        }
        $preloader.addClass('active');
    }

    // Скрыть прелоадер
    function hidePreloader() {
        setTimeout(function() {
            $preloader.removeClass('active');
        }, 300);
    }

    // Запуск при готовности DOM
    $(document).ready(function() {
        if ($filterRadios.length && $productGrid.length) {
            init();
        }
    });

})(jQuery);