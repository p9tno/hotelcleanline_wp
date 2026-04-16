<?php
/**
 * Шаблон для меток продуктов
 */
?>


<?php 
get_template_part( 'template-parts/sections/section', 'head' ); 
?>

<main class="product-tag-page">
    <div class="container">
        
        <h1>Метка: <?php single_term_title(); ?></h1>
        
        <?php if (term_description()) : ?>
            <div class="tag-description"><?php echo term_description(); ?></div>
        <?php endif; ?>

        <?php
        $paged = get_query_var('paged') ?: 1;
        $products_query = new WP_Query(array(
            'post_type' => 'product',
            'posts_per_page' => 12,
            'paged' => $paged,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_tag',
                    'field' => 'term_id',
                    'terms' => get_queried_object_id(),
                ),
            ),
        ));

        if ($products_query->have_posts()) : ?>
            
            <div class="products-grid">
                <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                    <?php get_template_part('template-parts/product/card'); ?>
                <?php endwhile; ?>
            </div>

            <?php 
            echo paginate_links(array(
                'total' => $products_query->max_num_pages,
                'current' => $paged,
            ));
            ?>

        <?php else : ?>
            <p>Товаров с этой меткой не найдено.</p>
        <?php endif;
        wp_reset_postdata(); ?>
        
    </div>
</main>