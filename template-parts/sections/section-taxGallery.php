<?php
$term = get_queried_object();
$term_id = $term->term_id;
$taxonomy_prefix = 'product_category_' . $term_id;
?>

<?php if (have_rows('product_category_gallery', $taxonomy_prefix)) : ?>
    <!-- begin taxGallery -->
    <section id="taxGallery" class="taxGallery section">
        <div class="container_center">
            <div class="section__wrap">
                <div class="taxGallery__grid">
                    <?php while (have_rows('product_category_gallery', $taxonomy_prefix)) : the_row();
                        $image_id = get_sub_field('gallery_img_id');
                    ?>
                        <div class="taxGallery__item img">
                            <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- end taxGallery -->
<?php endif; ?>
