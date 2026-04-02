<?php
/**
 * Функция для вывода отформатированной цены с символом валюты
 * 
 * @param float|int $price Цена
 * @param int|string $post_id ID поста (опционально, для переопределения валюты для конкретного товара)
 * @return string Отформатированная цена с валютой
 */
function format_price_with_currency($price, $post_id = null) {
    // Получаем настройки валюты из глобальных настроек
    $currency_symbol = get_field('currency_symbol', 'option');
    $currency_position = get_field('currency_position', 'option');
    $thousand_separator = get_field('currency_thousand_separator', 'option');
    $decimal_separator = get_field('currency_decimal_separator', 'option');
    $decimals = get_field('currency_decimals', 'option');
    
    // Обработка кастомного символа валюты
    if ($currency_symbol === 'custom') {
        $currency_symbol = get_field('currency_symbol_custom', 'option');
        if (empty($currency_symbol)) {
            $currency_symbol = '₽'; // fallback
        }
    }
    
    // Настройки по умолчанию (если поля не сохранены)
    $currency_symbol = $currency_symbol ?: '₽';
    $currency_position = $currency_position ?: 'after';
    $decimals = $decimals !== '' ? $decimals : 0;
    
    // Преобразуем разделители тысяч
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
    
    // Преобразуем разделитель копеек
    $decimal_sep = $decimal_separator === 'comma' ? ',' : '.';
    
    // Форматируем число
    $formatted_price = number_format($price, $decimals, $decimal_sep, $thousand_sep);
    
    // Возвращаем цену с символом валюты в нужной позиции
    switch ($currency_position) {
        case 'before':
            return $currency_symbol . $formatted_price;
        case 'before_space':
            return $currency_symbol . ' ' . $formatted_price;
        case 'after_space':
            return $formatted_price . ' ' . $currency_symbol;
        case 'after':
        default:
            return $formatted_price . $currency_symbol;
    }
}

/**
 * Функция для вывода цены товара с валютой (сокращённый вариант)
 * 
 * @param float|int $price Цена
 * @param bool $echo Выводить или возвращать
 * @return string|void
 */
function the_price($price, $echo = true) {
    $result = format_price_with_currency($price);
    if ($echo) {
        echo $result;
    }
    return $result;
}

/**
 * Получить только символ валюты
 * 
 * @return string Символ валюты
 */
function get_currency_symbol() {
    $currency_symbol = get_field('currency_symbol', 'option');
    
    if ($currency_symbol === 'custom') {
        $currency_symbol = get_field('currency_symbol_custom', 'option');
    }
    
    return $currency_symbol ?: '₽';
}

/**
 * Получить только символ валюты (сокращённо)
 */
function currency_sym() {
    return get_currency_symbol();
}