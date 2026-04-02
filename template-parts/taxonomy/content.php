<?php
/**
 * Общий шаблон для остальных таксономий
 */
?>

<main class="taxonomy-page">
    <div class="container">
        
        <h1><?php single_term_title(); ?></h1>
        
        <?php if (term_description()) : ?>
            <div class="term-description"><?php echo term_description(); ?></div>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', get_post_type()); ?>
            <?php endwhile; ?>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p>Записей не найдено.</p>
        <?php endif; ?>
        
    </div>
</main>