// cart.js
(function($) {
    'use strict';
    
    // Функция показа уведомления через ваш Toast
    function showToast(message, theme = 'success', autohide = true, interval = 4000) {
        if (typeof Toast !== 'undefined') {
            new Toast({
                text: message,
                theme: theme,
                autohide: autohide,
                interval: interval
            });
        } else {
            console.log('Toast:', message);
        }
    }

    // Функция добавления в корзину (обновленная)
    window.addToCart = function(productId, quantity = 1000, buttonElement = null) {
        if (buttonElement) {
            var $btn = $(buttonElement);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<span>Добавление...</span>');
        }
        
        $.ajax({
            url: cart_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'add_to_cart',
                product_id: productId,
                quantity: quantity,
                nonce: cart_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    showToast(response.data.message, 'success', true, 3000);
                    updateCartBadge(response.data.total_items);
                    
                    if (buttonElement) {
                        $btn.html('<span>✓ Добавлено</span>');
                        setTimeout(function() {
                            $btn.prop('disabled', false).html(originalText);
                        }, 1500);
                    }
                    
                    showGoToCartButton();
                } else {
                    showToast(response.data || 'Ошибка при добавлении товара', 'danger', true, 4000);
                    if (buttonElement) {
                        $btn.prop('disabled', false).html(originalText);
                    }
                }
            },
            error: function() {
                showToast('Ошибка сервера. Попробуйте позже.', 'danger', true, 4000);
                if (buttonElement) {
                    $btn.prop('disabled', false).html(originalText);
                }
            }
        });
    };

    // Обновите обработчик клика для кнопок
    $(document).on('click', '.btn-add-to-cart', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var productId = $btn.data('product-id');
        var quantity = $btn.data('quantity') || 1000; // берем количество из data-атрибута
        
        if (productId) {
            window.addToCart(productId, quantity, this);
        } else {
            showToast('Ошибка: ID товара не найден', 'danger', true, 3000);
        }
    });
    

    
    // Плавающая кнопка "Перейти в корзину"
    function showGoToCartButton() {
        $('.floating-cart-button').remove();
        
        var $button = $('<div class="floating-cart-button">Перейти в корзину →</div>');
        $('body').append($button);
        
        setTimeout(function() {
            $button.addClass('show');
        }, 100);
        
        $button.on('click', function() {
            window.location.href = cart_ajax.cart_url;
        });
        
        setTimeout(function() {
            $button.removeClass('show');
            setTimeout(function() {
                $button.remove();
            }, 300);
        }, 5000);
    }
    
    // Обновление бейджа корзины (количество уникальных товаров)
    window.updateCartBadge = function(count) {
        // count - это количество уникальных товаров (позиций)
        
        if ($('.cart-count-badge').length) {
            $('.cart-count-badge').text(count);
            
            if (count === 0 || count === '0') {
                $('.cart-count-badge').hide();
            } else {
                $('.cart-count-badge').show();
            }
        }
        
        $('.cart-badge, .cart-count, .header-cart-count').text(count);
        if (count === 0 || count === '0') {
            $('.cart-badge, .cart-count, .header-cart-count').hide();
        } else {
            $('.cart-badge, .cart-count, .header-cart-count').show();
        }
        
        $('.cart-icon').attr('data-count', count);
    };
    

    
    // Функции для страницы корзины
    $(document).ready(function() {

        // Очистка корзины (только здесь оставляем confirm)
        $('#clear-cart').on('click', function() {
            if (confirm('Вы уверены, что хотите очистить корзину?')) {
                $.ajax({
                    url: cart_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'clear_cart',
                        nonce: cart_ajax.nonce
                    },
                    beforeSend: function() {
                        $('#clear-cart').prop('disabled', true).text('Очистка...');
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.data.message, 'success', true, 2000);
                            updateCartBadge(0);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            showToast('Ошибка очистки', 'danger', true, 3000);
                        }
                    },
                    error: function() {
                        showToast('Ошибка сервера', 'danger', true, 3000);
                    },
                    complete: function() {
                        $('#clear-cart').prop('disabled', false).text('Очистить корзину');
                    }
                });
            }
        });
        
        // Удаление одного товара (без подтверждения)
        $(document).on('click', '.remove-item', function() {
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var $row = $btn.closest('tr');
            
            $.ajax({
                url: cart_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'remove_from_cart',
                    product_id: productId,
                    nonce: cart_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showToast('Товар удален', 'success', true, 2000);
                        // Обновляем бейдж с правильным количеством
                        if (response.data.total_items !== undefined) {
                            updateCartBadge(response.data.total_items);
                        }
                        $row.fadeOut(300, function() {
                            if ($('.cart-table tbody tr').length === 1) {
                                location.reload();
                            } else {
                                updateTotalSum();
                            }
                            $(this).remove();
                        });
                    } else {
                        showToast('Ошибка удаления', 'danger', true, 3000);
                    }
                },
                error: function() {
                    showToast('Ошибка сервера', 'danger', true, 3000);
                }
            });
        });
        
        // Функция обновления общей суммы
        function updateTotalSum() {
            var total = 0;
            $('.cart-subtotal').each(function() {
                var subtotalText = $(this).text();
                var subtotal = parseFloat(subtotalText.replace(/[^0-9.-]+/g, ''));
                if (!isNaN(subtotal)) {
                    total += subtotal;
                }
            });
            $('#cart-total').text(formatPrice(total));
        }
        
        // Функция форматирования цены
        function formatPrice(price) {
            return Math.round(price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' ₽';
        }
        
        // Автоматический пересчет суммы при изменении количества
        $(document).on('change', '.cart-quantity input', function() {
            var $input = $(this);
            var quantity = parseInt($input.val());
            var $row = $input.closest('tr');
            var priceText = $row.find('.cart-price').text();
            var price = parseFloat(priceText.replace(/[^0-9.-]+/g, ''));
            
            if (!isNaN(price) && !isNaN(quantity) && quantity >= 1) {
                var subtotal = price * quantity;
                $row.find('.cart-subtotal').text(formatPrice(subtotal));
                updateTotalSum();
            } else if (quantity < 1) {
                $input.val(1);
                var subtotal = price * 1;
                $row.find('.cart-subtotal').text(formatPrice(subtotal));
                updateTotalSum();
            }
        });
    });


    // Инициализация контролов количества
    $(document).ready(function() {
        // Уменьшение количества
        $(document).on('click', '.quantity-minus', function() {
            var $btn = $(this);
            var $wrapper = $btn.closest('.quantity-selector');
            var $input = $wrapper.find('.quantity-input');
            var currentVal = parseInt($input.val());
            var step = parseInt($btn.data('step'));
            var min = parseInt($btn.data('min'));
            
            var newVal = currentVal - step;
            if (newVal >= min) {
                $input.val(newVal).trigger('change');
            }
        });
        
        // Увеличение количества
        $(document).on('click', '.quantity-plus', function() {
            var $btn = $(this);
            var $wrapper = $btn.closest('.quantity-selector');
            var $input = $wrapper.find('.quantity-input');
            var currentVal = parseInt($input.val());
            var step = parseInt($btn.data('step'));
            var max = parseInt($btn.data('max'));
            
            var newVal = currentVal + step;
            if (newVal <= max) {
                $input.val(newVal).trigger('change');
            }
        });
        
        // Обновление кнопки при изменении количества
        $(document).on('change', '.quantity-input', function() {
            var $input = $(this);
            var val = parseInt($input.val());
            var min = parseInt($input.data('min'));
            var max = parseInt($input.data('max'));
            var step = parseInt($input.data('step'));
            
            if (isNaN(val) || val < min) {
                $input.val(min);
            } else if (val > max) {
                $input.val(max);
            } else {
                // Округляем до шага
                var remainder = val % step;
                if (remainder !== 0) {
                    var rounded = Math.round(val / step) * step;
                    if (rounded < min) {
                        $input.val(min);
                    } else if (rounded > max) {
                        $input.val(max);
                    } else {
                        $input.val(rounded);
                    }
                }
            }
            
            // Обновляем data-quantity у кнопки
            var $wrapper = $input.closest('.add-to-cart-wrapper');
            var $cartBtn = $wrapper.find('.btn-add-to-cart');
            $cartBtn.data('quantity', $input.val());
        });
    });
    
})(jQuery);