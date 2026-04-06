<?php if (get_field('hscroll_boolean')) { ?>
<!-- begin hscroll -->
<section class="hscroll section" id="hscroll">
    <div class="hscroll__head">
        <?php render_section_title('hscroll_title'); ?>
    </div>
    <div class="hscroll__content">
        <div class="swiper hscroll_swiper_js">
            <div class="swiper-wrapper">
                <?php for ($slide = 1; $slide <= 4; $slide++) : ?>
                    <div class="swiper-slide no_interaction">
                        <?php for ($i = 1; $i <= 9; $i++) : ?>
                            <div class="hscroll__img img">
                                <?php 
                                $field_name = 'hscroll_img_id_' . $i;
                                $image_id = get_field($field_name);
                                if ($image_id) {
                                    echo wp_get_attachment_image($image_id, 'medium');
                                }
                                ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
<!-- end hscroll -->
<?php } ?>