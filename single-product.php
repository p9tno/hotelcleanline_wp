<?php
/**
 * Шаблон для страницы товара (single-product.php)
 */

get_header();

// Получаем ID текущего товара
$product_id = get_queried_object_id();

// Получаем все ACF поля
$product_image_id = get_field('product_image_id');
$product_gallery = get_field('product_gallery');
$product_price = get_field('product_price');
$product_sku = get_field('product_sku');
$product_specifications = get_field('product_specifications');
$product_related_products = get_field('product_related_products');
$product_cross_sell = get_field('product_cross_sell');
$product_up_sell = get_field('product_up_sell');
$product_files = get_field('product_files');

// Получаем категории товара
$product_categories = wp_get_object_terms($product_id, 'product_category');
// Получаем метки товара
$product_tags = wp_get_object_terms($product_id, 'product_tag');
?>

<!-- begin product -->
<section class="product section">
    <div class="container">
        
        <h1 class="product__title"><?php the_title(); ?></h1>
        
        <!-- Основное изображение -->
        <?php if ($product_image_id) : ?>
            <div class="product__main-image">
                <?php echo wp_get_attachment_image($product_image_id, 'large'); ?>
            </div>
        <?php endif; ?>
        
        <!-- Галерея изображений -->
        <?php if ($product_gallery) : ?>
            <div class="product__gallery">
                <h3>Галерея изображений</h3>
                <div class="product__gallery-grid">
                    <?php foreach ($product_gallery as $image_id) : ?>
                        <div class="product__gallery-item">
                            <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Цена -->
        <?php if ($product_price) : ?>
            <div class="product__price">
                <strong>Цена:</strong> <?php echo $product_price; ?> ₽
            </div>
        <?php endif; ?>
        
        <!-- Артикул -->
        <?php if ($product_sku) : ?>
            <div class="product__sku">
                <strong>Артикул:</strong> <?php echo esc_html($product_sku); ?>
            </div>
        <?php endif; ?>
        
        <!-- Категории -->
        <?php if ($product_categories && !is_wp_error($product_categories)) : ?>
            <div class="product__categories">
                <strong>Категории:</strong>
                <ul>
                    <?php foreach ($product_categories as $category) : ?>
                        <li>
                            <a href="<?php echo get_term_link($category); ?>">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Метки -->
        <?php if ($product_tags && !is_wp_error($product_tags)) : ?>
            <div class="product__tags">
                <strong>Метки:</strong>
                <ul>
                    <?php foreach ($product_tags as $tag) : ?>
                        <li>
                            <a href="<?php echo get_term_link($tag); ?>">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Характеристики -->
        <?php if ($product_specifications) : ?>
            <div class="product__specifications">
                <h3>Характеристики</h3>
                <table>
                    <tbody>
                        <?php foreach ($product_specifications as $spec) : ?>
                            <tr>
                                <th><?php echo esc_html($spec['product_spec_name']); ?></th>
                                <td><?php echo esc_html($spec['product_spec_value']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <!-- Файлы для скачивания -->
        <?php if ($product_files) : ?>
            <div class="product__files">
                <h3>Файлы для скачивания</h3>
                <ul>
                    <?php foreach ($product_files as $file) : ?>
                        <li>
                            <a href="<?php echo esc_url($file['product_file']); ?>" download>
                                <?php echo esc_html($file['product_file_name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Рекомендуемые товары -->
        <?php if ($product_related_products) : ?>
            <div class="product__related">
                <h3>Рекомендуемые товары</h3>
                <div class="product__related-grid">
                    <?php foreach ($product_related_products as $related_id) : 
                        $related_title = get_the_title($related_id);
                        $related_link = get_permalink($related_id);
                        $related_image = get_field('product_image_id', $related_id);
                    ?>
                        <div class="product__related-item">
                            <a href="<?php echo esc_url($related_link); ?>">
                                <?php if ($related_image) : ?>
                                    <?php echo wp_get_attachment_image($related_image, 'thumbnail'); ?>
                                <?php endif; ?>
                                <h4><?php echo esc_html($related_title); ?></h4>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Сопутствующие товары (cross-sell) -->
        <?php if ($product_cross_sell) : ?>
            <div class="product__cross-sell">
                <h3>Сопутствующие товары</h3>
                <div class="product__cross-sell-grid">
                    <?php foreach ($product_cross_sell as $cross_id) : 
                        $cross_title = get_the_title($cross_id);
                        $cross_link = get_permalink($cross_id);
                        $cross_image = get_field('product_image_id', $cross_id);
                    ?>
                        <div class="product__cross-sell-item">
                            <a href="<?php echo esc_url($cross_link); ?>">
                                <?php if ($cross_image) : ?>
                                    <?php echo wp_get_attachment_image($cross_image, 'thumbnail'); ?>
                                <?php endif; ?>
                                <h4><?php echo esc_html($cross_title); ?></h4>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Более дорогие альтернативы (up-sell) -->
        <?php if ($product_up_sell) : ?>
            <div class="product__up-sell">
                <h3>Более дорогие альтернативы</h3>
                <div class="product__up-sell-grid">
                    <?php foreach ($product_up_sell as $up_id) : 
                        $up_title = get_the_title($up_id);
                        $up_link = get_permalink($up_id);
                        $up_image = get_field('product_image_id', $up_id);
                        $up_price = get_field('product_price', $up_id);
                    ?>
                        <div class="product__up-sell-item">
                            <a href="<?php echo esc_url($up_link); ?>">
                                <?php if ($up_image) : ?>
                                    <?php echo wp_get_attachment_image($up_image, 'thumbnail'); ?>
                                <?php endif; ?>
                                <h4><?php echo esc_html($up_title); ?></h4>
                                <?php if ($up_price) : ?>
                                    <div class="price"><?php echo $up_price; ?> ₽</div>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Контент (описание) товара -->
        <?php if (get_the_content()) : ?>
            <div class="product__description">
                <h3>Описание</h3>
                <div class="product__description-content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</section>
<!-- end product -->

<?php
get_footer();
?>