<?php if (has_nav_menu('footer-bottom')) { ?>

    <div class="footer__bottom">
        <div class="container_center">
            <?php
            
                wp_nav_menu(array(
                    'theme_location' => 'footer-bottom',
                    'menu_class' => 'menu list underline',
                    'container'=>'ul',
                    'depth' => 1,
                )); 
                
            ?>
        </div>
    </div>
<?php } ?>
