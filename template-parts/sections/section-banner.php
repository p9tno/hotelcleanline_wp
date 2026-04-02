<?php 

$slides = get_field('banner_slides');

if (get_field('banner_boolean') && $slides) { ?>
    <!-- begin banner -->
    <section class="banner section" id="banner">
        <div class="container_center">
            <div class="banner__swiper">
                <div class="swiper banner_swiper_js">
                    <div class="swiper-wrapper">
                        <?php foreach( $slides as $slide ) { ?>
                            <div class="swiper-slide banner__slide">
                                <div class="banner__img img">
                                    <?php echo wp_get_attachment_image($slide['banner_img_id'], 'full'); ?>
                                </div>
                                <div class="banner__content">
                                    <h2 class="banner__title ta_l"><?php echo $slide['banner_title']; ?></h2>
                                    <div class="banner__desc ta_l"><?php echo $slide['banner_desc']; ?></div>
                                    <?php if ($slide['banner_btn']) { ?>
                                        <?php 
                                            $link = $slide['banner_btn'];
                                            $title = $link['title'];
                                            $url = $link['url'];
                                            $target = $link['target'];
                                        ?>
                                        <div class="section__btns ta_l">
                                            <a 
                                                class="btn" 
                                                href="<?php echo $url; ?>" 
                                                <?php if ($target) { echo 'target="_blank"'; } ?>
                                            >
                                                <?php echo $title; ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="swiper-nav banner__nav desktop">
                        <i class="swiper-arrow icon_arrow_left_sm"></i>
                        <i class="swiper-arrow icon_arrow_right_sm"></i>
                    </div>
                </div>
                <div class="swiper-pagination banner__pagination mobile"></div>
            </div>
        </div>
    </section>
    <!-- end banner -->
<?php } ?>