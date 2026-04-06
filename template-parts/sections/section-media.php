<?php if (get_field('media_swiper_boolean')) { ?>
<!-- begin media -->
<section class="media media_swiper section" id="mediaSlider">
    <div class="container_center">
        <div class="media__layout">
            <?php 
            $slides = get_field('media_swiper_slides');
            if( $slides ) { ?>
                <div class="swiper media_swiper_js">
                    <div class="swiper-wrapper counter-wrap">
                        <?php foreach( $slides as $slide ) { ?>
                            <div class="swiper-slide counter-item">
                                <div class="media__thumbnail">
                                    <div class="media__img img"><?php echo wp_get_attachment_image($slide['media_swiper_slide_img_id'], 'medium'); ?></div>
                                    <div class="media__label">
                                        <span class="counter-el"> &mdash; <?php echo $slide['media_swiper_label']; ?></span>
                                        <p><?php echo $slide['media_swiper_subtite']; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-nav media__nav desktop">
                        <i class="swiper-arrow icon_arrow_left_sm"></i>
                        <i class="swiper-arrow icon_arrow_right_sm"></i>
                    </div>
                    <div class="swiper-pagination media__pagination"></div>
                </div>
            <?php } ?>

            <div class="media__content">
                <?php render_section_title('media_swiper_title', 'ta_l'); ?>
                <?php render_section_content('media_swiper_content', 'ta_l'); ?>
                <?php render_section_buttons('media_swiper_first_btn'); ?>
            </div>

        </div>
    </div>
</section>
<!-- end media -->
<?php } ?>