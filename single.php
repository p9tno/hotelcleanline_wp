<?php
get_header();

	while ( have_posts() ) : the_post();
		
		get_template_part( 'template-parts/single/content', get_post_type() );

	endwhile; 

get_footer();

