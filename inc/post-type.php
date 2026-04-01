<?php
function custom_register_post_type() {

    // START NEWS
    register_post_type('news', array(
		'labels'             => array(
			'name'               => 'Новости', 
			'singular_name'      => 'Новость', 
			'add_new'            => 'Добавить новость',
			'add_new_item'       => 'Добавить новую новость',
			'edit_item'          => 'Редактировать новость',
			'new_item'           => 'Новая новость',
			'view_item'          => 'Посмотреть новость',
			'menu_name'          => 'Новости'
		  ),
		'public'     => true,
		'supports'   => array('title'),
        'menu_icon'  => 'dashicons-id-alt',
        'show_ui' => true, 
        'menu_position' => 7,
		'rewrite'    => [
			'with_front' => false
		]
	));
    // END NEWS

    // START apartment

    $labels = array(
    'name'              => ( 'Комнаты' ),
    'singular_name'     => ( 'Комната' ),
    'search_items'      => ( 'Поиск по комнатам' ),
    'all_items'         => ( 'Все комнаты' ),
    'edit_item'         => ( 'Редактировать комнату' ),
    'update_item'       => ( 'Обновить' ),
    'add_new_item'      => ( 'Добавить' ),
    'new_item_name'     => ( 'Название новой комнаты' ),
    'menu_name'         => ( 'Комнаты' ),
    );

    $args = array(
        //вложеность термов(например вложность для стран и городов) иерархический
        'hierarchical'	=> true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        // 'rewrite'           => array( 'slug' => 'portfolio-cat' ),
        'rewrite'           => true,
        // 'show_in_rest'      => true,
        
    );

    if (!taxonomy_exists( 'apartment-room' )) {
        register_taxonomy('apartment-room', array('apartment'), $args);
    }
    unset($args);
    unset($labels);
    // очищаем $args

    register_post_type('apartment', array(
		'labels'             => array(
			'name'               => 'Апартаменты', 
			'singular_name'      => 'Апартаменты', 
			'add_new'            => 'Добавить новые',
			'add_new_item'       => 'Добавить новые апартаменты',
			'edit_item'          => 'Редактировать апартаменты',
			'new_item'           => 'Новые апартаменты',
			'view_item'          => 'Посмотреть апартаменты',
			'menu_name'          => 'Апартаменты', 
		  ),
		'public'     => true,
		'supports'   => array('title'),
        'menu_icon'  => 'dashicons-admin-home',
        'show_ui' => true, 
        'menu_position' => 5,
		'rewrite'    => [
			'with_front' => false
		]
	));
    // END apartment<?php
function custom_register_post_type() {

    // START apartment

    $labels = array(
    'name'              => ( 'Комнаты' ),
    'singular_name'     => ( 'Комната' ),
    'search_items'      => ( 'Поиск по комнатам' ),
    'all_items'         => ( 'Все комнаты' ),
    'edit_item'         => ( 'Редактировать комнату' ),
    'update_item'       => ( 'Обновить' ),
    'add_new_item'      => ( 'Добавить' ),
    'new_item_name'     => ( 'Название новой комнаты' ),
    'menu_name'         => ( 'Комнаты' ),
    );

    $args = array(
        //вложеность термов(например вложность для стран и городов) иерархический
        'hierarchical'	=> true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        // 'rewrite'           => array( 'slug' => 'portfolio-cat' ),
        'rewrite'           => true,
        // 'show_in_rest'      => true,
        
    );

    if (!taxonomy_exists( 'apartment-room' )) {
        register_taxonomy('apartment-room', array('apartment'), $args);
    }
 
    register_post_type('apartment', array(
		'labels'             => array(
			'name'               => 'Апартаменты', 
			'singular_name'      => 'Апартаменты', 
			'add_new'            => 'Добавить новые',
			'add_new_item'       => 'Добавить новые апартаменты',
			'edit_item'          => 'Редактировать апартаменты',
			'new_item'           => 'Новые апартаменты',
			'view_item'          => 'Посмотреть апартаменты',
			'menu_name'          => 'Апартаменты', 
		  ),
		'public'     => true,
		'supports'   => array('title'),
        'menu_icon'  => 'dashicons-admin-home',
        'show_ui' => true, 
        'menu_position' => 5,
		'rewrite'    => [
			'with_front' => false
		]
	));
    // END apartment

    // очищаем $args
    unset($args);
    unset($labels);

    //START raboty
    $labels = array(
        'name'              => ( 'Услуга' ),
        'singular_name'     => ( 'Услуга' ),
        'search_items'      => ( 'Поиск по услугам' ),
        'all_items'         => ( 'Все услуги' ),
        'parent_item'       => ( 'Родительская услуга' ),
        'parent_item_colon' => ( 'Родительская услуга:' ),
        'edit_item'         => ( 'Редактировать услугу' ),
        'update_item'       => ( 'Обновить услугу' ),
        'add_new_item'      => ( 'Добавить новую услугу' ),
        'new_item_name'     => ( 'Название новой услуги' ),
        'menu_name'         => ( 'Услуга' ),
    );

    $args = array(
        //вложеность термов(например вложность для стран и городов) иерархический
        'hierarchical'	=> true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'usluga' ),
        
    );

    if (!taxonomy_exists( 'usluga' )) {
        register_taxonomy('usluga', array('raboty'), $args);
    }
    
    // очищаем $args
    unset($args);

    $labels = array(
        'name'                  => ( 'Работы' ),
        'singular_name'         => ( 'Работы' ),
        'menu_name'             => ( 'Работы' ),
        'name_admin_bar'        => ( 'Работы' ),
        'add_new'               => ( 'Добавить' ),
        'add_new_item'          => ( 'Добавить' ),
        'new_item'              => ( 'Новый проект'),
        'edit_item'             => ( 'Редактировать' ),
        'view_item'             => ( 'Вид' ),
        'all_items'             => ( 'Все' ),
        'search_items'          => ( 'Поиск' ),
        'parent_item_colon'     => ( 'Родитель:' ),
        'not_found'             => ( 'не наден.'),
        'not_found_in_trash'    => ( 'В корзине не обнаружен.' ),
        'featured_image'        => ( 'Изображение на обложке' ),
        'set_featured_image'    => ( 'Установить обложку' ),
        'remove_featured_image' => ( 'Удалить изображение обложки' ),
        'use_featured_image'    => ( 'Использовать как обложку' ),
        'archives'              => ( 'Архивы' ),
        'insert_into_item'      => ( 'Вставить' ),
        'uploaded_to_this_item' => ( 'Загружено' ),
        'filter_items_list'     => ( 'Список фильтров' ),
        'items_list_navigation' => ( 'по списку навигации' ),
        'items_list'            => ( 'Список' ),   
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'raboty' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title' ),
        'menu_icon'			 => 'dashicons-hammer',
        'show_in_rest'       => true,
    );

    register_post_type( 'raboty', $args );
    // очищаем $args $labels
    unset($args);
    unset($labels);


    //END raboty


   
}
 
add_action( 'init', 'custom_register_post_type' );

//обновления ЧПУ после инициализации post type
function my_template_rewrite_rules(){
    my_template_rewrite_rukes();
    flush_rewrite_rules();
}

add_action('after_switch_theme', 'my_template_rewrite_rules');




   
}
 
add_action( 'init', 'custom_register_post_type' );

//обновления ЧПУ после инициализации post type
function my_template_rewrite_rules(){
    my_template_rewrite_rukes();
    flush_rewrite_rules();
}

add_action('after_switch_theme', 'my_template_rewrite_rules');

