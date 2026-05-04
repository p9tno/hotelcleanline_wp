<?php

$cart = get_user_cart();
$cart_items = array();

if (!empty($cart)) {
    $product_ids = array_keys($cart);
    $valid_products = array();
    $products_to_remove = array();
    
    // Проверяем каждый товар из корзины
    foreach ($product_ids as $id) {
        if (is_product_addable_to_cart($id)) {
            $valid_products[] = $id;
        } else {
            $products_to_remove[] = $id;
        }
    }
    
    // Удаляем невалидные товары
    foreach ($products_to_remove as $invalid_id) {
        remove_from_cart($invalid_id);
    }
    
    // Получаем обновленную корзину
    $updated_cart = get_user_cart();
    
    // Формируем массив для отображения
    foreach ($valid_products as $id) {
        if (isset($updated_cart[$id])) {
            $price = get_field('product_price', $id);
            
            // Дополнительная защита от некорректной цены
            if (!is_numeric($price) || $price < 0) {
                remove_from_cart($id);
                continue;
            }
            
            $cart_items[] = array(
                'id' => $id,
                'title' => get_the_title(),
                'price' => floatval($price),
                'sku' => get_field('product_sku', $id) ?: '',
                'quantity' => intval($updated_cart[$id]['quantity']),
                'thumbnail' => get_the_post_thumbnail_url($id, 'thumbnail')
            );
        }
    }
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
                                        <a class="product__title line_clamp" href="<?php echo get_permalink($item['id']); ?>" target="_blank"><?php echo get_the_title($item['id']); ?></a>
                                        <?php if ($item['sku']) : ?>
                                            <span class="product__sku">Артикул: <?php echo $item['sku']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="cart-price cart__price product__price" data-label="Цена"><?php echo format_price($item['price']); ?></td>
                                    <td class="cart-quantity cart__quantity" data-label="Количество">
                                        <?php the_cart_quantity_selector($item['id'], $item['quantity']); ?>
                                    </td>
                                    <td class="cart-subtotal cart__subtotal" data-label="Сумма">
                                        <?php 
                                        
                                            // echo format_price($item['price'] * $item['quantity']); 
                                            $subtotal = $item['price'] * $item['quantity'];
                                            echo format_price($subtotal);
                                            
                                        ?>
                                    </td>
                                    <td class="cart__remove" data-label="">
                                        <button type="button" class="remove-item" data-product-id="<?php echo $item['id']; ?>">×</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <div class="cart__total" id="cart-total">
                            
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