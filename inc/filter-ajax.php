<?php
/**
 * AJAX обработчики фильтрации товаров по атрибутам
 */

// AJAX: фильтрация товаров по атрибутам
add_action('wp_ajax_filter_products', 'ajax_filter_products_by_attributes');
add_action('wp_ajax_nopriv_filter_products', 'ajax_filter_products_by_attributes');

function ajax_filter_products_by_attributes() {
    // Проверка nonce для безопасности
    check_ajax_referer('filter_nonce', 'nonce');

    // Получаем параметры
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $attributes = isset($_POST['attributes']) ? $_POST['attributes'] : array(); // массив [group_slug => term_id]
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    if (!$category_id) {
        wp_send_json_error('Не указана категория');
    }

    // Формируем tax_query
    $tax_query = array('relation' => 'AND');

    // Условие по категории
    $tax_query[] = array(
        'taxonomy' => 'product_category',
        'field' => 'term_id',
        'terms' => $category_id,
    );

    // Условия по атрибутам
    foreach ($attributes as $group_slug => $term_id) {
        if (!empty($term_id)) {
            $tax_query[] = array(
                'taxonomy' => 'product_attr',
                'field' => 'term_id',
                'terms' => $term_id,
            );
        }
    }

    // Аргументы запроса
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $paged,
        'tax_query' => $tax_query,
    );

    $products_query = new WP_Query($args);

    // Буферизация вывода товаров
    ob_start();
    if ($products_query->have_posts()) :
        while ($products_query->have_posts()) : $products_query->the_post();
            get_template_part('template-parts/previews/preview', 'product');
        endwhile;
    else :
        custom_info('Товары не найдены');
    endif;
    $products_html = ob_get_clean();

    // Генерация пагинации
    $pagination_html = '';
    if ($products_query->max_num_pages > 1) {
        $big = 999999999;
        $pagination_html = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $products_query->max_num_pages,
            'prev_text' => '<i class="icon_arrow_left"></i>',
            'next_text' => '<i class="icon_arrow_right"></i>',
            'end_size' => 1,
            'mid_size' => 1,
            'type' => 'array',
        ));
        // Обернём в nav
        if (!empty($pagination_html)) {
            $pagination_html = implode('', $pagination_html);
        }
    }

    wp_reset_postdata();

    // Возвращаем JSON
    wp_send_json_success(array(
        'html' => $products_html,
        'pagination' => $pagination_html,
        'found_posts' => $products_query->found_posts,
        'max_num_pages' => $products_query->max_num_pages,
    ));
}