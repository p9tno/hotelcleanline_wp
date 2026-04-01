<header class="header">
    <div class="header__content">
        <?php if (get_field('header_logo', 'option')) { ?>
            <div class="header__logo">
                <a href="<?php echo esc_url(home_url("/")); ?>">
                    <?php get_template_part( 'template-parts/parts/part', 'logo-main' ); ?>
                    <img class="logo_quiz" loading="lazy" src="<?php echo get_template_directory_uri() . '/assets/img/logo_quiz.svg' ?>" alt="logo">

                    <?php // echo wp_get_attachment_image(get_field('header_logo', 'option'), 'full', false, ['class' => 'logo_main']); ?>
                    <?php // echo wp_get_attachment_image(get_field('header_logo_quiz', 'option'), 'full', false, ['class' => 'logo_quiz']); ?>
                </a>
            </div>
        <?php } ?>    

        <div class="header__toggle"><span>Menu</span><i></i></div>

        <div class="header__nav">

            <nav class="navbar" id="navbar">
                <?php if (has_nav_menu('header')) { ?>
                    <div class="navbar__item">
                        <?php 
                            wp_nav_menu(array(
                                'theme_location' => 'header',
                                'container'=>'ul',
                            )); 
                        ?>
                        </ul>
                    </div>
                <?php } ?>

                <?php if (has_nav_menu('soc')) { ?>
                    <div class="navbar__item mobile">
                        <?php 
                            wp_nav_menu(array(
                                'theme_location' => 'soc',
                                'menu_class' => 'menu list underline',
                                'container'=>'ul',
                                'depth' => 1,
                            )); 
                        ?>
                    </div>
                <?php } ?>

                <div class="navbar__item mobile">
                    <?php get_template_part( 'template-parts/parts/part', 'contactDetails' ); ?>
                </div>

                <?php if (get_field('header_btn', 'option')) { ?>
                    <?php 
                        $link = get_field('header_btn', 'option');
                        $title = $link['title'];
                        $url = $link['url'];
                        $target = $link['target'];
                    ?>
                    <div class="navbar__item mobile">
                        <a class="btn btn_sm btn_light" href="<?php echo $url; ?>" <?php if ($target) { echo 'target="_blank"'; } ?>><?php echo $title; ?></a>
                    </div>
                <?php } ?>
            </nav>

        </div>

        <?php if (get_field('header_btn', 'option')) { ?>
            <?php 
                $link = get_field('header_btn', 'option');
                $title = $link['title'];
                $url = $link['url'];
                $target = $link['target'];
            ?>
            <div class="header__btn desktop">
                <a class="btn btn_sm btn_light" href="<?php echo $url; ?>" <?php if ($target) { echo 'target="_blank"'; } ?>><?php echo $title; ?></a>
            </div>
        <?php } ?>

    </div>
</header>
