<?php 
$slides = get_field('list_firstscreen');
if( $slides && get_field('firstscreen_boolean') ) { ?>
    <!-- begin firstscreen-->
    <section class="firstscreen section" id="firstscreen">
        <div class="firstscreen__swiper">
            <div class="swiper firstscreen_swiper_js">
                <div class="swiper-wrapper">
                    <?php foreach( $slides as $slide ) { ?>
                        <div class="swiper-slide">
                            <div class="firstscreen__slide">
                                <div class="firstscreen__img img"><?php echo wp_get_attachment_image($slide['firstscreen_img_id'], 'large'); ?></div>
                                <div class="firstscreen__content glass_card">
                                    <?php if ($slide['firstscreen_title']) { ?>
                                        <h2 class="firstscreen__title"><?php echo  $slide['firstscreen_title']; ?></h2>
                                    <?php } ?>
                                    <?php if ($slide['firstscreen_desc']) { ?>
                                        <div class="firstscreen__desc">
                                            <p><?php echo  $slide['firstscreen_desc']; ?></p>
                                        </div>
                                    <?php } ?>

                                    <?php if ($slide['firstscreen_link']) { ?>
                                        <?php 
                                            $link = $slide['firstscreen_link'];
                                            $title = $link['title'];
                                            $url = $link['url'];
                                            $target = $link['target'];
                                        ?>
                                        <div class="firstscreen__btn">
                                            <a class="btn" href="<?php echo $url; ?>" <?php if ($target) { echo 'target="_blank"'; } ?>><?php echo $title; ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="swiper-pagination firstscreen__pagination"></div>

                <div class="swiper-nav firstscreen__nav">
                    <i class="swiper-arrow icon_arrow_left_sm"></i>
                    <i class="swiper-arrow icon_arrow_right_sm"></i>
                </div>

            </div>
        </div>
    </section>
    <!-- end firstscreen-->
<?php } ?>
