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
        <div class="cart-page">
            <div class="container">
                <h1>Корзина товаров</h1>
                
                <?php if (empty($cart_items)) : ?>
                    <div class="cart-empty">
                        <p>Ваша корзина пуста</p>
                        <a href="/" class="btn">Вернуться к покупкам</a>
                    </div>
                <?php else : ?>
                    <form id="cart-form">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $item) : ?>
                                    <tr data-product-id="<?php echo $item['id']; ?>">
                                        <td class="cart-product">
                                            <?php if ($item['thumbnail']) : ?>
                                                <img src="<?php echo $item['thumbnail']; ?>" alt="<?php echo $item['title']; ?>">
                                            <?php endif; ?>
                                            <div>
                                                <a href="<?php echo get_permalink($item['id']); ?>"><?php echo $item['title']; ?></a>
                                                <?php if ($item['sku']) : ?>
                                                    <small>Артикул: <?php echo $item['sku']; ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        </td>
                                        <td class="cart-price"><?php echo format_price($item['price']); ?></td>

                                        <td class="cart-quantity">
                                             <?php 
                                                // Используем новую функцию для корзины
                                                the_cart_quantity_selector($item['id'], $item['quantity']);
                                                ?>
                                        </td>


                                        <td class="cart-subtotal"><?php echo format_price($item['price'] * $item['quantity']); ?></td>
                                        <td class="cart-remove">
                                            <button type="button" class="remove-item" data-product-id="<?php echo $item['id']; ?>">×</button>
                                        </td>
                                        </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="cart-total-label">Итого:</td>
                                    <td class="cart-total" id="cart-total">
                                        <?php 
                                        $total = 0;
                                        foreach ($cart_items as $item) {
                                            $total += $item['price'] * $item['quantity'];
                                        }
                                        echo format_price($total);
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <div class="cart-actions">
                            <button type="button" id="clear-cart" class="btn btn-outline">Очистить корзину</button>
                            <button type="button" id="export-excel" class="btn btn-primary">Скачать Excel</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- end cart -->


<style>
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
</style>

<?php get_footer(); ?>