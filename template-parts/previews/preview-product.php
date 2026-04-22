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
            <?php the_full_add_to_cart($product_ID, array('show_quantity' => false)); ?>
        </div>
    </div>
</div>