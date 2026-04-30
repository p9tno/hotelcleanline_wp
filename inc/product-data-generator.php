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
    
    // Первое изображение
    ob_start();
    echo get_product_image_html($product_id);
    $product_data->thumbnail_html = ob_get_clean();
    
    // Второе изображение (новая функция)
    ob_start();
    echo get_product_second_image_html($product_id);
    $product_data->thumbnail_second_html = ob_get_clean();
    
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

    // Параметры количества
    $quantity_params = get_product_quantity_params($product_id);
    $product_data->quantity_params = array(
        'step' => $quantity_params['step'],
        'min' => $quantity_params['min'],
        'max' => $quantity_params['max'],
        'default' => $quantity_params['default']
    );
    
    // Готовая кнопка "Купить"
    ob_start();
    the_full_add_to_cart($product_id, array('show_quantity' => true));
    $product_data->add_to_cart_html = ob_get_clean();
    
    // Характеристики и контент
    $product_data->characteristic = get_field('product_characteristic', $product_id) ?: '';
    $product_data->content = get_field('product_content', $product_id) ?: '';
    
    // КОМПЛЕКТ ТОВАРОВ (product_bundle)
    $product_bundle_str = get_field('product_bundle', $product_id);

    if (!empty($product_bundle_str)) {
        // Преобразуем строку SKU в массив
        $bundle_skus = array_map('trim', explode(',', $product_bundle_str));
        $product_data->bundle_skus = $bundle_skus;
        
        // Получаем ID и данные товаров по SKU
        $bundle_ids = array();
        $bundle_products = array();
        
        foreach ($bundle_skus as $sku) {
            if (empty($sku)) continue;
            
            // Ищем товар по SKU
            $args = array(
                'post_type'      => 'product',
                'meta_key'       => 'product_sku',
                'meta_value'     => $sku,
                'posts_per_page' => 1,
                'fields'         => 'ids'
            );
            $found = get_posts($args);
            
            if (!empty($found)) {
                $bundle_id = $found[0];
                $bundle_ids[] = $bundle_id;
                
                // Готовый HTML через функцию render_bundle_product
                $bundle_products[] = array(
                    'id'    => $bundle_id,
                    'title' => get_the_title($bundle_id),
                    'sku'   => $sku,
                    'permalink' => get_permalink($bundle_id),
                    'html'  => render_bundle_product($bundle_id)
                );
            }
        }
        
        $product_data->bundle_ids = $bundle_ids;
        $product_data->bundle_products = $bundle_products;
        $product_data->has_bundle = !empty($bundle_ids);
    } else {
        $product_data->bundle_skus = array();
        $product_data->bundle_ids = array();
        $product_data->bundle_products = array();
        $product_data->has_bundle = false;
    }
    
    // Метки и категории (для JS)
    $tags = wp_get_post_terms($product_id, 'product_tag', array('fields' => 'names'));
    $product_data->tags = !empty($tags) ? $tags : array();
    
    $categories = wp_get_post_terms($product_id, 'product_category', array('fields' => 'names'));
    $product_data->categories = !empty($categories) ? $categories : array();
    
    return $product_data;
}