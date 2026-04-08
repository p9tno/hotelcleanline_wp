<?php if (get_field('homeProducts_boolean')) { ?>
    <!-- begin homeProducts -->
    <section class="homeProducts section" id="homeProducts">
        <div class="container_center">
            <?php render_section_title('homeProducts_title'); ?>
            <?php render_section_description('homeProducts_desc'); ?>

            <div class="section__wrap">
                <div class="product__grid">

                    <?php
                    $post_id = get_field('homeProducts_relationship');

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
                            'posts_per_page' => 9,
                            'post__in' => $post_id,
                            'orderby' => 'post__in',
                        );
                        $query = new WP_Query($args);
                        ?>
                        
                        <?php if ($query->have_posts()) : ?>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <?php get_template_part('template-parts/previews/preview', 'product'); ?>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php else : ?>
                            <?php custom_info('! Товары не выбраны'); ?>
                        <?php endif; ?>
                    <?php } ?>

                </div>
            </div>
            <?php render_section_buttons('homeProducts_first_btn','homeProducts_second_btn'); ?>
        </div>
    </section>
    <!-- end homeProducts -->
<?php } ?>