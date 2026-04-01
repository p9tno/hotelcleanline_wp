<!-- begin blog-->
<section class="pageContent section" id="pageContent-<?php the_ID(); ?>">
    <div class="container_center">
        <h1 class="section__title ta_l"><?php the_title(); ?></h1>
		
		<div class="section__wrap">
			<?php if (has_post_thumbnail()) { ?>
				<div class="pageContent__thumbnail">
					<div class="pageContent__img img">
						<?php the_post_thumbnail(); ?>
					</div>
				</div>
			<?php } ?>
			<div class="pageContent__date"><span><?php the_date('M j, Y'); ?></span></div>
			<div class="section__content ta_l"><?php the_content(); ?></div>
		</div>
    </div>
</section>
<!-- end blog-->