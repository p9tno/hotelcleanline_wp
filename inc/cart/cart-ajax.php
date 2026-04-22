<?php
/**
 * AJAX обработчики корзины
 */

// AJAX: добавить товар
add_action('wp_ajax_add_to_cart', 'ajax_add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'ajax_add_to_cart');

function ajax_add_to_cart() {
    check_ajax_referer('cart_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if (!$product_id || get_post_status($product_id) !== 'publish') {
        wp_send_json_error('Товар не найден');
    }
    
    add_to_cart($product_id, $quantity);
    $total_items = get_cart_total_items();
    
    wp_send_json_success(array(
        'message' => 'Товар добавлен в корзину',
        'total_items' => $total_items,
        'cart_url' => home_url('/cart/')
    ));
}

// AJAX: удалить товар
add_action('wp_ajax_remove_from_cart', 'ajax_remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'ajax_remove_from_cart');

function ajax_remove_from_cart() {
    check_ajax_referer('cart_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    remove_from_cart($product_id);
    $total_items = get_cart_total_items();
    
    wp_send_json_success(array(
        'message' => 'Товар удалён',
        'total_items' => $total_items
    ));
}

// AJAX: обновить корзину
add_action('wp_ajax_update_cart', 'ajax_update_cart');
add_action('wp_ajax_nopriv_update_cart', 'ajax_update_cart');

function ajax_update_cart() {
    check_ajax_referer('cart_nonce', 'nonce');
    
    if (!isset($_POST['items']) || !is_array($_POST['items'])) {
        wp_send_json_error('Некорректные данные');
    }
    
    $items = array();
    foreach ($_POST['items'] as $item) {
        $items[intval($item['id'])] = intval($item['quantity']);
    }
    
    update_cart_quantities($items);
    $total_items = get_cart_total_items();
    $cart = get_user_cart();
    
    wp_send_json_success(array(
        'message' => 'Корзина обновлена',
        'total_items' => $total_items,
        'cart' => $cart
    ));
}

// AJAX: очистить корзину
add_action('wp_ajax_clear_cart', 'ajax_clear_cart');
add_action('wp_ajax_nopriv_clear_cart', 'ajax_clear_cart');

function ajax_clear_cart() {
    check_ajax_referer('cart_nonce', 'nonce');
    
    clear_cart();
    
    wp_send_json_success(array(
        'message' => 'Корзина очищена',
        'total_items' => 0
    ));
}


