<?php
/**
 * Функция для вывода отформатированной цены текущего товара с раздельными тегами
 * 
 * @param int|string $post_id ID поста (опционально, по умолчанию текущий пост)
 * @param bool $echo Выводить или возвращать
 * @return string|void HTML цена с валютой
 */
function the_product_price($post_id = null, $echo = true) {
    // Если не передан ID, берем текущий пост
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    // Получаем цену из поля product_price
    $price = get_field('product_price', $post_id);
    
    // Если цены нет, возвращаем пустоту
    if (!$price && $price !== 0) {
        return '';
    }
    
    // Получаем настройки валюты
    $currency_position = get_field('currency_position', 'option') ?: 'after';
    $thousand_separator = get_field('currency_thousand_separator', 'option');
    
    // Преобразуем разделитель тысяч
    switch ($thousand_separator) {
        case 'space':
            $thousand_sep = ' ';
            break;
        case 'comma':
            $thousand_sep = ',';
            break;
        case 'dot':
            $thousand_sep = '.';
            break;
        default:
            $thousand_sep = '';
    }
    
    // Форматируем число
    $formatted_price = number_format($price, 0, '', $thousand_sep);
    $currency_symbol = '₽';
    
    // Формируем HTML с раздельными тегами
    $price_html = '<span class="product-price">';
    
    switch ($currency_position) {
        case 'before':
            $price_html .= '<span class="currency-symbol currency-before">' . $currency_symbol . '</span>';
            $price_html .= '<span class="price-amount">' . $formatted_price . '</span>';
            break;
        case 'before_space':
            $price_html .= '<span class="currency-symbol currency-before with-space">' . $currency_symbol . '</span>';
            $price_html .= '<span class="price-amount">' . $formatted_price . '</span>';
            break;
        case 'after_space':
            $price_html .= '<span class="price-amount">' . $formatted_price . '</span>';
            $price_html .= '<span class="currency-symbol currency-after with-space">' . $currency_symbol . '</span>';
            break;
        case 'after':
        default:
            $price_html .= '<span class="price-amount">' . $formatted_price . '</span>';
            $price_html .= '<span class="currency-symbol currency-after">' . $currency_symbol . '</span>';
    }
    
    $price_html .= '</span>';
    
    if ($echo) {
        echo $price_html;
    }
    
    return $price_html;
}

/**
 * Получить только отформатированное число (без символа валюты)
 * 
 * @param int|string $post_id ID поста (опционально)
 * @param bool $echo Выводить или возвращать
 * @return string|void
 */
function the_product_price_number($post_id = null, $echo = true) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $price = get_field('product_price', $post_id);
    
    if (!$price && $price !== 0) {
        return '';
    }
    
    $thousand_separator = get_field('currency_thousand_separator', 'option');
    
    switch ($thousand_separator) {
        case 'space':
            $thousand_sep = ' ';
            break;
        case 'comma':
            $thousand_sep = ',';
            break;
        case 'dot':
            $thousand_sep = '.';
            break;
        default:
            $thousand_sep = '';
    }
    
    $result = number_format($price, 0, '', $thousand_sep);
    
    if ($echo) {
        echo $result;
    }
    
    return $result;
}

/**
 * Получить только символ валюты с оберткой
 * 
 * @param bool $echo Выводить или возвращать
 * @return string|void
 */
function the_currency_symbol($echo = true) {
    $symbol = '₽';
    $result = '<span class="currency-symbol">' . $symbol . '</span>';
    
    if ($echo) {
        echo $result;
    }
    
    return $result;
}

/**
 * Получить цену товара без форматирования (только число)
 * 
 * @param int|string $post_id ID поста (опционально)
 * @return float|int|null Цена или null если не найдена
 */
function get_product_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $price = get_field('product_price', $post_id);
    return $price ? floatval($price) : null;
}

/**
 * Простое форматирование цены для любых чисел с раздельными тегами
 * 
 * @param float|int $price Цена
 * @return string HTML цена с валютой
 */
function format_price($price) {
    $currency_position = get_field('currency_position', 'option') ?: 'after';
    $thousand_separator = get_field('currency_thousand_separator', 'option');
    
    // Преобразуем разделитель тысяч
    switch ($thousand_separator) {
        case 'space':
            $thousand_sep = ' ';
            break;
        case 'comma':
            $thousand_sep = ',';
            break;
        case 'dot':
            $thousand_sep = '.';
            break;
        default:
            $thousand_sep = '';
    }
    
    $formatted_price = number_format($price, 0, '', $thousand_sep);
    $currency_symbol = '₽';
    
    $price_html = '<span class="product-price">';
    
    switch ($currency_position) {
        case 'before':
            $price_html .= '<span class="currency-symbol currency-before">' . $currency_symbol . '</span>';
            $price_html .= '<span class="price-amount">' . $formatted_price . '</span>';
            break;
        case 'before_space':
            $price_html .= '<span class="currency-symbol currency-before with-space">' . $currency_symbol . '</span>';
            $price_html .= '<span class="price-amount">' . $formatted_price . '</span>';
            break;
        case 'after_space':
            $price_html .= '<span class="price-amount">' . $formatted_price . '</span>';
            $price_html .= '<span class="currency-symbol currency-after with-space">' . $currency_symbol . '</span>';
            break;
        case 'after':
        default:
            $price_html .= '<span class="price-amount">' . $formatted_price . '</span>';
            $price_html .= '<span class="currency-symbol currency-after">' . $currency_symbol . '</span>';
    }
    
    $price_html .= '</span>';
    
    return $price_html;
}
?>