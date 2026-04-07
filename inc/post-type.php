<?php
/**
 * Регистрация типа записи "Продукт" (product)
*/

// Отключаем Gutenberg для product
add_filter('use_block_editor_for_post_type', function($current_status, $post_type) {
    if ($post_type === 'product') {
        return false;
    }
    return $current_status;
}, 10, 2);

function register_product_post_type() {
    $labels = array(
        'name'               => 'Продукты',
        'singular_name'      => 'Продукт',
        'menu_name'          => 'Продукты',
        'name_admin_bar'     => 'Продукт',
        'add_new'            => 'Добавить новый',
        'add_new_item'       => 'Добавить новый продукт',
        'new_item'           => 'Новый продукт',
        'edit_item'          => 'Редактировать продукт',
        'view_item'          => 'Смотреть продукт',
        'all_items'          => 'Все продукты',
        'search_items'       => 'Искать продукты',
        'not_found'          => 'Продукты не найдены',
        'not_found_in_trash' => 'В корзине нет продуктов',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'show_in_rest'       => true,        // Включить поддержку Gutenberg
        'query_var'          => true,
        'rewrite'            => array(
            'slug'       => 'product',       // URL: site.com/product/название/
            'with_front' => false,
            'feeds'      => false,
            'pages'      => true
        ),
        'capability_type'    => 'post',
        // 'has_archive'        => 'products',   // URL архива: site.com/products/
        'has_archive'        => false,   // Отключаем архив
        'hierarchical'       => false,
        'menu_position'      => 20,           // Позиция в меню (20 - под страницами)
        'menu_icon'          => 'dashicons-cart', // Иконка в меню
        'supports'           => array(
            'title',
            // 'editor',
            'thumbnail',
            // 'excerpt',
            // 'comments',
            // 'revisions',
            // 'author',
            // 'page-attributes',
            // 'custom-fields'
        )
    );

    register_post_type( 'product', $args );
}
add_action( 'init', 'register_product_post_type' );

/**
 * Создание таксономии "Категории продуктов"
 */
function register_product_taxonomy() {
    $labels = array(
        'name'              => 'Категории продуктов',
        'singular_name'     => 'Категория продукта',
        'search_items'      => 'Искать категории',
        'all_items'         => 'Все категории',
        'parent_item'       => 'Родительская категория',
        'parent_item_colon' => 'Родительская категория:',
        'edit_item'         => 'Редактировать категорию',
        'update_item'       => 'Обновить категорию',
        'add_new_item'      => 'Добавить новую категорию',
        'new_item_name'     => 'Имя новой категории',
        'menu_name'         => 'Категории',
    );

    $args = array(
        'hierarchical'      => true,          // Как категории (с древовидной структурой)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,          // Поддержка Gutenberg
        'query_var'         => true,
        'rewrite'           => array(
            'slug'         => 'product-category',
            'with_front'   => false,
            'hierarchical' => true
        ),
    );

    register_taxonomy( 'product_category', 'product', $args );
}
add_action( 'init', 'register_product_taxonomy' );

/**
 * Создание таксономии "Метки продуктов"
 */
function register_product_tags() {
    $labels = array(
        'name'              => 'Метки продуктов',
        'singular_name'     => 'Метка продукта',
        'search_items'      => 'Искать метки',
        'all_items'         => 'Все метки',
        'edit_item'         => 'Редактировать метку',
        'update_item'       => 'Обновить метку',
        'add_new_item'      => 'Добавить новую метку',
        'new_item_name'     => 'Имя новой метки',
        'menu_name'         => 'Метки',
    );

    $args = array(
        'hierarchical'      => false,         // Как метки (без иерархии)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array(
            'slug'         => 'product-tag',
            'with_front'   => false
        ),
    );

    register_taxonomy( 'product_tag', 'product', $args );
}
add_action( 'init', 'register_product_tags' );

