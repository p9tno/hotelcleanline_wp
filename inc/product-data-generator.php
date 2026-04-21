<?php
/**
 * Генерация данных для JavaScript
 */

// Предотвращаем прямой доступ
if (!defined('ABSPATH')) {
    exit;
}

// Определяем константу
if (!defined('NO_IMAGE_URL')) {
    define('NO_IMAGE_URL', get_template_directory_uri() . '/assets/img/no_cat.webp');
}

/**
 * Генерирует данные для JavaScript из структурированных данных
 */
function generate_products_js_data($structured_data) {
    $allProductsData = array();
    $no_img_url = NO_IMAGE_URL;
    
    if (empty($structured_data)) {
        return $allProductsData;
    }
    
    foreach ($structured_data as $cat_id => $tags_data) {
        $category = get_term($cat_id, 'product_category');
        if (!$category || is_wp_error($category)) continue;
        
        foreach ($tags_data as $tag_id => $product_ids) {
            $tag = get_term($tag_id, 'product_tag');
            if (!$tag || is_wp_error($tag)) continue;
            
            $combination = build_product_combination(
                $category, $tag, $product_ids, $no_img_url
            );
            
            $allProductsData[] = $combination;
        }
    }
    
    return $allProductsData;
}

/**
 * Выводит JavaScript скрипт с данными для страницы
 */
function render_products_js_data($structured_data) {
    $allProductsData = generate_products_js_data($structured_data);
    ?>
    <script>
        // Данные для JavaScript
        const productsCombinations = <?php echo json_encode($allProductsData, JSON_UNESCAPED_UNICODE); ?>;
        console.group('📦 productsCombinations');
        console.log('Количество комбинаций:', productsCombinations.length);
        console.log('Данные:', productsCombinations);
        console.groupEnd();
    </script>
    <?php
}

/**
 * Строит комбинацию категория + метка
 */
function build_product_combination($category, $tag, $product_ids, $no_img_url) {
    $combination = new stdClass();
    $combination->category_id = $category->term_id;
    $combination->category_name = $category->name;
    $combination->category_slug = $category->slug;
    $combination->tag_id = $tag->term_id;
    $combination->tag_name = $tag->name;
    $combination->tag_slug = $tag->slug;
    $combination->tag_description = $tag->description;
    $combination->products = array();
    $combination->products_count = count($product_ids);
    
    foreach ($product_ids as $product_id) {
        $product_data = build_product_data($product_id, $no_img_url);
        if ($product_data) {
            $combination->products[] = $product_data;
        }
    }
    
    if (function_exists('get_taxonomy_image_html')) {
        $combination->tag_image = get_taxonomy_image_html($tag->term_id, $tag->taxonomy);
    }
    
    return $combination;
}

/**
 * Строит данные для одного товара
 */
function build_product_data($product_id, $no_img_url) {
    $product = get_post($product_id);
    if (!$product) return null;
    
    $product_data = new stdClass();
    $product_data->id = $product_id;
    $product_data->title = get_the_title($product_id);
    $product_data->slug = $product->post_name;
    $product_data->permalink = get_permalink($product_id);
    
    // Цена
    $product_price = get_field('product_price', $product_id);
    $product_data->price = $product_price ? (float)$product_price : null;
    
    if ($product_price) {
        ob_start();
        the_product_price($product_id, true);
        $product_data->price_formatted = ob_get_clean();
    } else {
        $product_data->price_formatted = '';
    }
    
    // Артикул
    $product_data->sku = get_field('product_sku', $product_id) ?: '';
    
    // Изображение
    ob_start();
    echo get_product_image_html($product_id);
    $product_data->thumbnail_html = ob_get_clean();
    
    $thumbnail_id = get_post_thumbnail_id($product_id);
    $product_data->thumbnail_medium = $thumbnail_id ? 
        wp_get_attachment_image_url($thumbnail_id, 'medium') : $no_img_url;
    
    // Статус товара
    $product_status = get_field('product_status', $product_id);
    if (is_array($product_status)) {
        $product_data->stock_status_value = $product_status['value'] ?? 'instock';
        $product_data->stock_status_label = $product_status['label'] ?? 'В наличии';
    } else {
        $product_data->stock_status_value = 'instock';
        $product_data->stock_status_label = 'В наличии';
    }
    
    // Характеристики и контент
    $product_data->characteristic = get_field('product_characteristic', $product_id) ?: '';
    $product_data->content = get_field('product_content', $product_id) ?: '';
    
    // Метки и категории (для JS)
    $tags = wp_get_post_terms($product_id, 'product_tag', array('fields' => 'names'));
    $product_data->tags = !empty($tags) ? $tags : array();
    
    $categories = wp_get_post_terms($product_id, 'product_category', array('fields' => 'names'));
    $product_data->categories = !empty($categories) ? $categories : array();
    
    return $product_data;
}