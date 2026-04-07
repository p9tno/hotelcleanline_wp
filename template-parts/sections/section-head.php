<?php
$term_id = get_queried_object_id();

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