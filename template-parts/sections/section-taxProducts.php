<!-- begin taxProducts -->
<section id="taxProducts" class="taxProducts section">
    <div class="container_center">
        <?php
        $current_term = get_queried_object();
        // get_pr($current_term);

        $paged = get_query_var('paged') ?: 1;
        $products_query = new WP_Query(array(
            'post_type' => 'product',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'tax_query' => array(
                array(
                    'taxonomy' => $current_term->taxonomy,
                    'field' => 'term_id',
                    'terms' => $current_term->term_id,
                ),
            ),
            'meta_query' => array(
                array(
                    'key' => 'product_status',
                    'value' => 'hidden',
                    'compare' => '!='
                )
            ),
        ));

        if ($products_query->have_posts()) : ?>
            
            <div class="product__grid">
                <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                    <?php get_template_part('template-parts/previews/preview', 'product'); ?>
                <?php endwhile; ?>
            </div>

            <?php the_paginate($products_query); ?>

        <?php else : ?>

            <?php custom_info(); ?>

        <?php endif;

        wp_reset_postdata(); ?>

    </div>
</section>
<!-- end taxProducts -->