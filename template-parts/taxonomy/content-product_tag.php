<?php
/**
 * Шаблон для меток продуктов
 */
?>


<?php 
get_template_part( 'template-parts/sections/section', 'head' ); 
?>

<!-- begin tagProducts -->
<section id="tagProducts" class="tagProducts section">
    <div class="container_center">
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
            
            <div class="product__grid">
                <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                    <?php get_template_part('template-parts/previews/preview', 'product'); ?>
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
</section>
<!-- end tagProducts -->




        
 
        
