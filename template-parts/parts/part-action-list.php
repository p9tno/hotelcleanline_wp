<?php
// Файл: part-action-list.php
$default_args = array(
    'custom_class' => ''
);
$args = wp_parse_args( $args, $default_args );
?>

<ul class="action list <?php echo esc_attr( $args['custom_class'] ); ?>">
    <li> <a href="#"><i class="icon_man"> </i></a></li>
    <li> <a href="#"><i class="icon_loupe"> </i></a></li>
    <li> <a href="#"><i class="icon_heart"> </i></a></li>
    <li> <a href="#"><i class="icon_cart"> </i></a></li>
</ul>