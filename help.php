<!-- 1. В цикле (самый простой способ) -->
<?php while ( have_posts() ) : the_post(); ?>
    <div class="product-card">
        <h3><?php the_title(); ?></h3>
        
        <!-- Самое простое использование -->
        <div class="price">
            <?php the_product_price(); ?>
        </div>
        
        <!-- С явным указанием ID -->
        <div class="price">
            <?php the_product_price(get_the_ID()); ?>
        </div>
    </div>
<?php endwhile; ?>

<!-- 2. С проверкой наличия цены -->
<div class="product-card">
    <h3><?php the_title(); ?></h3>
    
    <?php if (get_product_price()) : ?>
        <div class="price">
            <?php the_product_price(); ?>
        </div>
    <?php else : ?>
        <div class="price price-na">
            Цена не указана
        </div>
    <?php endif; ?>
</div>

<!-- 3. Со старой ценой (скидка) -->
<?php 
$current_price = get_product_price();
$old_price = get_field('product_old_price'); // другое поле для старой цены
?>

<div class="product-card">
    <h3><?php the_title(); ?></h3>
    
    <?php if ($old_price && $old_price > $current_price) : ?>
        <div class="price-block">
            <span class="price-old"><?php echo format_price($old_price); ?></span>
            <span class="price-sale"><?php the_product_price(); ?></span>
        </div>
    <?php else : ?>
        <div class="price-block">
            <?php the_product_price(); ?>
        </div>
    <?php endif; ?>
</div>

<!-- 4. В произвольном месте (не в цикле) -->
<?php 
// Если нужно вывести цену конкретного товара по ID
$product_id = 123;
the_product_price($product_id);
?>

<!-- 5. Для расчетов -->
<?php 
$price = get_product_price(); // Получаем число для расчетов
$price_with_tax = $price * 1.2; // Добавляем НДС 20%

echo 'Цена без НДС: ' . format_price($price) . '<br>';
echo 'Цена с НДС: ' . format_price($price_with_tax);
?>