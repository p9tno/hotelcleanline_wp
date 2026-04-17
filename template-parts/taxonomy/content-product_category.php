<?php
/**
 * Шаблон для категорий продуктов (с табами подкатегорий и товарами по меткам)
 * Оптимизированная версия с использованием ID меток
 */

$term_id = get_queried_object_id();
$no_img_url = get_template_directory_uri() . '/assets/img/no_cat.webp';

// Получаем подкатегории
$child_categories = get_terms(array(
    'taxonomy' => 'product_category',
    'parent' => $term_id,
    'hide_empty' => false,
    'orderby' => 'term_order',
    'order' => 'ASC',
));

// ========== ОПТИМИЗИРОВАННЫЙ ЗАПРОС - ОДИН ЗАПРОС К БД ==========
$structured_data = array();
$all_product_ids = array();

if (!empty($child_categories) && !is_wp_error($child_categories)) {
    $child_ids = wp_list_pluck($child_categories, 'term_id');
    
    // Получаем ВСЕ товары для всех подкатегорий одним запросом
    $all_products = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_category',
                'field' => 'term_id',
                'terms' => $child_ids,
                'include_children' => true,
            ),
        ),
    ));
    
    if ($all_products->have_posts()) {
        while ($all_products->have_posts()) {
            $all_products->the_post();
            $all_product_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }
    
    if (!empty($all_product_ids)) {
        // Получаем все метки для всех товаров
        $all_tags = wp_get_object_terms($all_product_ids, 'product_tag', array(
            'fields' => 'all_with_object_id',
        ));
        
        // Получаем все категории для всех товаров
        $all_cats = wp_get_object_terms($all_product_ids, 'product_category', array(
            'fields' => 'all_with_object_id',
        ));
        
        // Структурируем: product_id => [tag_ids] (используем ID вместо названий)
        $products_tags = array();
        foreach ($all_tags as $term) {
            if (!isset($products_tags[$term->object_id])) {
                $products_tags[$term->object_id] = array();
            }
            if (!in_array($term->term_id, $products_tags[$term->object_id])) {
                $products_tags[$term->object_id][] = $term->term_id;
            }
        }
        
        // Структурируем: product_id => [cat_ids]
        $products_cats = array();
        foreach ($all_cats as $term) {
            if (!isset($products_cats[$term->object_id])) {
                $products_cats[$term->object_id] = array();
            }
            if (!in_array($term->term_id, $products_cats[$term->object_id])) {
                $products_cats[$term->object_id][] = $term->term_id;
            }
        }
        
        // Группируем по [категория][метка] = [товары] (используем ID меток)
        foreach ($all_product_ids as $product_id) {
            $product_cats = isset($products_cats[$product_id]) ? $products_cats[$product_id] : array();
            $product_tags = isset($products_tags[$product_id]) ? $products_tags[$product_id] : array();
            
            foreach ($product_cats as $cat_id) {
                if (in_array($cat_id, $child_ids)) {
                    if (!isset($structured_data[$cat_id])) {
                        $structured_data[$cat_id] = array();
                    }
                    
                    foreach ($product_tags as $tag_id) {
                        if (!isset($structured_data[$cat_id][$tag_id])) {
                            $structured_data[$cat_id][$tag_id] = array();
                        }
                        
                        if (!in_array($product_id, $structured_data[$cat_id][$tag_id])) {
                            $structured_data[$cat_id][$tag_id][] = $product_id;
                        }
                    }
                }
            }
        }
    }
} else {
    // Нет подкатегорий - работаем с текущей категорией
    $products_in_cat = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_category',
                'field' => 'term_id',
                'terms' => $term_id,
                'include_children' => true,
            ),
        ),
    ));
    
    if ($products_in_cat->have_posts()) {
        while ($products_in_cat->have_posts()) {
            $products_in_cat->the_post();
            $all_product_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }
    
    if (!empty($all_product_ids)) {
        $all_tags = wp_get_object_terms($all_product_ids, 'product_tag', array(
            'fields' => 'all_with_object_id',
        ));
        
        foreach ($all_tags as $term) {
            $tag_id = $term->term_id;
            $product_id = $term->object_id;
            
            if (!isset($structured_data[$tag_id])) {
                $structured_data[$tag_id] = array();
            }
            if (!in_array($product_id, $structured_data[$tag_id])) {
                $structured_data[$tag_id][] = $product_id;
            }
        }
    }
}
?>

<?php
// ========== РАСШИРЕННАЯ ОТЛАДКА ==========
if (false) {
    echo '<div style="background: #f0f0f0; padding: 15px; margin: 10px; font-size: 13px; font-family: monospace; border-left: 4px solid #007cba;">';
    echo '<strong style="font-size: 16px;">🔍 ОТЛАДОЧНАЯ ИНФОРМАЦИЯ</strong><br><br>';
    
    echo '<strong>📁 Текущая категория:</strong> ' . single_term_title('', false) . ' (ID: ' . $term_id . ')<br>';
    echo '<strong>📂 Подкатегорий найдено:</strong> ' . count($child_categories) . '<br>';
    
    if (!empty($child_categories)) {
        echo '<strong>📋 Список подкатегорий:</strong><br>';
        foreach ($child_categories as $cat) {
            echo '&nbsp;&nbsp;&nbsp;- ' . $cat->name . ' (ID: ' . $cat->term_id . ')<br>';
        }
    }
    
    echo '<br><strong>📦 Товаров найдено:</strong> ' . count($all_product_ids) . '<br>';
    
    // Показываем ВСЕ метки для КАЖДОГО товара
    if (!empty($all_product_ids)) {
        echo '<br><strong>🔍 ДЕТАЛЬНАЯ ИНФОРМАЦИЯ ПО ТОВАРАМ:</strong><br>';
        foreach ($all_product_ids as $pid) {
            $tags = wp_get_post_terms($pid, 'product_tag', array('fields' => 'names'));
            $cats = wp_get_post_terms($pid, 'product_category', array('fields' => 'names'));
            echo '<strong>&nbsp;&nbsp;&nbsp;📦 Товар: ' . get_the_title($pid) . ' (ID: ' . $pid . ')</strong><br>';
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📂 Категории: ' . ( !empty($cats) ? implode(', ', $cats) : 'Нет категорий' ) . '<br>';
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;🏷️ Метки: ' . ( !empty($tags) ? implode(', ', $tags) : 'Нет меток' ) . '<br>';
            echo '<br>';
        }
    }
    
    echo '<strong>🏷️ Структура по меткам (как сгруппировал код):</strong><br>';
    if (!empty($structured_data)) {
        foreach ($structured_data as $key => $value) {
            if (is_array($value)) {
                if (isset($child_ids) && is_array($child_ids) && in_array($key, $child_ids)) {
                    $cat = get_term($key);
                    echo '<strong>&nbsp;&nbsp;&nbsp;📂 Категория: ' . ($cat ? $cat->name : $key) . '</strong><br>';
                    foreach ($value as $tag_id => $products) {
                        $tag = get_term($tag_id, 'product_tag');
                        $tag_name = $tag ? $tag->name : $tag_id;
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;🏷️ Метка: ' . $tag_name . ' (ID: ' . $tag_id . ', ' . count($products) . ' товаров)<br>';
                        foreach ($products as $pid) {
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . get_the_title($pid) . ' (ID: ' . $pid . ')<br>';
                        }
                    }
                } else {
                    $tag = get_term($key, 'product_tag');
                    $tag_name = $tag ? $tag->name : $key;
                    echo '&nbsp;&nbsp;&nbsp;🏷️ Метка: ' . $tag_name . ' (ID: ' . $key . ', ' . count($value) . ' товаров)<br>';
                    foreach ($value as $pid) {
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . get_the_title($pid) . ' (ID: ' . $pid . ')<br>';
                    }
                }
            }
        }
    } else {
        echo '<span style="color: #ff9800;">⚠️ Нет структурированных данных по меткам!!!</span><br>';
    }
    
    echo '</div>';
}
?>


<script>
    <?php
    // Генерируем данные для всех комбинаций подкатегория + метка
    $allProductsData = array();
    $no_img_url = get_template_directory_uri() . '/assets/img/no_img.webp';
    
    if (!empty($structured_data)) {
        foreach ($structured_data as $cat_id => $tags_data) {
            $category = get_term($cat_id, 'product_category');
            if (!$category || is_wp_error($category)) continue;
            
            foreach ($tags_data as $tag_id => $product_ids) {
                $tag = get_term($tag_id, 'product_tag');
                if (!$tag || is_wp_error($tag)) continue;
                
                $products_for_combo = array();
                
                foreach ($product_ids as $product_id) {
                    $product = get_post($product_id);
                    if (!$product) continue;
                    
                    $product_data = new stdClass();
                    $product_data->id = $product_id;
                    $product_data->title = get_the_title($product_id);
                    $product_data->slug = $product->post_name;
                    $product_data->permalink = get_permalink($product_id);
                    
                    // ========== ЦЕНА (с использованием PHP функции) ==========
                    $product_price = get_field('product_price', $product_id);
                    $product_data->price = $product_price ? (float)$product_price : null;
                    
                    // Получаем отформатированную цену через PHP функцию
                    if ($product_price) {
                        ob_start();
                        the_product_price($product_id, true);
                        $product_data->price_formatted = ob_get_clean();
                    } else {
                        $product_data->price_formatted = '';
                    }
                    
                    // ========== АРТИКУЛ ==========
                    $product_sku = get_field('product_sku', $product_id);
                    $product_data->sku = $product_sku ? $product_sku : '';
                    
                    // ========== ИЗОБРАЖЕНИЕ (с использованием PHP функции) ==========
                    // Получаем HTML изображения через PHP функцию
                    ob_start();
                    echo get_product_image_html($product_id);
                    $product_data->thumbnail_html = ob_get_clean();
                    
                    // Дополнительно получаем URL для fallback
                    $thumbnail_id = get_post_thumbnail_id($product_id);
                    if ($thumbnail_id) {
                        $product_data->thumbnail_medium = wp_get_attachment_image_url($thumbnail_id, 'medium');
                    } else {
                        $product_data->thumbnail_medium = $no_img_url;
                    }
                    
                    // ========== ХАРАКТЕРИСТИКИ ==========
                    $product_specifications = get_field('product_specifications', $product_id);
                    $product_data->specifications = array();
                    if ($product_specifications && is_array($product_specifications)) {
                        foreach ($product_specifications as $spec) {
                            if (!empty($spec['product_spec_name']) && !empty($spec['product_spec_value'])) {
                                $product_data->specifications[] = array(
                                    'name' => $spec['product_spec_name'],
                                    'value' => $spec['product_spec_value']
                                );
                            }
                        }
                    }
                    
                    // ========== СТАТУС НАЛИЧИЯ ==========
                    $product_data->stock_status = 'instock';
                    
                    // ========== МЕТКИ И КАТЕГОРИИ ==========
                    $tags = wp_get_post_terms($product_id, 'product_tag', array('fields' => 'names'));
                    $product_data->tags = !empty($tags) ? $tags : array();
                    
                    $categories = wp_get_post_terms($product_id, 'product_category', array('fields' => 'names'));
                    $product_data->categories = !empty($categories) ? $categories : array();
                    
                    $products_for_combo[] = $product_data;
                }
                
                // Создаём объект комбинации
                $combination = new stdClass();
                $combination->category_id = $cat_id;
                $combination->category_name = $category->name;
                $combination->category_slug = $category->slug;
                $combination->tag_id = $tag_id;
                $combination->tag_name = $tag->name;
                $combination->tag_slug = $tag->slug;
                $combination->tag_description = $tag->description;
                $combination->products = $products_for_combo;
                $combination->products_count = count($products_for_combo);
                
                // Получаем изображение метки (если есть ваша функция)
                if (function_exists('get_taxonomy_image_html')) {
                    $tag_image = get_taxonomy_image_html($tag_id, $tag->taxonomy);
                    $combination->tag_image = $tag_image;
                }
                
                $allProductsData[] = $combination;
            }
        }
    }
    ?>

    // Данные всех комбинаций товаров по подкатегориям и меткам
    const productsCombinations = <?php echo json_encode($allProductsData, JSON_UNESCAPED_UNICODE); ?>;
    console.log('productsCombinations:', productsCombinations);
    
</script>

<?php get_template_part( 'template-parts/sections/section', 'head' ); ?>

<?php if (!empty($child_categories) && !is_wp_error($child_categories)) : ?>

<!-- begin subcategories -->
<section id="subcategories" class="subcategories section">
    <div class="container_center">

        <h1 class="section__title">Наборы</h1>
        
        <div class="section__wrap">

            <div class="subcategories__content">

                <div class="subcategories__tabs">
                    <div class="tabs__wrapper">
                        
                        <!-- Заголовки табов -->
                        <div class="tabs">
                            <?php foreach ($child_categories as $index => $child) : ?>
                                <div class="tab <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="tab-<?php echo $child->term_id; ?>">
                                    <?php echo esc_html($child->name); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Контент табов -->
                        <div class="tabs__content">
                            <?php foreach ($child_categories as $index => $child) : 
                                $cat_data = isset($structured_data[$child->term_id]) ? $structured_data[$child->term_id] : array();
                            ?>
                                <div class="tab__item <?php echo $index === 0 ? 'active' : ''; ?>" id="tab-<?php echo $child->term_id; ?>">
                                    <div class="tag__grid">
                                        <?php if (!empty($cat_data)) : ?>
                                            <?php foreach ($cat_data as $tag_id => $tag_product_ids) : 
                                                $tag = get_term($tag_id, 'product_tag');
                                                if (!$tag || is_wp_error($tag)) continue;
                                                // get_pr($tag);
                                                $tag_link = get_term_link($tag);
                                                $tag_name = $tag->name;
                                                $tag_taxonomy = $tag->taxonomy;
                                                $tag_slug = $tag->slug;
                                                $tag_description = $tag->description;
                                                $tag_image = get_taxonomy_image_html($tag_id, $tag_taxonomy);
                                            ?>
                                                <div 
                                                    class="tag show_tag_products_js"
                                                    data-tag-id="<?php echo $tag_id; ?>" 
                                                    data-category-id="<?php echo $child->term_id; ?>"
                                                >
                                                    
                                                
                                                    <div class="tag__img img"><?php echo $tag_image; ?></div>
                                                    <div class="tag__content glass_card">
                                                        <div class="tag__title"><?php echo esc_html($tag_name); ?></div>
                                                        <?php if ($tag_description) { ?>
                                                            <div class="tag__desc"><?php echo esc_html($tag_description); ?></div>
                                                        <?php } ?>
                                                    </div>
                                                  
                                                   
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <?php custom_info('! В этой подкатегории нет товаров с метками.'); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
    
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</section>
<!-- end subcategories -->

<?php else : 
    // Нет подкатегорий
    if (!empty($structured_data)) : ?>

        <?php get_template_part( 'template-parts/sections/section', 'taxProducts' ); ?>

    <?php else : ?>
        
        <div class="no-content section">
            <div class="container_center">
                <div class="no-content__content">
                    <p>В этой категории пока нет товаров с метками.</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">Вернуться на главную</a>
                </div>
            </div>
        </div>
        
    <?php endif;
endif; ?>