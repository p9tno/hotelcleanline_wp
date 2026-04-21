<?php


// Получаем ID текущего товара
$product_id = get_queried_object_id();

// Получаем все ACF поля
// $product_image_id = get_field('product_image_id');
$no_img_url = get_template_directory_uri() . '/assets/img/no_img.webp';
$no_img = '<img src="'.$no_img_url.'" alt="нет изображения" loading="lazy" />';

$product_gallery = get_field('product_gallery');
$product_price = get_field('product_price');
$product_sku = get_field('product_sku');
$product_status = get_field('product_status');
$product_content = get_field('product_content');
$product_characteristic = get_field('product_characteristic');


// Извлекаем значение и label статуса
$status_value = $product_status['value'] ?? 'instock';      // 'instock', 'outofstock', 'hidden'
$status_label = $product_status['label'] ?? 'В наличии';    // 'В наличии', 'Нет в наличии', 'скрыт'

// Для CSS-класса используем значение (instock/outofstock/hidden)
$status_class = $status_value;


// $product_bundle = get_field('product_bundle');
// $product_related_products = get_field('product_related_products');
// $product_cross_sell = get_field('product_cross_sell');
// $product_up_sell = get_field('product_up_sell');
// $product_files = get_field('product_files');

// Получаем категории товара
$product_categories = wp_get_object_terms($product_id, 'product_category');
// Получаем метки товара
$product_tags = wp_get_object_terms($product_id, 'product_tag');
?>


<?php

// get_pr(get_product_data($product_id));
?>

<!-- begin slProduct -->
<section id="slProduct-<?php echo esc_attr($product_id); ?>" class="slProduct section <?php echo esc_attr($status_class); ?>">
    <div class="container_center">
        <div class="slProduct__head">
            <div class="slProduct__left">
                <div class="slProduct__img no_interaction">
                    <?php // echo get_product_image_html($product_id); ?>
                    <!-- Основное изображение -->
                    <?php if ( has_post_thumbnail() ) { ?>
                        <?php the_post_thumbnail( 'medium' ); ?>
                    <?php } else { ?>
                        <?php echo $no_img; ?> 
                    <?php } ?>
                </div>

                <!-- <div class="slProduct__thumb"></div> -->

                <!-- Метки -->
                <?php if ($product_tags && !is_wp_error($product_tags)) : ?>
                    <div class="slProduct__tags">
                        <?php foreach ($product_tags as $tag) : ?>
                            <a href="<?php echo get_term_link($tag); ?>">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="slProduct__right">
                
                <div class="slProduct__row">
                    <h1 class="section__title ta_l"><?php the_title(); ?></h1>
                </div>

                <?php if ($product_price) : ?>
                    <div class="slProduct__row">
                        <div class="product__price">
                            <strong>Цена: </strong><?php the_product_price(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="slProduct__row">
                    <?php if ($product_sku) : ?>
                        <div class="slProduct__col">
                            <div class="product__sku">
                                <strong>Артикул:</strong> <?php echo esc_html($product_sku); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($product_status) : ?>
                        <div class="slProduct__col">
                            <div class="product__status"><?php echo esc_html($status_label); ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="slProduct__row">
                    <div class="product__button">
                        <button disabled class="btn">Купить</button>
                    </div>
                </div>

                <?php if ($product_characteristic) { ?>
                    <div class="slProduct__characteristic">
                        <?php echo wp_kses_post($product_characteristic); ?>
                    </div>
                <?php } ?> 
                
            </div>
        </div>


        <?php if ($product_content) { ?>
            <div class="section__wrap">
                <div class="section__content ta_l">
                    <?php echo wp_kses_post($product_content); ?>
                </div>
            </div>
        <?php } ?> 

    </div>
</section>
<!-- end slProduct -->