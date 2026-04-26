<header class="header">
    <div class="header__content">
        <div class="header__row">
            <?php if (get_field('logo_img', 'option')) { ?>
                <div class="header__col logo">
                    <a href="<?php echo esc_url(home_url("/")); ?>">
                        <?php echo wp_get_attachment_image(get_field('logo_img', 'option'), 'full'); ?>
                    </a>
                </div>
            <?php } ?> 

            <div class="header__col nav">
                <nav class="navbar" id="navbar">
                    <?php 
                        wp_nav_menu(array(
                            'theme_location' => 'header',
                            'container'=>'ul',
                        )); 
                    ?>
                    <?php // get_template_part( 'template-parts/parts/part', 'action-list', array('custom_class' => 'mobile') ); ?>
                </nav>
            </div>

            <div class="header__col">
                <?php get_template_part( 'template-parts/parts/part', 'action-list' ); ?>
            </div>

            <div class="header__toggle"></div>
        </div>
    </div>
</header>