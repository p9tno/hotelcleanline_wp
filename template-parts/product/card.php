<?php
/**
 * Карточка товара НЕИСПОЛЬЗУЕТЬСЯ ПОКА
 * 
 * Использование:
 * - В обычном цикле: get_template_part('template-parts/product/card');
 * - С передачей ID: set_query_var('product_id', 123); get_template_part('template-parts/product/card');
 */

// Получаем ID товара
$product_id = get_query_var('product_id');

if (!$product_id) {
    // Если ID не передан, используем глобальный пост
    global $post;
    $product_id = isset($post->ID) ? $post->ID : 0;
}

if (!$product_id) {
    return;
}

// Получаем данные товара
$title = get_the_title($product_id);
$permalink = get_permalink($product_id);
$thumbnail_id = get_post_thumbnail_id($product_id);
$thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'thumbnail') : '';
$no_img_url = get_template_directory_uri() . '/assets/img/no_img.webp';
$price = get_field('product_price', $product_id);
$article = get_field('product_article', $product_id);
?>

<div class="product-card">
    <a href="<?php echo esc_url($permalink); ?>" class="product-image img">
        <img src="<?php echo $thumbnail_url ? esc_url($thumbnail_url) : esc_url($no_img_url); ?>" 
             alt="<?php echo esc_attr($title); ?>"
             loading="lazy">
    </a>
    <h3 class="product-title">
        <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
    </h3>
</div>