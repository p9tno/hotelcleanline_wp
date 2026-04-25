<?php
/**
 * Вспомогательные функции темы
 * 
 * @package MyTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('get_pr')) {
    /**
     * Debug функция для красивого вывода переменных через print_r
     * 
     * Удобный инструмент для отладки, который форматирует вывод переменных
     * в читаемом виде с тегами <pre> для браузера
     */
    function get_pr($var, $die = false) {
        // Открываем pre-тег для форматированного вывода
        echo '<pre style="
            background: #f4f4f4;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
            overflow: auto;
            max-height: 100vh;
        ">';
        
        // Выводим содержимое переменной
        print_r($var);
        
        echo '</pre>';
        
        // Останавливаем выполнение если требуется
        if ($die) {
            die('<div style="color: #d00; padding: 10px; background: #fee; border: 1px solid #d00; margin: 10px 0;">Script terminated by get_pr()</div>');
        }
    }
}


/**
 * Убираем префиксы у архивных заголовков
 */
add_filter('get_the_archive_title', 'my_theme_archive_title_filter');
function my_theme_archive_title_filter($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
}

/**
 * Обрезает строку (excerpt или title) до определенного количества символов
 * с умным разбиением по словам
 * 
 * @param int $charlength Максимальное количество символов для вывода
 *                        (значение будет уменьшено на 5 символов для добавления многоточия)
 * 
 * @param string $source Источник данных для обрезки:
 *                       - 'excerpt' - используется get_the_excerpt() (по умолчанию)
 *                       - 'title'   - используется get_the_title()
 * 
 * @return void Функция выводит результат напрямую, ничего не возвращает
 * 
 * @example 
 * // Обрезать excerpt до 140 символов
 * the_max_charlength(140);
 * the_max_charlength(140, 'excerpt');
 * 
 * // Обрезать title до 70 символов
 * the_max_charlength(70, 'title');
 * 
 * @example В шаблоне WordPress:
 * <h2>
 *     <?php the_max_charlength(70, 'title'); ?>
 * </h2>
 * 
 * <div class="excerpt">
 *     <?php the_max_charlength(140); ?>
 * </div>
 * 
 * @logic Алгоритм работы:
 * 1. Получает контент (excerpt или title)
 * 2. Проверяет длину контента
 * 3. Если длина превышает $charlength:
 *    - Обрезает до ($charlength - 5) символов
 *    - Разбивает на слова
 *    - Удаляет последнее неполное слово
 *    - Добавляет многоточие "..."
 * 4. Если длина не превышает $charlength - выводит полный текст
 * 
 * @note Использует multibyte-функции (mb_*) для корректной работы с Unicode
 * @note Если контент пустой - функция ничего не выводит
 */
function the_max_charlength($charlength, $source = 'excerpt') {
    if ($source === 'title') {
        $content = get_the_title();
    } else {
        $content = get_the_excerpt();
    }
    
    if (empty($content)) {
        return;
    }
    
    $charlength++;
    
    if (mb_strlen($content) > $charlength) {
        $subex = mb_substr($content, 0, $charlength - 5);
        $exwords = explode(' ', $subex);
        $excut = -(mb_strlen($exwords[count($exwords) - 1]));
        
        if ($excut < 0) {
            echo mb_substr($subex, 0, $excut);
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $content;
    }
}

/**
 * Выводит пагинацию
 * 
 * @param WP_Query|null $query Объект WP_Query (по умолчанию глобальный $wp_query)
 */
function the_paginate($query = null) {
    // Если запрос не передан, используем глобальный
    if (!$query) {
        global $wp_query;
        $query = $wp_query;
    }
    
    if ($query->max_num_pages <= 1) {
        return;
    }
    
    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    
    echo '<nav class="pagination">';
    echo paginate_links(array(
        'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format'    => '?paged=%#%',
        'current'   => max(1, $paged),
        'total'     => $query->max_num_pages,
        'prev_text' => '<i class="icon_arrow_left_sm"></i>',
        'next_text' => '<i class="icon_arrow_right_sm"></i>',
        'mid_size'  => 1,
        'end_size'  => 1
    ));
    echo '</nav>';
}

if ( ! function_exists( 'get_num_ending' ) ) {
	/**
	 * Склонения числительных
	 *
	 * @param $number
	 * @param $ending_array
	 *
	 * @return mixed
	 */
	function get_num_ending( $number, $ending_array ) {
		$number = $number % 100;
		if ( $number >= 11 && $number <= 19 ) {
			$ending = $ending_array[2];
		} else {
			$i = $number % 10;
			switch ( $i ) {
				case ( 1 ):
					$ending = $ending_array[0];
					break;
				case ( 2 ):
				case ( 3 ):
				case ( 4 ):
					$ending = $ending_array[1];
					break;
				default:
					$ending = $ending_array[2];
			}
		}
		
		return $ending;
	}
}

/**
 * Отображает или возвращает ссылку из поля ACF
 * 
 * @param string $field_name Имя поля ACF
 * @param string $class Дополнительные классы
 * @param bool $echo Выводить сразу или возвращать
 * @return string void HTML код ссылки
 * Пример:
 * render_acf_link('test_first_btn'); 
 * render_acf_link('test_second_btn', 'btn_secondary');
 */
function render_acf_link($field_name, $class = '', $echo = true) {
    $link = get_field($field_name);
    
    if (empty($link) || !is_array($link) || empty($link['url'])) {
        if ($echo) {
            return; // Просто выходим, ничего не выводим
        }
        return ''; // Возвращаем пустую строку
    }
    
    $title = isset($link['title']) && !empty($link['title']) 
        ? esc_html($link['title']) 
        : esc_html($link['url']);
    
    $url = esc_url($link['url']);
    $target = isset($link['target']) && $link['target'] === '_blank' ? '_blank' : '_self';
    
    $classes = 'btn' . (!empty($class) ? ' ' . esc_attr($class) : '');
    
    $html = sprintf(
        '<a class="%s" href="%s" target="%s">%s</a>',
        $classes,
        $url,
        $target,
        $title
    );
    
    if ($echo) {
        echo $html;
    } else {
        return $html;
    }
}

/**
 * Выводит блок с двумя кнопками
 * Пример:
 * render_section_buttons('test_first_btn','test_second_btn');
 */
function render_section_buttons($first_field = '', $second_field = '') {
    // Получаем HTML кнопок без вывода (третий параметр false)
    $first_btn = render_acf_link($first_field, '', false);
    $second_btn = render_acf_link($second_field, 'btn_border', false);
    
    if (!$first_btn && !$second_btn) {
        return;
    }
    
    echo '<div class="section__btns">';
    if ($first_btn) echo $first_btn;
    if ($second_btn) echo $second_btn;
    echo '</div>';
}

/**
 * Выводит заголовок секции из поля ACF
 * Пример:
 * render_section_title('section_title');
 * render_section_title('section_title', 'title--large');
 * 
 * @param string $field_name Имя поля ACF с заголовком
 * @param string $additional_class Дополнительный класс для заголовка (опционально)
 */
function render_section_title($field_name = '', $additional_class = '') {
    // Получаем значение из ACF
    $title = get_field($field_name);
    
    // Если заголовок пустой - ничего не выводим
    if (empty($title)) {
        return;
    }
    
    // Формируем классы
    $classes = 'section__title';
    if (!empty($additional_class)) {
        $classes .= ' ' . $additional_class;
    }
    
    echo '<h2 class="' . esc_attr($classes) . '">' . esc_html($title) . '</h2>';
}

/**
 * Выводит описание секции из поля ACF
 * Пример:
 * render_section_description('section_description');
 * render_section_description('section_description', 'desc--highlight');
 * 
 * @param string $field_name Имя поля ACF с описанием
 * @param string $additional_class Дополнительный класс для описания (опционально)
 */
function render_section_description($field_name = '', $additional_class = '') {
    // Получаем значение из ACF
    $description = get_field($field_name);
    
    // Если описание пустое - ничего не выводим
    if (empty($description)) {
        return;
    }
    
    // Формируем классы
    $classes = 'section__desc';
    if (!empty($additional_class)) {
        $classes .= ' ' . $additional_class;
    }
    
    echo '<div class="' . esc_attr($classes) . '">' . wp_kses_post($description) . '</div>';
}

/**
 * Выводит контент секции из поля ACF
 * Пример:
 * render_section_content('section_content');
 * render_section_content('section_content', 'content--large');
 * 
 * @param string $field_name Имя поля ACF с контентом
 * @param string $additional_class Дополнительный класс для контента (опционально)
 */
function render_section_content($field_name = '', $additional_class = '') {
    // Получаем значение из ACF
    $content = get_field($field_name);
    
    // Если контент пустой - ничего не выводим
    if (empty($content)) {
        return;
    }
    
    // Формируем классы
    $classes = 'section__content';
    if (!empty($additional_class)) {
        $classes .= ' ' . $additional_class;
    }
    
    echo '<div class="' . esc_attr($classes) . '">' . wp_kses_post($content) . '</div>';
}

function my_cat_list_filter ( $post_type = 'post' , $taxonomy = '', $posts_per_page = '1') { ?>
	<?php 
    	$post_count_obj = wp_count_posts( $post_type );
	    $total_posts = 0;
        $total_posts = isset($post_count_obj->publish) ? $post_count_obj->publish : 0;
    ?>

	<div class="category filter filter-list-js user_select_none">
		<div class="category__item filter-cat-js">
			<input 
				type="radio" 
				name="cat_name" 
				id="term_all" 
				checked="checked" 
				value="all"  
				data-taxonomy=<?php echo $taxonomy; ?>
				data-post-type=<?php echo $post_type; ?>
				data-posts_per_page = <?php echo $posts_per_page; ?>
				/>
			<label for="term_all">
                <span>All</span>
                <span>(<?php echo $total_posts; ?>)</span>
            </label>
		</div>
		<?php
		$categories = get_terms(
			$taxonomy,
			array (
				// 'meta_key'                 => 'video_lab_number',
				// 'orderby'                  => 'meta_value_num',
				// 'order'                    => 'ASC',
				'hierarchical' => true,
				'hide_empty' => 1,
				'parent' => 0
			) 
		);
		foreach($categories as $cat) { //get_pr($cat); ?>   
			<div class="category__item filter-cat-js">
				<input 
					type="radio" 
					name="cat_name"
					id="term_<?php echo $cat->term_id; ?>" 
					value="<?php echo $cat->term_id; ?>" 
					data-taxonomy=<?php echo $taxonomy; ?> 
					data-post-type=<?php echo $post_type; ?>
					data-posts_per_page = <?php echo $posts_per_page; ?>
					/>
				<label for="term_<?php echo $cat->term_id; ?>"><span><?php echo $cat->name; ?></span><span>(<?php echo $cat->count; ?>)</span></label>
			</div>
		<?php } ?>
	</div>
	


	<?php
}

// add_filter('wpforms_frontend_container_class', 'simple_remove_wpforms_class');
// function simple_remove_wpforms_class($classes) {
//     if (is_array($classes)) {
//         // Удаляем класс из массива
//         $classes = array_diff($classes, ['wpforms-container-full']);
//         // Можно добавить свой класс
//         // $classes[] = 'my-custom-container';
//     }
//     return $classes;
// }


/**
 * Получение HTML изображения для любой таксономии
 * 
 * @param int $term_id ID термина
 * @param string $taxonomy Название таксономии
 * @param string $size Размер изображения
 * @return string HTML изображения
 */
function get_taxonomy_image_html($term_id, $taxonomy, $size = 'medium') {
    // Пытаемся получить изображение через ACF
    $image_id = get_field($taxonomy . '_image', $taxonomy . '_' . $term_id);
    
    if ($image_id) {
        return wp_get_attachment_image($image_id, $size);
    }
    
    // Если изображения нет, возвращаем заглушку
    $no_img_url = get_template_directory_uri() . '/assets/img/no_img.webp';
    $term = get_term($term_id, $taxonomy);
    $alt = $term ? $term->name : 'Изображение таксономии';
    
    return '<img src="' . esc_url($no_img_url) . '" alt="' . esc_attr($alt) . '">';
}

// Использование
// $image_html = get_taxonomy_image_html($term_id, 'product_category', 'large');
// или
// $image_html = get_taxonomy_image_html($term_id, 'product_tag', 'large');
// или
// $image_html = get_taxonomy_image_html($term_id, 'product_izdeliya', 'large');

/**
 * Получение HTML изображения продукта (только миниатюра)
 * 
 * @param int $product_id ID продукта
 * @param string $size Размер изображения (thumbnail, medium, large, full)
 * @return string HTML изображения
 * Использование в цикле: <?php echo get_product_image_html(get_the_ID(), 'thumbnail'); ?>
 */
function get_product_image_html($product_id, $size = 'medium') {
    if (has_post_thumbnail($product_id)) {
        return get_the_post_thumbnail($product_id, $size);
    }
    
    // Если миниатюры нет, возвращаем заглушку
    $no_img_url = get_template_directory_uri() . '/assets/img/no_img.webp';
    $product = get_post($product_id);
    $alt = $product ? $product->post_title : 'Изображение товара';
    
    return '<img src="' . esc_url($no_img_url) . '" alt="' . esc_attr($alt) . '">';
}

// Добавляем колонки в список продуктов
add_filter('manage_product_posts_columns', function($columns) {
    $columns['thumbnail'] = 'Миниатюра';
    // $columns['price'] = 'Цена';
    // $columns['product_category'] = 'Категории';
    return $columns;
});

// Заполняем колонки
add_action('manage_product_posts_custom_column', function($column, $post_id) {
    switch($column) {
        case 'thumbnail':
            echo get_the_post_thumbnail($post_id, array(50, 50));
            break;
        // case 'price':
        //     echo get_field('price', $post_id) . ' ₽';
        //     break;
        // case 'product_category':
        //     $terms = get_the_terms($post_id, 'product_category');
        //     if($terms && !is_wp_error($terms)) {
        //         $terms_list = array();
        //         foreach($terms as $term) {
        //             $terms_list[] = $term->name;
        //         }
        //         echo implode(', ', $terms_list);
        //     }
        //     break;
    }
}, 10, 2);

// Делаем колонку с миниатюрой сортируемой
add_filter('manage_edit-product_sortable_columns', function($columns) {
    $columns['price'] = 'price';
    return $columns;
});

/**
 * Выводит информационное сообщение
 *
 * @param string $content Текст сообщения
 * @param string $tag     HTML тег (по умолчанию h4)
 * @return void
 * Базовое использование custom_info(); // "Товары не найдены"
 * С произвольным текстом custom_info( 'Корзина пуста' );
 */
function custom_info( $content = '', $tag = 'h4' ) {
    if ( empty( $content ) ) {
        $content = 'Товары не найдены';
    }
    
    $allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div' );
    if ( ! in_array( $tag, $allowed_tags ) ) {
        $tag = 'div';
    }
    
    printf(
        '<%s class="section__info info">%s</%s>',
        esc_attr( $tag ),
        esc_html( $content ),
        esc_attr( $tag )
    );
}


/**
 * Получение всех данных продукта в простом массиве
 * 
 * @param int $product_id ID продукта
 * @return array|false
 */
function get_product_data($product_id) {
    $post = get_post($product_id);
    if (!$post || $post->post_type !== 'product') {
        return false;
    }
    
    // Получаем статус
    $status = get_field('product_status', $product_id);
    
    return [
        'id' => $product_id,
        'title' => $post->post_title,
        'slug' => $post->post_name,
        'permalink' => get_permalink($product_id),
        'price' => get_field('product_price', $product_id),
        'sku' => get_field('product_sku', $product_id),
        'status_value' => is_array($status) ? $status['value'] : 'instock',
        'status_label' => is_array($status) ? $status['label'] : 'В наличии',
        'thumbnail' => get_the_post_thumbnail_url($product_id, 'medium'),
        'categories' => wp_get_object_terms($product_id, 'product_category', ['fields' => 'names']),
        'tags' => wp_get_object_terms($product_id, 'product_tag', ['fields' => 'names']),
        'content' => get_field('product_content', $product_id),
        'characteristic' => get_field('product_characteristic', $product_id),
    ];
}


/**
 * Получить параметры количества для товара
 * 
 * @param int $product_id ID товара
 * @return array Массив с параметрами (step, min, max, default)
 */
function get_product_quantity_params($product_id) {
    $defaults = array(
        'step' => 1000,
        'min' => 1000,
        'max' => 100000,
        'default' => 1000
    );
    
    // Получаем значения из ACF
    $step = get_field('product_quantity_step', $product_id);
    $min = get_field('product_quantity_min', $product_id);
    $max = get_field('product_quantity_max', $product_id);
    
    return array(
        'step' => !empty($step) ? intval($step) : $defaults['step'],
        'min' => !empty($min) ? intval($min) : $defaults['min'],
        'max' => !empty($max) ? intval($max) : $defaults['max'],
        'default' => !empty($min) ? intval($min) : $defaults['default']
    );
}

/**
 * Генерирует блок выбора количества (только контролы + и -)
 * 
 * @param int $product_id ID товара
 * @param array $args Параметры:
 *   - wrapper_class: string Дополнительный класс для обертки
 *   - default_quantity: int|null Количество по умолчанию
 * 
 * @return string HTML блока выбора количества
 */
function render_quantity_selector($product_id, $args = array()) {
    $defaults = array(
        'wrapper_class' => '',
        'default_quantity' => null
    );
    
    $params = wp_parse_args($args, $defaults);
    
    // Получаем параметры количества для конкретного товара
    $quantity_params = get_product_quantity_params($product_id);
    
    // Приоритет: переданное значение > значение из ACF
    if (!is_null($params['default_quantity'])) {
        $current_quantity = intval($params['default_quantity']);
    } else {
        $current_quantity = $quantity_params['default'];
    }
    
    // Единые классы
    $wrapper_class = 'quantity-selector';
    if (!empty($params['wrapper_class'])) {
        $wrapper_class .= ' ' . $params['wrapper_class'];
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($wrapper_class); ?> quantity_wrap" data-product-id="<?php echo esc_attr($product_id); ?>">
        <button type="button" class="quantity-btn quantity-minus btn btn_quantity" 
                data-step="<?php echo esc_attr($quantity_params['step']); ?>" 
                data-min="<?php echo esc_attr($quantity_params['min']); ?>">
            &minus;
        </button>
        <input type="number" 
               class="quantity-input quantity__input" 
               value="<?php echo esc_attr($current_quantity); ?>" 
               data-product-id="<?php echo esc_attr($product_id); ?>"
               data-default="<?php echo esc_attr($quantity_params['default']); ?>"
               data-step="<?php echo esc_attr($quantity_params['step']); ?>"
               data-min="<?php echo esc_attr($quantity_params['min']); ?>"
               data-max="<?php echo esc_attr($quantity_params['max']); ?>"
               step="<?php echo esc_attr($quantity_params['step']); ?>"
               min="<?php echo esc_attr($quantity_params['min']); ?>"
               max="<?php echo esc_attr($quantity_params['max']); ?>"
               readonly>
        <button type="button" class="quantity-btn quantity-plus btn btn_quantity" 
                data-step="<?php echo esc_attr($quantity_params['step']); ?>" 
                data-max="<?php echo esc_attr($quantity_params['max']); ?>">
            +
        </button>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Генерирует кнопку "Добавить в корзину"
 * 
 * @param int $product_id ID товара
 * @param array $args Параметры:
 *   - button_class: string Дополнительный класс для кнопки
 * 
 * @return string HTML кнопки
 */
function render_add_to_cart_button($product_id, $args = array()) {
    $defaults = array(
        'button_class' => ''
    );
    
    $params = wp_parse_args($args, $defaults);
    
    $product = get_post($product_id);
    if (!$product || $product->post_type !== 'product') {
        return '';
    }
    
    // Проверяем статус товара
    $status = get_field('product_status', $product_id);
    $status_value = is_array($status) ? $status['value'] : $status;
    
    // Если товар не в наличии или снят с продажи - показываем заглушку
    if ($status_value !== 'instock') {
        $status_label = is_array($status) ? $status['label'] : 'Нет в наличии';
        return '<span class="btn btn-disabled btn_disabled">' . esc_html($status_label) . '</span>';
    }
    
    // Получаем минимальное количество для кнопки по умолчанию
    $quantity_params = get_product_quantity_params($product_id);
    $default_quantity = $quantity_params['min'];
    
    ob_start();
    ?>
    <button 
        class="btn btn-add-to-cart <?php echo esc_attr($params['button_class']); ?>" 
        data-product-id="<?php echo esc_attr($product_id); ?>"
        data-quantity="<?php echo esc_attr($default_quantity); ?>"
    >
        Купить
    </button>
    <?php
    return ob_get_clean();
}

/**
 * Генерирует полный блок (количество + кнопка) для добавления в корзину
 * 
 * @param int $product_id ID товара
 * @param array $args Параметры:
 *   - show_quantity: bool Показывать блок с количеством (по умолчанию true)
 *   - button_class: string Дополнительный класс для кнопки
 *   - wrapper_class: string Дополнительный класс для обертки
 * 
 * @return string HTML полного блока
 */
function render_full_add_to_cart($product_id, $args = array()) {
    $defaults = array(
        'show_quantity' => true,
        'button_class' => '',
        'wrapper_class' => ''
    );
    
    $params = wp_parse_args($args, $defaults);
    
    $product = get_post($product_id);
    if (!$product || $product->post_type !== 'product') {
        return '';
    }
    
    // Проверяем статус товара
    $status = get_field('product_status', $product_id);
    $status_value = is_array($status) ? $status['value'] : $status;
    
    if ($status_value !== 'instock') {
        $status_label = is_array($status) ? $status['label'] : 'Нет в наличии';
        return '<div class="wrap-add-to-cart disabled ' . esc_attr($params['wrapper_class']) . '">
            <span class="btn btn-disabled btn_disabled">' . esc_html($status_label) . '</span>
        </div>';
    }
    
    ob_start();
    ?>
    <div class="wrap-add-to-cart add_to_cart_wrap <?php echo esc_attr($params['wrapper_class']); ?>" data-product-id="<?php echo esc_attr($product_id); ?>">
        <?php if ($params['show_quantity']) : ?>
            <?php echo render_quantity_selector($product_id); ?>
        <?php endif; ?>
        <?php echo render_add_to_cart_button($product_id, array('button_class' => $params['button_class'])); ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Генерирует блок для страницы корзины (только количество, обертка wrap-add-to-cart)
 * 
 * @param int $product_id ID товара
 * @param int $quantity Текущее количество в корзине
 * @return string HTML блока
 */
function render_cart_quantity_selector($product_id, $quantity) {
    ob_start();
    ?>
    <div class="wrap-add-to-cart">
        <?php echo render_quantity_selector($product_id, array('default_quantity' => $quantity)); ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Выводит блок выбора количества
 */
function the_quantity_selector($product_id, $args = array()) {
    echo render_quantity_selector($product_id, $args);
}

/**
 * Выводит кнопку "Добавить в корзину"
 */
function the_add_to_cart_button($product_id, $args = array()) {
    echo render_add_to_cart_button($product_id, $args);
}

/**
 * Выводит полный блок (количество + кнопка)
 */
function the_full_add_to_cart($product_id, $args = array()) {
    echo render_full_add_to_cart($product_id, $args);
}

/**
 * Выводит блок для страницы корзины
 */
function the_cart_quantity_selector($product_id, $quantity) {
    echo render_cart_quantity_selector($product_id, $quantity);
}