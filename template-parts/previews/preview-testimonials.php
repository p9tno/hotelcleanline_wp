<?php if (get_field('testimonials_pt_short_video_id')) { ?>
    <div class="swiper-slide">
        <div class="testimonials__video video">
            <video 
                class="video__teg" 
                width="100%" 
                allowfullscreen="true" 
                muted="muted"
                autoplay="autoplay" 
                playsinline="playsinline" 
                loop="loop"
                poster="<?php echo wp_get_attachment_image_src(get_field('testimonials_pt_poster_id'), 'full')[0]; ?>"
            >
                <source src="<?php echo wp_get_attachment_url(get_field('testimonials_pt_short_video_id')); ?>" type="video/mp4" />
            </video>

            <?php if (get_field('testimonials_pt_video_id')) { ?>
                <a 
                    class="videoModal_js video__btn" 
                    href="#modalVideo"
                    data-src="<?php echo wp_get_attachment_url(get_field('testimonials_pt_video_id')); ?>"
                    data-poster="<?php echo wp_get_attachment_image_src(get_field('testimonials_pt_poster_id'), 'full')[0]; ?>"
                >
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z" /></svg>
                </a>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <div class="swiper-slide">
        <div class="testimonials__slide">
            <?php if (get_field('testimonials_pt_content')) { ?>
                <div class="section__content"><?php the_field('testimonials_pt_content'); ?></div>
            <?php } ?>
            <?php if (get_field('testimonials_pt_text')) { ?>
                <div class="testimonials__name"><?php the_field('testimonials_pt_text'); ?></div>
            <?php } ?>
        </div>
    </div>
<?php } ?>



