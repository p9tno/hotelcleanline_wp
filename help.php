<?php
// Базовое использование:
// Для цены продукта
$price = get_field('product_price', get_the_ID());
if ($price) {
    echo format_price_with_currency($price);
    // Результат: 1000 ₽ (или ₽ 1000, или 1,000₽ и т.д.)
}
?>



<!-- В цикле продуктов: -->
<?php
$price = get_field('product_price');
if ($price): ?>
    <div class="product-price">
        <?php echo format_price_with_currency($price); ?>
    </div>
<?php endif; ?>

<!-- Сокращённый вариант (как the_title()): -->
<?php the_price(get_field('product_price')); ?>


<!-- В HTML с дополнительным форматированием: -->
 <div class="price">
    <span class="price-value"><?php echo format_price_with_currency(2990); ?></span>
    <?php if ($old_price): ?>
        <span class="price-old"><?php echo format_price_with_currency($old_price); ?></span>
        <span class="price-discount">-<?php echo round(($old_price - $price) / $old_price * 100); ?>%</span>
    <?php endif; ?>
</div>

<!-- Получить только символ валюты: -->
<?php echo get_currency_symbol(); // Выведет: ₽ ?>




<!-- Пример настройки в админке:
После добавления кода в админке появится новая вкладка «Валюта» в настройках контента, где можно настроить:

Поле	Значение
Символ валюты	₽, $, € или свой
Позиция	После цены (100 ₽)
Разделитель тысяч	Пробел (1 000)
Разделитель копеек	Точка (100.50)
Количество знаков	0 (без копеек)


Результат работы функции:
Цена	Настройки	Результат
1000	₽, после, пробел, 0	1000 ₽
1000	₽, перед, пробел, 0	₽ 1000
1000.50	₽, после, запятая, 2	1,000.50₽
1000	$, после, точка, 0	1.000$
1000	€, после пробел, пробел, 0	1 000 € -->