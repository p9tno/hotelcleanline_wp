<ul class="soc list">
    <?php if (get_field('instagram', 'option')) { ?>  
        <li class="soc__item">
            <a class="soc__link" href="<?php echo esc_attr( get_field('instagram', 'option') ); ?>" target="_blank"><i class="soc__icon icon_instagram"></i></a>
        </li>
    <?php } ?>

    <?php if (get_field('youtube', 'option')) { ?>  
        <li class="soc__item">
            <a class="soc__link" href="<?php echo esc_attr( get_field('youtube', 'option') ); ?>" target="_blank"><i class="soc__icon icon_youtube"></i></a>
        </li>
    <?php } ?>

    <?php if (get_field('twitter', 'option')) { ?>  
        <li class="soc__item">
            <a class="soc__link" href="<?php echo esc_attr( get_field('twitter', 'option') ); ?>" target="_blank"><i class="soc__icon icon_twitter"></i></a>
        </li>
    <?php } ?>
</ul>