<?php 
$cart_total = get_cart_total_items();
?>        
        
<a href="<?php echo esc_url(home_url('/cart/')); ?>">
    <i class="icon_cart"></i>
    <span class="cart-count" style="<?php echo $cart_total > 0 ? '' : 'display: none;'; ?>">
        <?php echo $cart_total; ?>
    </span>
</a>