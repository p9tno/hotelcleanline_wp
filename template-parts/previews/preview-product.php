<?php
    $product = get_post( get_the_ID() );
    $product_ID = $product->ID;
?>

<div class="product" id="product-<?php echo $product_ID; ?>">
    <div class="product__header">
        <a class="product__img img" href="<?php the_permalink(); ?>">
            <?php echo get_product_image_html($product_ID); ?>
        </a>
    </div>
    <div class="product__body product_padding">
        <a class="product__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </div>
    <div class="product__footer product_padding">
        <div class="product__price"><?php the_product_price(); ?></div>
        <div class="product__button">
            <!-- Только кнопка (количество = min из ACF) -->
            <?php the_add_to_cart_button($product_ID); ?>

            <!-- Блок с количеством (параметры из ACF) -->
            <?php // the_quantity_selector($product_ID); ?>

            <!-- Полный блок (количество + кнопка) -->
            <?php // the_full_add_to_cart($product_ID, array('show_quantity' => true)); ?>
            <!-- <button class="btn btn-add-to-cart" data-product-id="<?php // echo $product_ID; ?>">
                <span>Купить</span>
                <i class="icon_basket"></i>
            </button> -->
        </div>
    </div>
</div>