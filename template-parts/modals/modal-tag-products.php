<!-- begin Modal tag-products -->
<div class="modal fade tag-products" id="tag-products">
    <div class="modal-dialog">
        <div class="modal-content">
            <a href="#" class="modal-close" data-dismiss="modal"></a>

            <div class="modal-header">
                <div class="modal-title" id="myModalLabel">Амстердам</div>
            </div>

            <div class="modal-body scrolled">
                <div class="product__grid">
                    <?php
               
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
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

                </div>
                 
                
            </div>
       
        </div>
    </div>
</div>
<!-- end Modal tag-products -->