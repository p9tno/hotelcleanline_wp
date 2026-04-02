<?php
/**
 * Карточка товара
 */
?>

<div class="product-card">
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="product-image">
            <?php the_post_thumbnail('medium'); ?>
        </a>
    <?php endif; ?>
    
    <h3 class="product-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
    
    <?php 
    $price = get_field('product_price');
    if ($price) : ?>
        <div class="product-price"><?php echo $price; ?> ₽</div>
    <?php endif; ?>
    
    <a href="<?php the_permalink(); ?>" class="btn btn-sm">Подробнее</a>
</div>