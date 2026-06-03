<?php
    $product = get_post( get_the_ID() );
    $product_ID = $product->ID;
?>

<a href="<?php the_permalink(); ?>" class="productMini" id="product-mini-<?php echo $product_ID; ?>">
    <div class="productMini__img img">
        <?php echo get_product_image_html($product_ID); ?>
    </div>
    <div class="productMini__content glass_card">
        <div class="productMini__title"><?php the_title(); ?></div>
    </div>
</a>