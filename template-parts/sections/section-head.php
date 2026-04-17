<?php
$term = get_queried_object();
// $term_id = get_queried_object_id();
$term_id = $term->term_id;
$term_taxonomy = $term->taxonomy;

if (is_tax()) {
    $taxonomy = get_taxonomy($term->taxonomy);
    
    if ($term_taxonomy && $taxonomy->hierarchical) {
        // echo 'Вы на иерархической таксономии (категория)';

        if ($term->parent > 0) {
            // echo ' - Это дочерняя категория';
        } else {
            // echo ' - Это родительская категория';
        }

    } else {
        // echo 'Вы на плоской таксономии (метка/дизайн/изделие)';
    }
} else {
    // echo 'Вы не на странице таксономии';
}
?>


<!-- begin head -->
<section id="head" class="head section">
    <div class="container_center">
        <div class="head__wrap">
            <div class="head__img img"><?php echo get_taxonomy_image_html($term_id, $term_taxonomy, 'large' ); ?></div>
            <div class="head__content glass_card">
                <h1 class="section__title ta_l"><?php echo esc_html(single_term_title('', false)); ?></h1>
                <?php if (term_description()) : ?>
                    <div class="section__desc ta_l"><?php echo wp_kses_post(term_description()); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- end head -->