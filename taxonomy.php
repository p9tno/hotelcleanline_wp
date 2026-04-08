<?php
/**
 * Шаблон таксономии (taxonomy.php)
 */

get_header();

$term = get_queried_object();
$taxonomy = $term->taxonomy;
// get_pr($term);

get_template_part('template-parts/taxonomy/content', $taxonomy);

get_footer();