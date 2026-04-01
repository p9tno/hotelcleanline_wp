<!-- onclick="Share.instagram('<?php // the_permalink(); ?>')"  -->

<div class="share">
    <div class="share__title">Share This</div>
    <ul>
        <li>
            <a 
                onclick="Share.facebook('<?php the_permalink(); ?>','<?php the_title(); ?>','','')"
                rel="nofollow"
            >
                <i class="icon_share_facebook"></i>
            </a>
        </li>

        <li>
            <a 
                onclick="Share.twitter('<?php the_permalink(); ?>','<?php the_title(); ?>')"
                rel="nofollow"
            >
                <i class="icon_share_twitter"></i>
            </a>
        </li>

        <li>
            <a 
                onclick="Share.linkedin('<?php the_permalink(); ?>','<?php the_title(); ?>','')"
                rel="nofollow"
            >
                <i class="icon_share_linkedin"></i>
            </a>
        </li>

        <li>
            <a 
                onclick="Share.email('<?php the_permalink(); ?>','<?php the_title(); ?>','')"
                rel="nofollow"
            >
                <i class="icon_share_email"></i>
            </a>
        </li>
    </ul>
</div>