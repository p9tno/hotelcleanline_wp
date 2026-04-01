<footer class="footer">

    <?php if (get_field('footer_img', 'option')) { ?>
        <div class="footer__img img no_interaction">
            <?php echo wp_get_attachment_image(get_field('footer_img', 'option'), 'full'); ?>
        </div>
    <?php } ?> 

    <div class="footer__wrap parallax-wrap-js">
        <?php get_template_part( 'template-parts/parts/part', 'footerBG' ); ?>
        <div class="footer__content">
            <div class="footer__top">
                <div class="container_center">
                    <div class="footer__row">
                        <?php get_template_part( 'template-parts/parts/part', 'footerNav' ); ?>
                        <div class="footer__col">
                            <div class="footer__logo">
                                <img class="logo_quiz" loading="lazy" src="<?php echo get_template_directory_uri() . '/assets/img/logo.svg' ?>" alt="logo">
                            </div>
                            <?php // if (get_field('footer_logo', 'option')) { ?>
                                <?php // echo wp_get_attachment_image(get_field('footer_logo', 'option'), 'full'); ?>
                            <?php // } ?>
                            <?php get_template_part( 'template-parts/parts/part', 'nmls' ); ?>
                            <?php get_template_part( 'template-parts/parts/part', 'contactDetails' ); ?>
                        </div>
                        <?php get_template_part( 'template-parts/parts/part', 'footerForm' ); ?>
                    </div>
                </div>
            </div>
            <?php get_template_part( 'template-parts/parts/part', 'footerBottom' ); ?>
        </div>
    </div>
</footer>