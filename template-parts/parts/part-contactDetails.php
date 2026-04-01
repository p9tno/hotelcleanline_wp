
<?php if (
    get_field('phone', 'option') ||
    get_field('phone_2', 'option') ||
    get_field('address', 'option') ||
    get_field('mail', 'option')
    
) { ?>
    <div class="contactDetails">
        <?php if (get_field('phone', 'option') || get_field('phone_2', 'option')) { ?>
            <div class="contactDetails__row">
                <?php if (get_field('phone', 'option')) { ?>
                    <a href="tel:<?php echo preg_replace('/\s+/', '', get_field('phone', 'option')); ?>" target="_blank"><?php the_field('phone', 'option'); ?></a>
                <?php } ?>
                <?php if (get_field('phone_2', 'option')) { ?>
                    <a href="tel:<?php echo preg_replace('/\s+/', '', get_field('phone_2', 'option')); ?>" target="_blank"><?php the_field('phone_2', 'option'); ?></a>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if (get_field('address', 'option')) { ?>
            <div class="contactDetails__row"> 
                <p><?php the_field('address', 'option'); ?></p>
            </div>
        <?php } ?>

        <?php if (get_field('mail', 'option')) { ?>
            <div class="contactDetails__row">
                <a class="mail" href="mailto:<?php the_field('mail', 'option'); ?>"><?php the_field('mail', 'option'); ?></a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
