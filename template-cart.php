<?php
/**
 * Template Name: Корзина товаров
 */

get_header();

$cart = get_user_cart();
$cart_items = array();

if (!empty($cart)) {
    $product_ids = array_keys($cart);
    $products_query = new WP_Query(array(
        'post_type' => 'product',
        'post__in' => $product_ids,
        'posts_per_page' => -1
    ));
    
    while ($products_query->have_posts()) {
        $products_query->the_post();
        $id = get_the_ID();
        if (isset($cart[$id])) {
            $cart_items[] = array(
                'id' => $id,
                'title' => get_the_title(),
                'price' => get_field('product_price', $id),
                'sku' => get_field('product_sku', $id),
                'quantity' => $cart[$id]['quantity'],
                'thumbnail' => get_the_post_thumbnail_url($id, 'thumbnail')
            );
        }
    }
    wp_reset_postdata();
}
?>

<!-- begin cart -->
<section id="cart" class="cart section">
    <div class="container_center">
        <h1 class="section__title ta_l"><?php the_title(); ?></h1>
        <div class="section__wrap">
            <?php if (empty($cart_items)) : ?>
                <div class="cart__empty">
                    <p>Ваша корзина пуста</p>
                    <a href="/" class="btn">Вернуться к покупкам</a>
                </div>
            <?php else : ?>
                <div id="cart-form" class="cart__form">
    
                    <table class="cart-table cart__table">
                        <thead>
                            <tr>
                                <th class="cart__thumbnail"></th>
                                <th class="cart__info"></th>
                                <th class="cart__price">Цена</th>
                                <th class="cart__quantity">Количество</th>
                                <th class="cart__subtotal">Сумма</th>
                                <th class="cart__remove"></th>
                            </tr>
                        </thead>
    
                        <tbody>
                            <?php foreach ($cart_items as $item) : ?>
                                <tr data-product-id="<?php echo $item['id']; ?>">
                                    <td class="cart__thumbnail" data-label="">
                                        <a href="<?php echo get_permalink($item['id']); ?>" target="_blank">
                                            <?php echo get_product_image_html($item['id'], 'thumbnail'); ?>
                                        </a>
                                    </td>
                                    <td class="cart__info" data-label="">
                                        <a class="product__title" href="<?php echo get_permalink($item['id']); ?>" target="_blank"><?php echo $item['title']; ?></a>
                                        <?php if ($item['sku']) : ?>
                                            <span class="product__sku">Артикул: <?php echo $item['sku']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="cart-price cart__price product__price" data-label="Цена"><?php echo format_price($item['price']); ?></td>
                                    <td class="cart-quantity cart__quantity" data-label="Количество">
                                        <?php the_cart_quantity_selector($item['id'], $item['quantity']); ?>
                                    </td>
                                    <td class="cart-subtotal cart__subtotal" data-label="Сумма"><?php echo format_price($item['price'] * $item['quantity']); ?></td>
                                    <td class="cart__remove" data-label="">
                                        <button type="button" class="remove-item" data-product-id="<?php echo $item['id']; ?>">×</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <div class="cart__total" id="cart-total">
                            Итого:
                            <?php 
                                $total = 0;
                                foreach ($cart_items as $item) {
                                    $total += $item['price'] * $item['quantity'];
                                }
                                echo format_price($total);
                            ?>
                        </div>
    

                    </table>
                    
                    <div class="cart__actions">
                        <button type="button" id="clear-cart" class="btn">Очистить корзину</button>
                        <button type="button" id="export-excel" class="btn btn_border">Скачать Excel</button>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
<!-- end cart -->


<!-- <style>
.cart-table {
    width: 100%;
    border-collapse: collapse;
}
.cart-table th, .cart-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
.cart-product {
    display: flex;
    align-items: center;
    gap: 15px;
}
.cart-product img {
    width: 80px;
    height: 80px;
    object-fit: cover;
}
.remove-item {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #ff4444;
}
.cart-actions {
    margin-top: 30px;
    display: flex;
    gap: 15px;
}

/* Стили для кастомного селектора количества в корзине */
.quantity-selector-cart {
    display: flex;
    align-items: center;
    gap: 5px;
}

.quantity-selector-cart .quantity-btn-cart {
    width: 30px;
    height: 30px;
    background: #f0f0f0;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.quantity-selector-cart .quantity-btn-cart:hover {
    background: #e0e0e0;
}

.quantity-selector-cart .quantity-input-cart {
    width: 60px;
    height: 30px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 0 5px;
}

/* Убираем стрелки у input number */
.quantity-input-cart::-webkit-inner-spin-button,
.quantity-input-cart::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-input-cart {
    -moz-appearance: textfield;
}
</style> -->

<?php get_footer(); ?>