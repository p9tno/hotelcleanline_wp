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
    
    // ✅ ИСПРАВЛЕНО: проверяем результат
    $result = add_to_cart($product_id, $quantity);
    
    if (is_wp_error($result)) {
        wp_send_json_error($result->get_error_message());
    }
    
    $total_items = get_cart_total_items();
    $product_title = get_the_title($product_id);
    
    wp_send_json_success(array(
        'message' => '"' . $product_title . '" добавлен в корзину',
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

/**
 * Экспорт корзины в Excel
 */
add_action('wp_ajax_export_cart_excel', 'ajax_export_cart_excel');
add_action('wp_ajax_nopriv_export_cart_excel', 'ajax_export_cart_excel');

function ajax_export_cart_excel() {
    check_ajax_referer('cart_nonce', 'nonce');
    
    $cart = get_user_cart();
    
    if (empty($cart)) {
        wp_send_json_error('Корзина пуста');
    }
    
    // Получаем товары
    $product_ids = array_keys($cart);
    $products = array();
    
    foreach ($product_ids as $id) {
        $product = get_post($id);
        if ($product && $product->post_type === 'product') {
            $price = get_field('product_price', $id);
            $quantity = $cart[$id]['quantity'];
            $total = $price * $quantity;
            
            $products[] = array(
                'title' => $product->post_title,
                'sku' => get_field('product_sku', $id),
                'price' => $price,
                'quantity' => $quantity,
                'total' => $total,
                'link' => get_permalink($id)
            );
        }
    }
    
    // Формируем данные для CSV
    $excel_data = array();
    
    // Заголовки
    $excel_data[] = array(
        'Наименование',
        'Артикул',
        'Цена (₽)',
        'Количество',
        'Сумма (₽)',
        'Ссылка на товар'
    );
    
    // Данные товаров
    foreach ($products as $item) {
        $excel_data[] = array(
            $item['title'],
            $item['sku'] ?: '—',
            $item['price'],
            $item['quantity'],
            $item['total'],
            $item['link']
        );
    }
    
    // Итоговая строка
    $total_sum = array_sum(array_column($products, 'total'));
    $excel_data[] = array('', '', '', 'ИТОГО:', $total_sum, '');
    
    // Создаем CSV файл
    $filename = 'Корзина_HotelCleanLine_' . date('d.m.Y') . '.csv';
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Добавляем BOM для корректной работы с UTF-8 в Excel
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    foreach ($excel_data as $row) {
        fputcsv($output, $row, ';');
    }
    
    fclose($output);
    exit;
}