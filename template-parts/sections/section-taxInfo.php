<?php
$term = get_queried_object();
$term_id = $term->term_id;
$taxonomy_prefix = 'product_category_' . $term_id;
?>

<?php if (have_rows('product_category_info', $taxonomy_prefix)) : ?>
    <!-- begin taxInfo -->
    <section id="taxInfo" class="taxInfo section">
        <div class="container_center">
            <div class="section__wrap">
                <div class="taxInfo__grid">
                    <?php while (have_rows('product_category_info', $taxonomy_prefix)) : the_row();
                        $info_image_id = get_sub_field('category_info_img_id');
                        $info_content = get_sub_field('category_info_content');
                    ?>
                        <div class="itaxInfo__item">
                            <?php if ($info_image_id) : ?>
                                <div class="taxInfo__img img">
                                    <?php echo wp_get_attachment_image($info_image_id, 'medium'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($info_content) : ?>
                                <div class="section__content ta_l">
                                    <?php echo wp_kses_post($info_content); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>

            </div>
        </div>
    </section>
    <!-- end taxInfo -->
<?php endif; ?>