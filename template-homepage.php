<?php
/**
 * Template name: Шаблон главной страницы
 */
?>

<?php get_header(); ?>

<?php // include 'sections.php'; ?>

<?php // echo get_template_directory_uri() . '/assets.' ?>

<?php // echo wp_get_attachment_image(the_field('test'), 'full'); ?>

<?php // render_section_title('section_title'); ?>
<?php // render_section_description('section_description'); ?>
<?php // render_section_content('section_content'); ?>
<?php // render_section_buttons('test_first_btn','test_second_btn'); ?>
<?php // ender_acf_link('test_first_btn'); ?>



<?php if (get_field('test')) { ?>
    <?php the_field('test'); ?>
<?php } ?>

<?php if (get_field('test', 'option')) { ?>
    <?php the_field('test', 'option'); ?>
<?php } ?>

<?php 
$rows = get_field('repeater_field_name');
if( $rows ) { ?>
    <?php foreach( $rows as $row ) { ?>
        <?php echo $row['caption']; ?>
    <?php } ?>
<?php } ?>

<?php if (get_field('test_button', 'option')) { ?>
    <?php 
        $link = get_field('test_button', 'option');
        $title = $link['title'];
        $url = $link['url'];
        $target = $link['target'];
    ?>
    <?php echo $url; ?>
    <?php if ($target) { echo 'target="_blank"'; } ?>
    <?php echo $title; ?>

<?php } ?>

<?php
    $no_img_url = get_template_directory_uri() . '/assets/img/no_img.webp' ;
    $image_id = get_field('test_img');
    $size = 'full'; // (thumbnail, medium, full, vertical, horizon)

    if( $image_id ) {
        $img_url = wp_get_attachment_image_url($image_id, $size);
    } else {
        $img_url = $no_img_url;
    }

?>


<?php if ( is_page_template(['template-homepage.php']) ) {

    // global $wp_query;
    // get_pr($wp_query); 
} ?>

<?php

get_template_part( 'template-parts/sections/section', 'firstscreen' );
// get_template_part( 'template-parts/sections/section', 'topCategories' );
get_template_part( 'template-parts/sections/section', 'partners' );
// get_template_part( 'template-parts/sections/section', 'homeProducts' );
get_template_part( 'template-parts/sections/section', 'media' );
get_template_part( 'template-parts/sections/section', 'hscroll' );
// get_template_part( 'template-parts/sections/section', 'banner' );


?>


<!-- geti -->
<?php // echo wp_get_attachment_image(SCF::get( 'test' ), 'full') ?>
    

<!-- getiu -->
<?php // echo wp_get_attachment_url(SCF::get( 'test' )) ?>

<!-- item -->
<?php // echo $item[''] ?>

<!-- eachimg -->
<?php // echo wp_get_attachment_image($item['tetst']) ?>
<?php // echo wp_get_attachment_url($item['test']) ?>


<?php get_footer(); ?>