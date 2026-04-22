<?php
if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.10' );
}

function hotelcleanline_scripts() {
	// if ( is_page_template(['template-homepage.php']) ) {}
	// if( is_archive() ) {}

	wp_enqueue_style( 'hotelcleanline-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_style('hotelcleanline-aos', get_template_directory_uri() . '/assets/css/aos.css', array(), _S_VERSION, 'all');
	wp_enqueue_style('hotelcleanline-fancybox', get_template_directory_uri() . '/assets/css/fancybox.min.css', array(), _S_VERSION, 'all');
	wp_enqueue_style('hotelcleanline-swiper-bundle.min', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', array(), _S_VERSION, 'all');
    wp_enqueue_style('hotelcleanline-toast', get_template_directory_uri() . '/assets/css/toast.css', array(), _S_VERSION, 'all');
	wp_enqueue_style('hotelcleanline-main-style', get_template_directory_uri() . '/assets/css/style.css', array(), _S_VERSION, 'all');

	wp_deregister_script( 'jquery' ); //разрегистирируем скрипт jquery
    wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.js', array(), false, true);
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'hotelcleanline-toast', get_template_directory_uri() . '/assets/js/toast.js', array(), _S_VERSION, false );

	wp_enqueue_script( 'hotelcleanline-aos', get_template_directory_uri() . '/assets/js/aos.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'hotelcleanline-fancybox', get_template_directory_uri() . '/assets/js/fancybox.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'hotelcleanline-modal', get_template_directory_uri() . '/assets/js/modal.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'hotelcleanline-swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'hotelcleanline-swiper-init', get_template_directory_uri() . '/assets/js/swiper-bundle-init.js', array(), _S_VERSION, true );

    wp_enqueue_script('cart-ajax', get_template_directory_uri() . '/assets/js/cart.js', array('jquery'), '1.0', true);
    wp_localize_script('cart-ajax', 'cart_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('cart_nonce'),
        'cart_url' => home_url('/cart/')
    ));

	wp_enqueue_script( 'hotelcleanline-function', get_template_directory_uri() . '/assets/js/function.js', array(), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'hotelcleanline_scripts' );

// function admin_styles_scripts() {
// 	wp_enqueue_style("hotelcleanline-admin-css", get_template_directory_uri() . '/assets/css/wp-admin.css');
// 	wp_enqueue_script("hotelcleanline-admin-js", get_template_directory_uri() . '/assets/js/wp-admin.js');
// }
// add_action('admin_enqueue_scripts', 'admin_styles_scripts');


function hotelcleanline_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	// add_image_size( 'custom-lg', 900, 600, true);
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	register_nav_menus(
		array(
			'header' => esc_html__( 'header', 'hotelcleanline' ),
			// 'footer' => esc_html__( 'footer', 'hotelcleanline' ),
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'hotelcleanline_setup' );

function hotelcleanline_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hotelcleanline_content_width', 640 );
}
add_action( 'after_setup_theme', 'hotelcleanline_content_width', 0 );


//Разрешаем загрузку WebP
function webp_upload_mimes( $existing_mimes ) {
    // add webp to the list of mime types
    $existing_mimes['webp'] = 'image/webp';

    // return the array back to the function with our added mime type
    return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );  
function delete_intermediate_image_sizes( $sizes ){
    // размеры которые нужно удалить
    return array_diff( $sizes, [
        // 'thumbnail',
        // 'medium',
        'medium_large',
        // 'large',
        '1536x1536',
        '2048x2048',
    ] );
}

//скрываем пункты меню в админ панели
add_action('admin_menu', 'remove_menus');
function remove_menus() {
    //remove_menu_page('index.php');                # Консоль 
    remove_menu_page('edit.php');                 # Записи 
    remove_menu_page('edit-comments.php');        # Комментарии 
    //remove_menu_page('edit.php?post_type=page');  # Страницы 
    //remove_menu_page('upload.php');               # Медиафайлы 
    //remove_menu_page('themes.php');               # Внешний вид 
    //remove_menu_page('plugins.php');              # Плагины 
    // remove_menu_page('users.php');                # Пользователи 
    // remove_menu_page('tools.php');                # Инструменты 
    //remove_menu_page('options-general.php');      # Параметры 
    remove_menu_page('edit.php?post_type=acf-field-group'); # ACF smart-custom-fields
}

// Отключаем принудительную проверку новых версий WP, плагинов и темы в админке,
require get_template_directory() . '/inc/disable-verification.php';
require get_template_directory() . '/inc/utilities.php';
require get_template_directory() . '/inc/acf-options.php';
require get_template_directory() . '/inc/breadcrumb.php';
require get_template_directory() . '/inc/post-type.php';
require get_template_directory() . '/inc/currency.php';
// require get_template_directory() . '/inc/filter.php';


/**
 * Полное отключение комментариев
 */
function complete_disable_comments() {
    // 1. Отключаем поддержку комментариев для всех типов записей
    $post_types = ['post', 'page', 'product'];
    foreach ($post_types as $post_type) {
        remove_post_type_support($post_type, 'comments');
        remove_post_type_support($post_type, 'trackbacks');
    }
    
    // 2. Отключаем RSS ленту комментариев
    add_filter('feed_links_show_comments_feed', '__return_false');
    
    // 3. Перенаправляем запросы к комментариям на главную
    add_action('template_redirect', function() {
        if (is_comment_feed() || is_single() && (comments_open() || get_comments_number())) {
            wp_redirect(home_url('/'), 301);
            exit;
        }
    });
}
add_action('init', 'complete_disable_comments', 100);


/**
 * Фильтр для kama_breadcrumbs: выбираем самую глубокую категорию
 * Игнорируем родительскую категорию, если есть дочерняя
 */
add_filter('kama_breadcrumbs_term', function($term, $taxonomies = null){
    global $post;
    
    // Применяем только для типа записи 'product' и таксономии 'product_category'
    if( is_singular('product') && $post && isset($term->taxonomy) && $term->taxonomy === 'product_category' ){
        
        // Получаем ВСЕ категории товара
        $all_terms = get_the_terms($post->ID, 'product_category');
        
        if( $all_terms && ! is_wp_error($all_terms) && count($all_terms) > 1 ){
            
            // Разделяем категории на корневые (parent=0) и дочерние (parent>0)
            $root_terms = [];
            $child_terms = [];
            
            foreach( $all_terms as $t ){
                if( $t->parent == 0 ){
                    $root_terms[] = $t;
                } else {
                    $child_terms[] = $t;
                }
            }
            
            // Если есть дочерние категории — выбираем первую из них
            if( ! empty($child_terms) ){
                // Сортируем дочерние по глубине (чем больше parent, тем глубже)
                usort($child_terms, function($a, $b){
                    return $b->parent - $a->parent;
                });
                
                return $child_terms[0]; // возвращаем самую глубокую
            }
        }
    }
    
    return $term;
}, 10, 2);

/**
 * КОРЗИНА ДЛЯ ТОВАРОВ
 * Хранение в wp_options с привязкой к сессии/кукам
 */

// Запуск сессии для неавторизованных пользователей
add_action('init', 'cart_start_session');
function cart_start_session() {
    if (!session_id() && !is_admin()) {
        session_start();
    }
}

// Получить ID текущей корзины (сессия + куки)
function get_cart_session_id() {
    $cookie_name = 'cart_session_id';
    
    if (isset($_COOKIE[$cookie_name])) {
        return sanitize_text_field($_COOKIE[$cookie_name]);
    }
    
    // Генерируем новый ID
    $session_id = uniqid('cart_', true);
    setcookie($cookie_name, $session_id, time() + 2592000, '/'); // 30 дней
    return $session_id;
}

// Получить корзину пользователя
function get_user_cart() {
    $session_id = get_cart_session_id();
    $cart = get_option('cart_' . $session_id, array());
    
    // Фильтруем несуществующие товары
    if (!empty($cart)) {
        foreach ($cart as $product_id => $item) {
            if (get_post_status($product_id) !== 'publish') {
                unset($cart[$product_id]);
            }
        }
    }
    
    return $cart;
}

// Сохранить корзину
function save_user_cart($cart) {
    $session_id = get_cart_session_id();
    update_option('cart_' . $session_id, $cart, false);
    
    // Опционально: удаляем старые корзины (раз в день)
    if (rand(1, 100) === 1) {
        cart_cleanup_old_carts();
    }
}

// Очистка корзин старше 30 дней
function cart_cleanup_old_carts() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'cart_%' AND option_value = ''");
    // Более точную очистку добавим позже
}

// Добавить товар в корзину
function add_to_cart($product_id, $quantity = 1) {
    $cart = get_user_cart();
    $product_id = intval($product_id);
    $quantity = max(1, intval($quantity));
    
    if (isset($cart[$product_id])) {
        $cart[$product_id]['quantity'] += $quantity;
    } else {
        $cart[$product_id] = array(
            'id' => $product_id,
            'quantity' => $quantity,
            'added_at' => current_time('timestamp')
        );
    }
    
    save_user_cart($cart);
    return count($cart);
}

// Удалить товар из корзины
function remove_from_cart($product_id) {
    $cart = get_user_cart();
    $product_id = intval($product_id);
    
    if (isset($cart[$product_id])) {
        unset($cart[$product_id]);
        save_user_cart($cart);
    }
    
    return $cart;
}

// Обновить количества в корзине
function update_cart_quantities($items) {
    $cart = array();
    
    foreach ($items as $product_id => $quantity) {
        $product_id = intval($product_id);
        $quantity = max(0, intval($quantity));
        
        if ($quantity > 0 && get_post_status($product_id) === 'publish') {
            $cart[$product_id] = array(
                'id' => $product_id,
                'quantity' => $quantity,
                'added_at' => current_time('timestamp')
            );
        }
    }
    
    save_user_cart($cart);
    return $cart;
}

// Очистить корзину полностью
function clear_cart() {
    $session_id = get_cart_session_id();
    delete_option('cart_' . $session_id);
    return array();
}

// Получить количество уникальных товаров в корзине (количество позиций)
function get_cart_total_items() {
    $cart = get_user_cart();
    return count($cart); // возвращаем количество уникальных товаров
}

// Подсветка иконки корзины (для демонстрации)
add_action('wp_footer', function() {
    if (is_admin()) return;
    $total = get_cart_total_items();
    if ($total > 0) {
        echo "<script>if(window.updateCartBadge) window.updateCartBadge({$total});</script>";
    }
});


// AJAX: добавить товар
add_action('wp_ajax_add_to_cart', 'ajax_add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'ajax_add_to_cart');

function ajax_add_to_cart() {
    check_ajax_referer('cart_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if (!$product_id || get_post_status($product_id) !== 'publish') {
        wp_send_json_error('Товар не найден');
    }
    
    add_to_cart($product_id, $quantity);
    $total_items = get_cart_total_items(); // количество уникальных товаров
    
    wp_send_json_success(array(
        'message' => 'Товар добавлен в корзину',
        'total_items' => $total_items,
        'cart_url' => home_url('/cart/')
    ));
}

// AJAX: удалить товар
add_action('wp_ajax_remove_from_cart', 'ajax_remove_from_cart');
add_action('wp_ajax_nopriv_remove_from_cart', 'ajax_remove_from_cart');

function ajax_remove_from_cart() {
    check_ajax_referer('cart_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    remove_from_cart($product_id);
    $total_items = get_cart_total_items(); // количество уникальных товаров
    
    wp_send_json_success(array(
        'message' => 'Товар удалён',
        'total_items' => $total_items
    ));
}

// AJAX: обновить корзину
add_action('wp_ajax_update_cart', 'ajax_update_cart');
add_action('wp_ajax_nopriv_update_cart', 'ajax_update_cart');


// AJAX: очистить корзину
add_action('wp_ajax_clear_cart', 'ajax_clear_cart');
add_action('wp_ajax_nopriv_clear_cart', 'ajax_clear_cart');

function ajax_clear_cart() {
    check_ajax_referer('cart_nonce', 'nonce');
    
    clear_cart();
    
    wp_send_json_success(array(
        'message' => 'Корзина очищена',
        'total_items' => 0
    ));
}



