<?php
get_header();
    echo '<p>archive.php</p>';
    
    get_template_part( 'template-parts/archive/content', get_post_type() );
get_footer();

