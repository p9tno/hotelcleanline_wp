<?php

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Шапка',
        'menu_title'	=> 'Шапка',
        'menu_slug' 	=> 'theme-header',
        'capability'	=> 'edit_posts',
        'redirect'		=> false,
        // 'icon_url' => 'dashicons-arrow-up',
    ));		
	acf_add_options_page(array(
		'page_title' 	=> 'Контакты',
		'menu_title'	=> 'Контакты',
		'menu_slug' 	=> 'theme-contact',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
        'icon_url' => 'dashicons-phone',
	));	
	acf_add_options_page(array(
		'page_title' 	=> 'Настройки контента',
		'menu_title'	=> 'Контент сайта',
		'menu_slug' 	=> 'theme-global-content',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
        'icon_url' => 'dashicons-text',
	));
    acf_add_options_page(array(
        'page_title' 	=> 'Подвал',
        'menu_title'	=> 'Подвал',
        'menu_slug' 	=> 'theme-footer',
        'capability'	=> 'edit_posts',
        'redirect'		=> false,
        // 'icon_url' => 'dashicons-arrow-down',
    ));
}

function my_template_acf_mataboxes(){
    // BEGIN GLOBAL CONTACTS
    acf_add_local_field_group(array(
        'key' => 'acf_global_contacts',
        'title' => 'Контактные данные',
        'fields' => array(
            // ------------------------------- tab_phone
            array (
                'key' => 'tab_phone',
                'label' => 'Телефон', 
                'type' => 'tab',
            ),
            array(
                'key' => 'phone',
                'label' => 'Номер телефона',
                'name' => 'phone',
                'type' => 'text',
            ),
            // ------------------------------- tab_messenger
            array (
                'key' => 'tab_messenger',
                'label' => 'Мессенджеры', 
                'type' => 'tab',
            ),
            array(
                'key' => 'whatsapp',
                'label' => 'WhatsApp',
                'name' => 'whatsapp',
                'type' => 'text',
            ),
            array(
                'key' => 'telegram',
                'label' => 'telegram',
                'name' => 'telegram',
                'type' => 'text',
            ),
            array(
                'key' => 'viber',
                'label' => 'viber',
                'name' => 'viber',
                'type' => 'text',
            ),
            array(
                'key' => 'youtube',
                'label' => 'YouTube',
                'name' => 'youtube',
                'type' => 'text',
            ),
            array(
                'key' => 'instagram',
                'label' => 'Instagram',
                'name' => 'instagram',
                'type' => 'text',
            ),
            array(
                'key' => 'vk',
                'label' => 'vk',
                'name' => 'vk',
                'type' => 'text',
            ),
            // ------------------------------- tab_email
            array (
                'key' => 'tab_email',
                'label' => 'Email', 
                'type' => 'tab',
            ),
            array(
                'key' => 'mail',
                'label' => 'Email',
                'name' => 'mail',
                'type' => 'text',
            ),
            array(
                'key' => 'mail_to',
                'label' => 'Email для получения заявок с сайта',
                'name' => 'mail_to',
                'type' => 'text',
                // 'instructions' => 'Почта получателя в одинарных <b>кавычках</b>, через запятую можно указать несколько адресов.',
                // 'placeholder' => 'daria11140@gmail.com',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-contact',
                )
            )
        ),
    ));
    // END GLOBAL CONTACTS
    // ---------------------------------------------------------
    // BEGIN GLOBAL HEADER
    acf_add_local_field_group(array(
        'key' => 'acf_global_header',
        'title' => 'Настройки шапки',
        'fields' => array(
            // ------------------------------- tab_header_general
            array (
                'key' => 'tab_header_general',
                'label' => 'Общие настройки', 
                'type' => 'tab',
            ),
            array(
                'key' => 'logo_img',
                'label' => 'Логотип',
                'name' => 'logo_img',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url'
                'preview_size' => 'full',
            ),
            // ------------------------------- tab_header_scripts
            array (
                'key' => 'tab_header_scripts',
                'label' => 'Скрипты', 
                'type' => 'tab',
            ),
            array(
                'key' => 'header_scripts',
                'label' => 'Скрипты перед закрывающим тегом <b>/HEAD</b>',
                'name' => 'header_scripts',
                'type' => 'textarea',
                'rows'  => 20,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-header',
                )
            )
        ),
    ));
    // END GLOBAL HEADER
    // ---------------------------------------------------------
    // BEGIN GLOBAL FOOTER
    acf_add_local_field_group(array(
        'key' => 'acf_global_footer',
        'title' => 'Настройки подвала',
        'fields' => array(
            // ------------------------------- tab_footer_general
            array (
                'key' => 'tab_footer_general',
                'label' => 'Общие настройки', 
                'type' => 'tab',
            ),
            array(
                'key' => 'footer_img',
                'label' => 'Логотип',
                'name' => 'footer_img',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url'
                'preview_size' => 'full',
            ),
            // ------------------------------- tab_footer_scripts
            array (
                'key' => 'tab_footer_scripts',
                'label' => 'Скрипты', 
                'type' => 'tab',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-footer',
                )
            )
        ),
    ));
    // END GLOBAL FOOTER
    // ---------------------------------------------------------
    // BEGIN GLOBAL CONTENT
    acf_add_local_field_group(array(
        'key' => 'acf_global_content',
        'title' => 'Настройки контента',
        'fields' => array(
            // ------------------------------- Preloader
            array (
                'key' => 'tab_content_preloader',
                'label' => 'Preloader', 
                'type' => 'tab',
            ),
            array(
                'key' => 'preloader_boolean',
                'label' => 'Отображать блок?',
                'name' => 'preloader_boolean',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            // ------------------------------- 404
            array (
                'key' => 'tab_content_404',
                'label' => 'Страница 404', 
                'type' => 'tab',
            ),
            array(
                'key' => '404_title',
                'label' => 'Заголовок',
                'name' => '404_title',
                'type' => 'text',
                'instructions' => 'Используйте тег b для выделения жирного контента. Для переноса строки используйте тег br. Тег i для выделения другим цветом',
            ),
            array(
                'key' => '404_subtitle',
                'label' => 'Подзаголовок',
                'name' => '404_subtitle',
                'type' => 'text',
            ),
            array(
                'key' => '404_img_id',
                'label' => 'Фоновое изображение блока',
                'name' => '404_img_id',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url'
                'preview_size' => 'thumbnail',
                'instructions' => 'Рекомендуемое разрешение изображения 1920/1080px.',
            ),
            // ------------------------------- privacy
            array (
                'key' => 'tab_content_privacy',
                'label' => 'Политика конфиденциальности', 
                'type' => 'tab',
            ),
            array(
                'key' => 'privacy_content',
                'label' => 'Контент',
                'name' => 'privacy_content',
                'type' => 'wysiwyg',
                'tabs' => 'all',  // 'visual' || 'text'
                'toolbar' => 'full',  // 'basic'
                'media_upload' => 0,
                'delay' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-global-content',
                )
            )
        ),
    ));
    // END GLOBAL CONTENT
    // ---------------------------------------------------------

    // BEGIN firstscreen section
    acf_add_local_field_group(array(
        'key' => 'acf_firstscreen_settings',
        'title' => 'Настройки главного слайдера',
        'fields' => array(
            array(
                'key' => 'firstscreen_boolean',
                'label' => 'Отображать блок?',
                'name' => 'firstscreen_boolean',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'list_firstscreen',
                'label' => 'Слайды',
                'name' => 'list_firstscreen',
                'type' => 'repeater',
                'layout' => 'row',  // 'block' || 'row' || 'table'
                'button_label' => 'Добавить',
                'sub_fields' => array(
                    array(
                        'key' => 'firstscreen_title',
                        'label' => 'Заголовок',
                        'name' => 'firstscreen_title',
                        'type' => 'text',
                        'placeholder' => 'Добавьте тег <br> для переноса строки',
                    ),
                    array(
                        'key' => 'firstscreen_desc',
                        'label' => 'Описание',
                        'name' => 'firstscreen_desc',
                        'type' => 'textarea',
                        'rows' => 1,
                    ),
                    array(
                        'key' => 'firstscreen_link',
                        'label' => 'Ссылка',
                        'name' => 'firstscreen_link',
                        'type' => 'link',
                        'return_format' => 'array',  // 'array' || 'url'
                    ),
                    array(
                        'key' => 'firstscreen_img_id',
                        'label' => 'Изображение',
                        'name' => 'firstscreen_img_id',
                        'type' => 'image',
                        'return_format' => 'id',  // 'id' || 'url' || 'array'
                        'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                        'instructions' => 'Рекомендуемое разрешение изображения не более 1440/640px.',
                        'required' => 1,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-homepage.php',
                )
            ),
        ),
        'menu_order' => 1,
    ));
    // END firstscreen section
    // ---------------------------------------------------------

    // BEGIN test section
    acf_add_local_field_group(array(
        'key' => 'acf_test_settings',
        'title' => 'Настройки test',
        'fields' => array(
            array(
                'key' => 'test_boolean',
                'label' => 'Отображать блок?',
                'name' => 'test_boolean',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'test_title',
                'label' => 'Заголовок',
                'name' => 'test_title',
                'type' => 'text',

                'instructions' => '',
                'required' => 0,
                'default_value' => '',
                'placeholder' => '',
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'test_desc',
                'label' => 'Описание',
                'name' => 'test_desc',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'test_img_id',
                'label' => 'Изображение',
                'name' => 'test_img_id',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'instructions' => 'Рекомендуемое разрешение изображения не более 230/350px.',
            ),
            array(
                'key' => 'test_link',
                'label' => 'Ссылка',
                'name' => 'test_link',
                'type' => 'link',
                'return_format' => 'array',  // 'array' || 'url'
            ),
            array(
                'key' => 'list_test',
                'label' => 'Список',
                'name' => 'list_test',
                'type' => 'repeater',
                'layout' => 'table',  // 'block' || 'row' || 'table'
                'min' => 0,
                'max' => 0,
                'button_label' => 'Добавить',
                'sub_fields' => array(
                    array(
                        'key' => 'list_item',
                        'label' => 'Элемент списка',
                        'name' => 'list_item',
                        'type' => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-homepage.php',
                )
            ),
            // array(
            //     array(
            //         'param' => 'page_template',
            //         'operator' => '==',
            //         'value' => 'template-contacts.php',
            //     ),
            // ),
        ),
        'menu_order' => 100,
    ));
    // END test section
    // ---------------------------------------------------------

}
add_action('acf/init', 'my_template_acf_mataboxes');

// https://awhitepixel.com/blog/advanced-custom-fields-complete-reference-adding-fields-groups-by-code/

// LIST

// array(
//     'key' => 'list_test',
//     'label' => 'Список',
//     'name' => 'list_test',
//     'type' => 'repeater',
//     'layout' => 'table',  // 'block' || 'row' || 'table'
//     'min' => 0,
//     'max' => 0,
//     'button_label' => 'Добавить',
//     'sub_fields' => array(
//         array(
//             'key' => 'list_item',
//             'label' => 'Элемент списка',
//             'name' => 'list_item',
//             'type' => 'text',
//         ),
//     ),
// ),

// END LIST

// ---------------------------------------------------------

// IMG ID

// array(
//     'key' => 'test_img_id',
//     'label' => 'Изображение',
//     'name' => 'test_img_id',
//     'type' => 'image',
//     'return_format' => 'id',  // 'id' || 'url' || 'array'
//     'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
//     'instructions' => 'Рекомендуемое разрешение изображения не более 230/350px.',
// ),

// END IMG ID

// ---------------------------------------------------------

// TAB

// ------------------------------- tab_test
// array (
//     'key' => 'tab_test',
//     'label' => 'Таб', 
//     'type' => 'tab',
// ),

// END TAB

// ---------------------------------------------------------

// BOOLEAN

// array(
//     'key' => 'boolean_test',
//     'label' => 'Отображать блок?',
//     'name' => 'boolean_test',
//     'type' => 'true_false',
//     'default_value' => 1,
//     'ui' => 1,
//     'ui_on_text' => 'Да',
//     'ui_off_text' => 'Нет',
// ),

// END BOOLEAN

// ---------------------------------------------------------

// VIDEO ID

// array(
//     'key' => 'video_id_test',
//     'label' => 'ID видео',
//     'name' => 'video_id_test',
//     'type' => 'text',
//     'instructions' => 'ID - это набор символов после "watch?v=" в строке браузера. Как пример из строки https://www.youtube.com/watch?v=QEPbamO8i9s , id= 1FBNIVQXhPc',
//     'placeholder' => '1FBNIVQXhPc',
// ),

// END VIDEO ID

// ---------------------------------------------------------

// LINK

// array(
//     'key' => 'test_link',
//     'label' => 'Ссылка',
//     'name' => 'test_link',
//     'type' => 'link',
//     'return_format' => 'array',  // 'array' || 'url'
// ),

// END LINK

// ---------------------------------------------------------

// NUMBER

// array(
//     'key' => 'test_number',
//     'label' => 'Число',
//     'name' => 'test_number',
//     'type' => 'number',
//     'min' => 0,
//     'max' => 100,
//     'step' => 1,    
// ),

// END NUMBER

// ---------------------------------------------------------

// Range slider

// array(
//     'key' => 'test_range',
//     'label' => 'Числовой слайдер',
//     'name' => 'test_range',
//     'type' => 'range',
// 	'min' => 0,
// 	'max' => 100,
// 	'step' => 1,
// 	'default_value' => 50,
// 	'prepend' => 'Prepend text',
// 	'append' => 'Appended text',
// ),

// END Range slider

// ---------------------------------------------------------

// WYSIWYG Editor

// array(
//     'key' => 'test_content',
//     'label' => 'Контент',
//     'name' => 'test_content',
//     'type' => 'wysiwyg',
//     'tabs' => 'all',  // 'visual' || 'text' || 'all'
//     'toolbar' => 'full',  // 'basic' \\ 'full'
//     'media_upload' => 0,
//     'delay' => 0,
//     'instructions' => 'Используйте заголовки (h1 - h6), абзацы (p), списки (ul)',
// ),

// END WYSIWYG Editor

// ---------------------------------------------------------

// Select

// array(
//     'key' => 'test_select',
//     'label' => 'Выбор',
//     'name' => 'test_select',
//     'type' => 'select',
//     'allow_null' => 1,
//     'multiple' => 0,
//     'ui' => 1,
//     'return_format' => 'label',  // 'array' || 'label'
//     'choices' => [
//         'serial' => 'Серийный',   
//         'individual' => 'Индивидуальный',
//     ],
//     'default_value' => '',
//     'wrapper' => array (
//         'width' => '20',
//     ),
// ),

// END Select

// ---------------------------------------------------------

// Checkbox

// array(
//     'key' => 'test_checkbox',
//     'label' => 'Чекбокс',
//     'name' => 'test_checkbox',
//     'type' => 'checkbox',
//     'layout' => 'horizontal',  // 'vertical' || 'horizontal'
//     'toggle' => 0,
//     'return_format' => 'value',  // 'array' || 'label' || 'value'
//     'choices' => [
//         'pdf' => 'Скачать презентацию',
//         'phone' => 'Оставить заявку',
//         'percentage' => 'Акции',
       
//     ],
//     'default_value' => ['pdf'],
//     'allow_custom' => 0,
//     'save_custom' => 0,
// ),

// END Checkbox

// ---------------------------------------------------------

// Radio Button

// array(
//     'key' => 'test_radio',
//     'label' => 'Радио кнопка',
//     'name' => 'test_radio',
//     'type' => 'radio',
//     'layout' => 'horizontal', // horizontal   ||   vertical
//     'choices' => array(
//         'light' => 'Светлая',
//         'dark' => 'Темная',
//     ),
//     'default_value' => 'light',
//     'return_format' => 'value',  // 'array' || 'label'
// ),

// END Radio Button

// ---------------------------------------------------------

// Post Object

// 'fields' => array(
//     array(
//         'key' => 'test_relations',
//         'label' => 'Выбирите квиз',
//         'name' => 'test_relations',
//         'type' => 'post_object',
//         'allow_null' => 1,
//         'multiple' => 0,
//         'return_format' => 'id',  // 'id' || 'object'
//         'post_type' => 'test',  // or array of post types e.g. ['post', 'page']
//         'taxonomy' => '',  // or array of terms e.g. ['category:term-slug']
//     ),
// ),

// END Post Object

// ---------------------------------------------------------

// HTML Message

// array(
//     'key' => 'test_message',
//     'label' => 'ПРИМЕЧАНИЕ!!!',
//     'name' => 'test_message',
//     'type' => 'message',
//     'message' => '<h1 style="color:#36a566;">Далее настройки</h1>',
//     'new_lines' => 'wpautop',
//     'esc_html' => 0,
// ),

// END HTML Message












