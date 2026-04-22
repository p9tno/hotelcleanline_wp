<?php
// Файл: part-action-list.php
$default_args = array(
    'custom_class' => ''
);
$args = wp_parse_args( $args, $default_args );


$cart_total = get_cart_total_items();
?>

<ul class="action list <?php echo esc_attr( $args['custom_class'] ); ?>">
    <!-- <li> <a href="#"><i class="icon_man"> </i></a></li>
    <li> <a href="#"><i class="icon_loupe"> </i></a></li>
    <li> <a href="#"><i class="icon_heart"> </i></a></li> -->
    <li><?php get_template_part( 'template-parts/parts/part', 'icon-cart' ); ?></li>
</ul>