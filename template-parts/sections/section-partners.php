<?php 
$slides = get_field('partners_slides');
// get_pr($slides);
?>
<?php if (get_field('partners_boolean') && $slides) { ?>
<!-- begin partners -->
<section class="partners section" id="partners">
    <div class="container_center">
        <div class="partners__content">
            <?php render_section_title('partners_title'); ?>
            <?php render_section_description('partners_desc'); ?>
            <div class="partners__swiper">
                <div class="swiper partners_swiper_js">
                    <div class="swiper-wrapper">
                        <?php foreach( $slides as $slide ) { ?>
                            <div class="swiper-slide partners__slide">
                                <div class="partners__img img">
                                    <?php echo wp_get_attachment_image($slide['partners_slide_img_id'], 'medium') ?>
                                </div>
                                <div class="partners__caption">
                                    <div class="partners__title"><?php echo  $slide['partners_slide_title']; ?></div>
                                    <div class="partners__desc"><?php echo  $slide['partners_slide_desc']; ?></div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="swiper-pagination partners__pagination"></div>
                </div>
            </div>
            <?php render_section_buttons('partners_first_btn','partners_second_btn'); ?>
        </div>
    </div>
</section>
<!-- end partners -->
    
<?php } ?>