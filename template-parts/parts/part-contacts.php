<ul class="list">
    <?php if (get_field('address', 'option')) { ?>
        <li><span><?php the_field('address', 'option'); ?></span></li>
    <?php } ?>

    <?php if (get_field('mail', 'option')) { ?>
        <li>
            <a href="<?php echo esc_url( 'mailto:' . antispambot( get_field('mail', 'option') ) ); ?>"><?php echo esc_html( antispambot( get_field('mail','option' ) ) ); ?></a>
        </li>
    <?php } ?>

    <?php if (get_field('phone', 'option')) { ?>
        <li>
            <a href="tel:<?php echo preg_replace('/\s+/', '', get_field('phone', 'option')); ?>"><?php the_field('phone', 'option'); ?></a>
        </li>
    <?php } ?>
</ul>