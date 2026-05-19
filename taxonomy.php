<?php
/**
 * Шаблон таксономии (taxonomy.php)
 */

get_header();

$term = get_queried_object();
$taxonomy = $term->taxonomy;
$slug = $term->slug;
// get_pr($term);

// Получаем всех родителей текущей категории
$ancestors = get_ancestors($term->term_id, $taxonomy);
$is_vykladka_child = false;

// Проверяем, есть ли среди родителей категория vykladka
foreach ($ancestors as $parent_id) {
    $parent_term = get_term($parent_id, $taxonomy);
    if ($parent_term->slug === 'vykladka') {
        $is_vykladka_child = true;
        break;
    }
}

// Если это сама категория vykladka или её дочерняя
if ($slug === 'vykladka' || $is_vykladka_child) {
    get_template_part('template-parts/taxonomy/content', 'vykladka');
} else {
    get_template_part('template-parts/taxonomy/content', $taxonomy);
}

get_footer();