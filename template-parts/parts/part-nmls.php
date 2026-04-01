<?php if (get_field('nmls_logo', 'option') || get_field('nmls_text', 'option')) { ?>
    <div class="footer__nmls">
        <?php if (get_field('nmls_logo', 'option')) { ?>
            <div class="footer__nmls_logo">
                <?php echo wp_get_attachment_image(get_field('nmls_logo', 'option'), 'full'); ?>
            </div>
        <?php } ?>
        <?php if (get_field('nmls_text', 'option')) { ?>
            <span><?php the_field('nmls_text', 'option'); ?></span>
        <?php } ?>
    </div>
<?php } ?>