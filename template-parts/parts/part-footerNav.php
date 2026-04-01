<?php if (has_nav_menu('footer') || has_nav_menu('soc')) { ?>
    <div class="footer__col desktop">
        <nav class="footer__nav">
            <?php
                if (has_nav_menu('footer')) {
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class' => 'menu list underlineHover',
                        'container'=>'ul',
                        'depth' => 1,
                    )); 
                }
            ?>
            <?php 
                if (has_nav_menu('soc')) {
                    wp_nav_menu(array(
                        'theme_location' => 'soc',
                        'menu_class' => 'menu list underline',
                        'container'=>'ul',
                        'depth' => 1,
                    )); 
                }
            ?>
        </nav>
    </div>
<?php } ?>