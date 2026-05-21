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
    var $filterRadios = $('.category-list input[type="radio"]');
    var $productGrid = $('.filter-content');
    var $paginationContainer = $('.pagination');
    var $resetButton = $('.filter-reset-js');

    // Флаг для блокировки запросов
    var isFiltering = false;

    // Инициализация
    function init() {
        bindEvents();
    }

    // Навешивание событий
    function bindEvents() {
        // Изменение радио-кнопок
        $filterRadios.on('change', function() {
            if (!isFiltering) {
                scrollToFilter();
                filterProducts();
            }
        });

        // Кнопка сброса
        $resetButton.on('click', function() {
            if (!isFiltering) {
                resetFilters();
            }
        });

        // Пагинация (делегирование, т.к. пагинация может обновляться)
        $(document).on('click', '#products .pagination a', function(e) {
            if (!isFiltering) {
                e.preventDefault();
                scrollToFilter();
                var href = $(this).attr('href');
                var paged = extractPagedFromUrl(href);
                filterProducts(paged);
            }
        });
    }

    // Прокрутка к фильтрам
    function scrollToFilter() {
        var top = $('#products').offset().top - 100;
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
        $('.atribut-unit').each(function() {
            var $group = $(this);
            var attributeSlug = $group.find('input[type="radio"]').first().data('attribute');
            var selectedValue = $group.find('input[type="radio"]:checked').val();
            if (selectedValue && selectedValue !== '') {
                attributes[attributeSlug] = selectedValue;
            }
        });
        return attributes;
    }

    // Функции для работы с контентом
    function hideContent() {
        $productGrid.hide();
        $paginationContainer.hide();
    }

    function showContent() {
        $productGrid.show();
        $paginationContainer.show();
    }

    function showContentWithFade() {
        $productGrid.fadeIn(400);
        $paginationContainer.fadeIn(400);
    }

    // Функции для блокировки элементов
    function disableRadios() {
        $filterRadios.prop('disabled', true);
        $resetButton.prop('disabled', true);
    }

    function enableRadios() {
        $filterRadios.prop('disabled', false);
        $resetButton.prop('disabled', false);
    }

    // AJAX-запрос на фильтрацию
    function filterProducts(paged) {
        if (isFiltering) return;
        
        paged = paged || 1;
        var attributes = getSelectedAttributes();

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

            beforeSend: function() {
                isFiltering = true;
                disableRadios();
                hideContent();
            },
            
            complete: function() {
                isFiltering = false;
                enableRadios();
            },
            
            success: function(response) {
                if (response.success) {
                    updateProducts(response.data.html, response.data.pagination);
                    showContentWithFade();
                } else {
                    console.error('Ошибка фильтрации:', response.data);
                    showContent();
                }
            },
            
            error: function(xhr, status, error) {
                console.error('AJAX ошибка:', error);
                showContent();
            },
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

    // Запуск при готовности DOM
    $(document).ready(function() {
        if ($filterRadios.length && $productGrid.length) {
            init();
        }
    });

})(jQuery);