<?php
$term = get_queried_object();
// get_pr($term);

$term_id = get_queried_object_id();

// Получаем родительскую категорию (если текущая - дочерняя)
$parent_term = null;
if ($term->parent != 0) {
    $parent_term = get_term($term->parent, 'product_category');
    $parent_id = $term->parent;
} else {
    $parent_id = $term_id;
}

// Получаем подкатегории (от родительской категории)
$child_categories = get_terms(array(
    'taxonomy' => 'product_category',
    'parent' => $parent_id,
    'hide_empty' => false,
    // 'orderby' => 'term_order',
    // 'order' => 'ASC',
));

// Проверяем, является ли текущая категория дочерней
$is_child_category = ($term->parent != 0);

?>

<?php get_template_part( 'template-parts/sections/section', 'head' ); ?>

<!-- Выводим все подкатегории и их товары -->
<?php if (!empty($child_categories) && !is_wp_error($child_categories)) : ?>

    <!-- begin subcategories -->
    <section id="subcategories" class="subcategories section">
        <div class="container_center">
            <div class="subcategories__content">
                <div class="subcategories__tabs">
                    <div class="tabs__wrapper">
                        <div class="tabs">
                            <?php foreach ($child_categories as $child_category) : 
                                // Определяем активный таб
                                $is_active = ($child_category->term_id == $term_id);
                            ?>
                                <a href="<?php echo get_term_link($child_category); ?>" class="tab <?php echo $is_active ? 'active' : ''; ?>">
                                    <?php echo $child_category->name; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end subcategories -->

<?php endif; ?>

<?php // get_template_part( 'template-parts/sections/section', 'taxGallery' ); ?>
<?php // get_template_part( 'template-parts/sections/section', 'taxInfo' ); ?>

<!-- Выводим товары -->
<?php
// Определяем ID категории для вывода товаров
$products_term_id = $term_id;

// Если есть подкатегории И текущая категория НЕ дочерняя - не показываем товары (показываем только подкатегории)
$show_products = true;
if (!empty($child_categories) && !$is_child_category) {
    $show_products = false;
}

if ($show_products) : ?>
    <section id="products" class="products section">
        <div class="container_center">
            <div class="products__content">
                <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_category',
                            'field' => 'term_id',
                            'terms' => $products_term_id,
                        ),
                    ),
                );
                
                $products_query = new WP_Query($args);
                
                if ($products_query->have_posts()) : ?>
                    <div class="product__grid">
                        <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                            <?php get_template_part('template-parts/previews/preview', 'product'); ?>
                        <?php endwhile; ?>
                    </div>
                <?php else : ?>
                    <?php custom_info('Товаров в этой категории нет'); ?>
                <?php endif;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>