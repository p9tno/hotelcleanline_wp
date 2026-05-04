// cart.js
(function($) {
    'use strict';
    $(document).ready(function() {

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
        
        // Функция форматирования цены
        function formatPrice(price) {
            return Math.round(price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' ₽';
        }
        
        // Функция обновления общей суммы на странице корзины
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
        
        // Функция обновления количества товара в корзине (AJAX)
        function updateCartItem(productId, quantity) {
            var items = [];
            
            // Собираем все товары из корзины
            $('.cart-table tbody tr').each(function() {
                var $row = $(this);
                var id = $row.data('product-id');
                var qty;
                
                if (id == productId) {
                    qty = quantity;
                } else {
                    // Ищем input в этой строке
                    var $input = $row.find('.wrap-add-to-cart .quantity-input');
                    qty = $input.length ? $input.val() : $row.find('.cart-quantity input').val();
                }
                
                if (id && qty > 0) {
                    items.push({
                        id: id,
                        quantity: parseInt(qty)
                    });
                }
            });
            
            $.ajax({
                url: cart_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_cart',
                    items: items,
                    nonce: cart_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Обновляем сумму для текущего товара
                        var $row = $('tr[data-product-id="' + productId + '"]');
                        var priceText = $row.find('.cart-price').text();
                        var price = parseFloat(priceText.replace(/[^0-9.-]+/g, ''));
                        var subtotal = price * quantity;
                        $row.find('.cart-subtotal').text(formatPrice(subtotal));
                        
                        // Обновляем общую сумму
                        updateTotalSum();
                        
                        // Обновляем бейдж
                        if (response.data.total_items !== undefined) {
                            updateCartBadge(response.data.total_items);
                        }
                        
                    } else {
                        showToast(response.data || 'Ошибка обновления', 'danger', true, 3000);
                    }
                },
                error: function() {
                    showToast('Ошибка сервера', 'danger', true, 3000);
                }
            });
        }
    
        // Функция добавления в корзину
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
        
        // Обновление бейджа корзины
        window.updateCartBadge = function(count) {
            var $cartCount = $('.cart-count');
            $cartCount.text(count);
            
            if (count == 0) {
                $cartCount.hide();
            } else {
                $cartCount.show();
            }
        };
        
        // Обработчик клика для кнопок "Купить"
        $(document).on('click', '.btn-add-to-cart', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var quantity = $btn.data('quantity') || 1000;
            
            if (productId) {
                window.addToCart(productId, quantity, this);
            } else {
                showToast('Ошибка: ID товара не найден', 'danger', true, 3000);
            }
        });
        
        // ===== СТРАНИЦА КОРЗИНЫ =====
        
        // Очистка корзины
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
        
        // Удаление одного товара
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
                        if (response.data.total_items !== undefined) {
                            updateCartBadge(response.data.total_items);
                        }
                        
                        // Сначала удаляем строку
                        $row.fadeOut(300, function() {
                            $(this).remove();
                            
                            // После удаления пересчитываем сумму
                            if ($('.cart-table tbody tr').length === 0) {
                                // Корзина пуста - перезагружаем страницу
                                location.reload();
                            } else {
                                // Пересчитываем общую сумму
                                updateTotalSum();
                            }
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
        
        // ===== УПРАВЛЕНИЕ КОЛИЧЕСТВОМ (единая структура) =====
        
        // Уменьшение количества
        $(document).on('click', '.wrap-add-to-cart .quantity-minus', function() {
            var $btn = $(this);
            var $selector = $btn.closest('.quantity-selector');
            var $input = $selector.find('.quantity-input');
            var currentVal = parseInt($input.val());
            var step = parseInt($btn.data('step'));
            var min = parseInt($btn.data('min'));
            
            var newVal = currentVal - step;
            if (newVal >= min) {
                $input.val(newVal).trigger('change');
            }
        });
        
        // Увеличение количества
        $(document).on('click', '.wrap-add-to-cart .quantity-plus', function() {
            var $btn = $(this);
            var $selector = $btn.closest('.quantity-selector');
            var $input = $selector.find('.quantity-input');
            var currentVal = parseInt($input.val());
            var step = parseInt($btn.data('step'));
            var max = parseInt($btn.data('max'));
            
            var newVal = currentVal + step;
            if (newVal <= max) {
                $input.val(newVal).trigger('change');
            }
        });
        
        // Обновление при изменении количества
        $(document).on('change', '.wrap-add-to-cart .quantity-input', function() {
            var $input = $(this);
            var $wrap = $input.closest('.wrap-add-to-cart');
            var val = parseInt($input.val());
            var min = parseInt($input.data('min'));
            var max = parseInt($input.data('max'));
            var step = parseInt($input.data('step'));
            
            // Валидация
            if (isNaN(val) || val < min) {
                val = min;
                $input.val(min);
            } else if (val > max) {
                val = max;
                $input.val(max);
            } else {
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
            
            // Проверяем, есть ли кнопка внутри обертки
            var $cartBtn = $wrap.find('.btn-add-to-cart');
            if ($cartBtn.length) {
                // Каталог - обновляем data-quantity у кнопки
                $cartBtn.data('quantity', $input.val());
            } else {
                // Корзина - отправляем AJAX
                updateCartItem($input.data('product-id'), $input.val());
            }
        });
        
        // ===== ЭКСПОРТ В EXCEL =====
        $('#export-excel').on('click', function() {
            var $btn = $(this);
            $btn.prop('disabled', true).text('Загрузка...');
            
            $.ajax({
                url: cart_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'export_cart_excel',
                    nonce: cart_ajax.nonce
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob) {
                    var link = document.createElement('a');
                    var url = window.URL.createObjectURL(blob);
                    link.href = url;
                    
                    var now = new Date();
                    var day = String(now.getDate()).padStart(2, '0');
                    var month = String(now.getMonth() + 1).padStart(2, '0');
                    var year = now.getFullYear();
                    
                    link.download = 'Корзина_HotelCleanLine_' + day + '.' + month + '.' + year + '.csv';
                    
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);
                    
                    showToast('Файл успешно скачан', 'success', true, 3000);
                },
                error: function() {
                    showToast('Ошибка при формировании файла', 'danger', true, 3000);
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Скачать Excel');
                }
            });
        });
        
    });
})(jQuery);