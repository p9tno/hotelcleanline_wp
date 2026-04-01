<?php
$post = get_post( get_the_ID() );
$post_ID = $post->ID;
$category = get_the_terms($post_ID, 'blog-cat');

if ( has_post_thumbnail() ) {
    $img = get_the_post_thumbnail( get_the_ID(), 'full', array( 'loading' => 'lazy' ) );
} else {
    $img_url = get_template_directory_uri() . '/assets/img/no_img.png';
    $img = '<img src="' . $img_url . '" alt="' . get_the_title() . '" loading="lazy" />';
}
?>

<!-- begin blog-->
<section class="blog section" id="blog-<?php the_ID(); ?>">
    <div class="container_center">

        <h1 class="section__title"><?php the_title(); ?></h1>
        
        <div class="blog__layout">
            <div class="blog__content">
                
                <div class="blog__thumbnail">
                    <div class="blog__img img"><?php echo $img; ?></div>
                    <?php if ($category) { ?>
                        <ul class="blog__categories list">
                            <?php foreach($category as $cat) { ?>
                            <li><span>#<?php echo $cat->name; ?></span></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>

                <div class="blog__date"><span><?php the_date('M j, Y'); ?></span></div>

                <div class="section__content">
                    <?php the_content(); ?>
                    <?php get_template_part( 'template-parts/parts/part', 'share' ); ?>

                </div>

            </div>

            <aside class="aside blog__aside">
                <?php get_template_part( 'template-parts/parts/part', 'aside-items' ); ?>
            </aside>

        </div>
    </div>
</section>
<!-- end blog-->

<!-- begin related-->
<section class="blog blog__related section" id="related">
    <div class="blog__swiper">
        <div class="container_center">
            <div class="section__title">Related Posts</div>
            <div class="swiper blog_swiper_js">
                <div class="swiper-wrapper">
                    <?php
                        $args = array(
                            'post_type' => 'blog',
                            'posts_per_page' => -1,
                            'orderby' => 'rand',
                            'post__not_in' => array(get_the_ID()),
                        );
                        $query = new WP_Query($args);
                    ?>

                    <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="swiper-slide">
                            <?php get_template_part( 'template-parts/previews/preview', 'blog' ); ?>
                        </div>
                    <?php endwhile; ?>

                    <?php else : ?>
                    <p>No found</p>
                    <?php endif; ?>

                    <?php wp_reset_postdata(); ?>


                </div>

                <div class="swiper-pagination blog_pagination_js mobile"></div>
                <div class="swiper-nav blog__nav desktop">
                    <i class="swiper-arrow icon_arrow_left"></i>
                    <i class="swiper-arrow icon_arrow_right"></i>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end related-->