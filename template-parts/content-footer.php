<footer class="footer">
    <div class="footer__content">

        <?php if (get_field('footer_img', 'option')) { ?>
            <div class="footer__row">
                <a class="footer__logo" href="<?php echo esc_url(home_url("/")); ?>">
                    <?php echo wp_get_attachment_image(get_field('footer_img', 'option'), 'full'); ?>
                </a>
            </div>
        <?php } ?> 


        <div class="footer__row">

            <div class="footer__links">
                <a href="#">Москва, ул. Ленина, 123</a>
                <a href="#">Телефон: +(123) 456 - 7890</a>
                <a href="#">Email: test@select-themes.com</a>
            </div>

            <div class="footer__soc">
                <?php get_template_part( 'template-parts/parts/part', 'soc' ); ?>
            </div>
        </div>
    </div>
</footer>