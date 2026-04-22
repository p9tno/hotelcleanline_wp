<?php
/**
 * Функции корзины
 */

// Запуск сессии
add_action('init', 'cart_start_session');
function cart_start_session() {
    if (!session_id() && !is_admin()) {
        session_start();
    }
}

// Получить ID текущей корзины
function get_cart_session_id() {
    $cookie_name = 'cart_session_id';
    
    if (isset($_COOKIE[$cookie_name])) {
        return sanitize_text_field($_COOKIE[$cookie_name]);
    }
    
    $session_id = uniqid('cart_', true);
    setcookie($cookie_name, $session_id, time() + 2592000, '/');
    return $session_id;
}

// Получить корзину
function get_user_cart() {
    $session_id = get_cart_session_id();
    $cart = get_option('cart_' . $session_id, array());
    
    if (!empty($cart)) {
        foreach ($cart as $product_id => $item) {
            if (get_post_status($product_id) !== 'publish') {
                unset($cart[$product_id]);
            }
        }
    }
    
    return $cart;
}

// Сохранить корзину
function save_user_cart($cart) {
    $session_id = get_cart_session_id();
    update_option('cart_' . $session_id, $cart, false);
    
    if (rand(1, 100) === 1) {
        cart_cleanup_old_carts();
    }
}

// Очистка старых корзин
function cart_cleanup_old_carts() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'cart_%' AND option_value = ''");
}

// Добавить товар
function add_to_cart($product_id, $quantity = 1) {
    $cart = get_user_cart();
    $product_id = intval($product_id);
    $quantity = max(1, intval($quantity));
    
    if (isset($cart[$product_id])) {
        $cart[$product_id]['quantity'] += $quantity;
    } else {
        $cart[$product_id] = array(
            'id' => $product_id,
            'quantity' => $quantity,
            'added_at' => current_time('timestamp')
        );
    }
    
    save_user_cart($cart);
    return count($cart);
}

// Удалить товар
function remove_from_cart($product_id) {
    $cart = get_user_cart();
    $product_id = intval($product_id);
    
    if (isset($cart[$product_id])) {
        unset($cart[$product_id]);
        save_user_cart($cart);
    }
    
    return $cart;
}

// Обновить количества
function update_cart_quantities($items) {
    $cart = array();
    
    foreach ($items as $product_id => $quantity) {
        $product_id = intval($product_id);
        $quantity = max(0, intval($quantity));
        
        if ($quantity > 0 && get_post_status($product_id) === 'publish') {
            $cart[$product_id] = array(
                'id' => $product_id,
                'quantity' => $quantity,
                'added_at' => current_time('timestamp')
            );
        }
    }
    
    save_user_cart($cart);
    return $cart;
}

// Очистить корзину
function clear_cart() {
    $session_id = get_cart_session_id();
    delete_option('cart_' . $session_id);
    return array();
}

// Получить количество товаров
function get_cart_total_items() {
    $cart = get_user_cart();
    return count($cart);
}