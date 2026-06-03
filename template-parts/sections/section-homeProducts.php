<?php 
$sections = get_field('homeProducts_sections');
// get_pr($sections);
if( $sections ) { ?>
    <?php foreach( $sections as $section ) { ?>
        <!-- begin homeProducts <?php echo $section['homeProducts_id']; ?> -->
        <section class="homeProducts section" id="<?php echo $section['homeProducts_id']; ?>">
            <div class="container_center">

                <?php if (!empty($section['homeProducts_title'])): ?>
                    <h2 class="section__title"><?php echo esc_html($section['homeProducts_title']); ?></h2>
                <?php endif; ?>

                <?php // if (!empty($section['homeProducts_desc'])): ?>
                    <!-- <div class="section__desc"><?php // echo wp_kses_post($section['homeProducts_desc']); ?></div> -->
                <?php // endif; ?>
    
                <div class="section__wrap">
                    <div class="product__grid product__grid_mini">
    
                        <?php
                        $post_id = $section['homeProducts_relationship'];
    
                        // Проверяем, есть ли данные и не пустой ли массив
                        if (empty($post_id)) {
                            custom_info('! Товары не выбраны');
                        } else {
                            // Преобразуем в массив, если это одиночное значение
                            if (!is_array($post_id)) {
                                $post_id = array($post_id);
                            }
                            
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'post__in' => $post_id,
                                'orderby' => 'post__in',
                                'meta_query' => array(
                                    array(
                                        'key' => 'product_status',
                                        'value' => 'hidden',
                                        'compare' => '!='
                                    )
                                ),
                            );
                            $query = new WP_Query($args);
                            ?>
                            
                            <?php if ($query->have_posts()) : ?>
                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <?php get_template_part('template-parts/previews/preview', 'product-mini'); ?>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            <?php else : ?>
                                <?php custom_info('! Товары не выбраны'); ?>
                            <?php endif; ?>
                        <?php } ?>
    
                    </div>
                </div>
            </div>
        </section>
        <!-- end homeProducts <?php echo $section['homeProducts_id']; ?> -->
    <?php } ?>
<?php } ?>
