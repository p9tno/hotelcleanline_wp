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

<div class="blog__item">
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
    <div class="blog__title"><?php the_max_charlength(40, 'title') ?></div>
    <div class="blog__excerpt"><p><?php the_max_charlength(135); ?></p></div>
    <a class="blog__btn" href="<?php the_permalink(); ?>">
        <span>More</span><i class="icon_arrow_right"></i>
    </a>
</div>