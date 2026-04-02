<?php
/**
 * Шаблон для категорий продуктов (с табами подкатегорий)
 */

$term_id = get_queried_object_id();
$no_img_url = get_template_directory_uri() . '/assets/img/no_cat.webp';

?>

<!-- begin head -->
<section id="head" class="head section">
    <div class="container_center">
        <div class="head__wrap">
            <div class="head__img img">
                <?php echo get_product_category_image_html($term_id, 'full'); ?>
            </div>
            <div class="head__content">
                <h1 class="section__title"><?php single_term_title(); ?></h1>
                <?php if (term_description()) : ?>
                    <div class="section__desc"><?php echo term_description(); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- end head -->

<?php
// Получаем подкатегории
$child_categories = get_terms(array(
    'taxonomy' => 'product_category',
    'parent' => $term_id,
    'hide_empty' => false,
    'orderby' => 'term_order',
    'order' => 'ASC',
));

// Если есть подкатегории, показываем секцию с табами
if (!empty($child_categories) && !is_wp_error($child_categories)) : ?>

<!-- begin subcategories -->
<section id="subcategories" class="subcategories section">
    <div class="container_center">
        <div class="subcategories__content">

            <div class="subcategories__tabs">
                <div class="tabs__wrapper">
                    
                    <!-- Заголовки табов (подкатегории) -->
                    <div class="tabs">
                        <?php foreach ($child_categories as $child) : ?>
                            <div class="tab">
                                <?php echo esc_html($child->name); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Контент табов (товары подкатегорий) -->
                    <div class="tabs__content">
                        <?php foreach ($child_categories as $child) : 
                            // Запрос товаров для текущей подкатегории
                            $products_query = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_category',
                                        'field' => 'term_id',
                                        'terms' => $child->term_id,
                                        'include_children' => true,
                                    ),
                                ),
                            ));
                        ?>
                            <div class="tab__item">
                                <?php if ($products_query->have_posts()) : ?>
                                    <div class="products-grid">
                                        <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                                            <?php get_template_part('template-parts/product/card'); ?>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else : ?>
                                    <div class="no-products">
                                        <p>В этой подкатегории пока нет товаров.</p>
                                    </div>
                                <?php endif;
                                wp_reset_postdata(); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- end subcategories -->

<?php else : 
    // Если нет подкатегорий, показываем товары текущей категории
    $products_query = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => 12,
        'paged' => get_query_var('paged') ?: 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_category',
                'field' => 'term_id',
                'terms' => $term_id,
                'include_children' => true,
            ),
        ),
    ));
    
    if ($products_query->have_posts()) : ?>
        
        <!-- begin products -->
        <section id="products" class="products section">
            <div class="container_center">
                <h2 class="section__title">Товары</h2>
                <div class="products-grid">
                    <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                        <?php get_template_part('template-parts/product/card'); ?>
                    <?php endwhile; ?>
                </div>
                
                <?php 
                echo paginate_links(array(
                    'total' => $products_query->max_num_pages,
                    'current' => get_query_var('paged') ?: 1,
                ));
                ?>
            </div>
        </section>
        <!-- end products -->
        
    <?php else : ?>
        
        <div class="no-products">
            <p>В этой категории пока нет товаров.</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">Вернуться на главную</a>
        </div>
        
    <?php endif;
    wp_reset_postdata();
endif; ?>