<div class="swiper-slide">
    <div class="team__item">
        <div class="team__top">
            <div class="team__img img"><?php echo wp_get_attachment_image(get_field('employees_pt_img_id'), 'full'); ?></div>
        </div>
        <div class="team__bottom">
            <?php if (get_field('employees_pt_name')) { ?>
                <div class="team__name"><?php the_field('employees_pt_name'); ?></div>
            <?php } ?>
            <?php if (get_field('employees_pt_status')) { ?>
                <div class="team__status"><?php the_field('employees_pt_status'); ?></div>
            <?php } ?>
            <div class="team__action">
                <?php if (get_field('employees_pt_phone')) { ?>
                    <a class="team__direct" href="tel:<?php echo preg_replace('/\s+/', '', get_field('employees_pt_phone')); ?>" target="_blank">
                        Direct:<?php the_field('employees_pt_phone'); ?>
                    </a>
                <?php } ?>
                <?php if (get_field('employees_pt_phone_2')) { ?>
                    <a class="team__direct" href="tel:<?php echo preg_replace('/\s+/', '', get_field('employees_pt_phone_2')); ?>" target="_blank">
                        Cell:<?php the_field('employees_pt_phone_2'); ?>
                    </a>
                <?php } ?>
                <?php if (get_field('employees_pt_email')) { ?>
                    <a class="team__email" href="mailto:<?php the_field('employees_pt_email'); ?>"><?php the_field('employees_pt_email'); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>