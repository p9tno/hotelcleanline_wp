<?php

if( function_exists('acf_add_options_page') ) {

	
	acf_add_options_page(array(
		'page_title' 	=> 'Магазин',
		'menu_title'	=> 'Магазин',
		'menu_slug' 	=> 'theme-shop',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
        'icon_url' => 'dashicons-screenoptions',
	));	
	acf_add_options_page(array(
		'page_title' 	=> 'Настройки контента',
		'menu_title'	=> 'Контент сайта',
		'menu_slug' 	=> 'theme-global-content',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
        'icon_url' => 'dashicons-text',
	));
}

function my_template_acf_mataboxes(){
    // BEGIN GLOBAL SHOP
    acf_add_local_field_group(array(
        'key' => 'acf_global_shop',
        'title' => 'Настройки магазина',
        'fields' => array(
            // ------------------------------- Настройки валюты (НОВАЯ ВКЛАДКА)
            array(
                'key' => 'tab_content_currency',
                'label' => 'Валюта', 
                'type' => 'tab',
            ),
            array(
                'key' => 'currency_position',
                'label' => 'Позиция валюты',
                'name' => 'currency_position',
                'type' => 'select',
                'default_value' => 'after',
                'choices' => array(
                    'before' => 'Перед ценой (₽100)',
                    'after' => 'После цены (100₽)',
                    'before_space' => 'Перед ценой с пробелом (₽ 100)',
                    'after_space' => 'После цены с пробелом (100 ₽)',
                ),
                'instructions' => 'Где отображать символ валюты относительно цены',
            ),
            array(
                'key' => 'currency_thousand_separator',
                'label' => 'Разделитель тысяч',
                'name' => 'currency_thousand_separator',
                'type' => 'select',
                'default_value' => 'space',
                'choices' => array(
                    'space' => 'Пробел (1 000)',
                    'comma' => 'Запятая (1,000)',
                    'dot' => 'Точка (1.000)',
                    'none' => 'Без разделителя (1000)',
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-shop',
                )
            )
        ),
    ));
    // END GLOBAL SHOP

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
            // ------------------------------- tab_header
            array (
                'key' => 'tab_header',
                'label' => 'Шапка', 
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
            // array(
            //     'key' => 'header_scripts',
            //     'label' => 'Скрипты перед закрывающим тегом <b>/HEAD</b>',
            //     'name' => 'header_scripts',
            //     'type' => 'textarea',
            //     'rows'  => 20,
            // ),
            // ------------------------------- tab_footer
            array (
                'key' => 'tab_footer',
                'label' => 'Подвал', 
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
            // array(
            //     'key' => 'footer_scripts',
            //     'label' => 'Скрипты перед закрывающим тегом <b>/BODY</b>',
            //     'name' => 'footer_scripts',
            //     'type' => 'textarea',
            //     'rows'  => 20,
            // ),

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
            // // ------------------------------- privacy
            // array (
            //     'key' => 'tab_content_privacy',
            //     'label' => 'Политика конфиденциальности', 
            //     'type' => 'tab',
            // ),
            // array(
            //     'key' => 'privacy_content',
            //     'label' => 'Контент',
            //     'name' => 'privacy_content',
            //     'type' => 'wysiwyg',
            //     'tabs' => 'all',  // 'visual' || 'text'
            //     'toolbar' => 'full',  // 'basic'
            //     'media_upload' => 0,
            //     'delay' => 0,
            // ),
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

    // BEGIN topCategories section
    acf_add_local_field_group(array(
        'key' => 'acf_topCategories_settings',
        'title' => 'Настройки категорий',
        'fields' => array(
            // array(
            //     'key' => 'topCategories_boolean',
            //     'label' => 'Отображать блок?',
            //     'name' => 'topCategories_boolean',
            //     'type' => 'true_false',
            //     'default_value' => 1,
            //     'ui' => 1,
            //     'ui_on_text' => 'Да',
            //     'ui_off_text' => 'Нет',
            // ),
            array(
                'key' => 'topCategories_title',
                'label' => 'Заголовок',
                'name' => 'topCategories_title',
                'type' => 'text',
            ),
            array(
                'key' => 'topCategories_desc',
                'label' => 'Описание',
                'name' => 'topCategories_desc',
                'type' => 'textarea',
                'rows' => 2,
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
        'menu_order' => 4,
    ));
    // END topCategories section
    // ---------------------------------------------------------

    // BEGIN partners section
    acf_add_local_field_group(array(
        'key' => 'acf_partners_settings',
        'title' => 'Настройки араматов',
        'fields' => array(
            array(
                'key' => 'partners_boolean',
                'label' => 'Отображать блок?',
                'name' => 'partners_boolean',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'partners_title',
                'label' => 'Заголовок',
                'name' => 'partners_title',
                'type' => 'text',
            ),
            array(
                'key' => 'partners_desc',
                'label' => 'Описание',
                'name' => 'partners_desc',
                'type' => 'textarea',
                'rows' => 1,
            ),
            array(
                'key' => 'partners_slides',
                'label' => 'Слайды',
                'name' => 'partners_slides',
                'type' => 'repeater',
                'layout' => 'row',  // 'block' || 'row' || 'table'
                'button_label' => 'Добавить',
                'sub_fields' => array(
                    array(
                        'key' => 'partners_slide_title',
                        'label' => 'Заголовок',
                        'name' => 'partners_slide_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'partners_slide_desc',
                        'label' => 'Описание',
                        'name' => 'partners_slide_desc',
                        'type' => 'textarea',
                        'rows' => 1,
                    ),
                    array(
                        'key' => 'partners_slide_img_id',
                        'label' => 'Изображение',
                        'name' => 'partners_slide_img_id',
                        'type' => 'image',
                        'return_format' => 'id',  // 'id' || 'url' || 'array'
                        'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                        'instructions' => 'Рекомендуемое разрешение изображения не более 600/320px.',
                        'required' => 1,
                    ),
                ),
            ),
            array(
                'key' => 'partners_first_btn',
                'label' => 'Первая кнопка',
                'name' => 'partners_first_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '50',
                ),
            ),
            array(
                'key' => 'partners_second_btn',
                'label' => 'Вторая кнопка',
                'name' => 'partners_second_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '50',
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
        'menu_order' => 10,
    ));
    // END partners section
    // ---------------------------------------------------------

    // BEGIN homeProducts section
    acf_add_local_field_group(array(
        'key' => 'acf_homeProducts_settings',
        'title' => 'Настройки каталога товаров',
        'fields' => array(
            array(
                'key' => 'homeProducts_boolean',
                'label' => 'Отображать блок?',
                'name' => 'homeProducts_boolean',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'homeProducts_title',
                'label' => 'Заголовок',
                'name' => 'homeProducts_title',
                'type' => 'text',
            ),
            array(
                'key' => 'homeProducts_desc',
                'label' => 'Описание',
                'name' => 'homeProducts_desc',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'homeProducts_relationship',
                'label' => 'Выберите товары',
                'name' => 'homeProducts_relationship',
                'type' => 'relationship',
                'instructions' => 'Выберите товары',
                'post_type' => array('product'),
                'filters' => array('search', 'taxonomy'),
                'return_format' => 'id',
                'min' => 0,
                'max' => 12,
                'elements' => array('featured_image'),
            ),
            array(
                'key' => 'homeProducts_first_btn',
                'label' => 'Первая кнопка',
                'name' => 'homeProducts_first_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '50',
                ),
            ),
            array(
                'key' => 'homeProducts_second_btn',
                'label' => 'Вторая кнопка',
                'name' => 'homeProducts_second_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '50',
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
        'menu_order' => 15,
    ));
    // END homeProducts section
    // ---------------------------------------------------------

    // BEGIN media_swiper section
    acf_add_local_field_group(array(
        'key' => 'acf_media_swiper_settings',
        'title' => 'Настройки контнет(слева) - слайдер(справа)',
        'fields' => array(
            array(
                'key' => 'media_swiper_boolean',
                'label' => 'Отображать блок?',
                'name' => 'media_swiper_boolean',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'media_swiper_title',
                'label' => 'Заголовок',
                'name' => 'media_swiper_title',
                'type' => 'text',
            ),
            array(
                'key' => 'media_swiper_content',
                'label' => 'Описание',
                'name' => 'media_swiper_content',
                'type' => 'wysiwyg',
                'tabs' => 'all',  // 'visual' || 'text' || 'all'
                'toolbar' => 'basic',  // 'basic' \\ 'full'
                'media_upload' => 0,
                'delay' => 0,
            ),
            array(
                'key' => 'media_swiper_first_btn',
                'label' => 'Кнопка',
                'name' => 'media_swiper_first_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '100',
                ),
            ),
            array(
                'key' => 'media_swiper_slides',
                'label' => 'Слайды',
                'name' => 'media_swiper_slides',
                'type' => 'repeater',
                'layout' => 'row',  // 'block' || 'row' || 'table'
                'button_label' => 'Добавить',
                'sub_fields' => array(
                    array(
                        'key' => 'media_swiper_slide_img_id',
                        'label' => 'Изображение',
                        'name' => 'media_swiper_slide_img_id',
                        'type' => 'image',
                        'return_format' => 'id',  // 'id' || 'url' || 'array'
                        'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                        'instructions' => 'Рекомендуемое разрешение изображения не более 400/600px.',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'media_swiper_label',
                        'label' => 'Этикетка',
                        'name' => 'media_swiper_label',
                        'type' => 'textarea',
                        'rows' => 1,
                        'required' => 1,
                    ),
                    array(
                        'key' => 'media_swiper_subtite',
                        'label' => 'Заголовок',
                        'name' => 'media_swiper_subtite',
                        'type' => 'text',
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
        'menu_order' => 20,
    ));
    // END media_swiper section
    // ---------------------------------------------------------

    // BEGIN hscroll section
    acf_add_local_field_group(array(
        'key' => 'acf_hscroll_settings',
        'title' => 'Настройки горизонтально скрола изображений',
        'fields' => array(
            array(
                'key' => 'hscroll_boolean',
                'label' => 'Отображать блок?',
                'name' => 'hscroll_boolean',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'hscroll_title',
                'label' => 'Заголовок',
                'name' => 'hscroll_title',
                'type' => 'text',
            ),
            array(
                'key' => 'hscroll_img_id_1',
                'label' => 'Изображение 1',
                'name' => 'hscroll_img_id_1',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '25',
                ),
            ),
            array(
                'key' => 'hscroll_img_id_2',
                'label' => 'Изображение 2',
                'name' => 'hscroll_img_id_2',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '25',
                ),
            ),
            array(
                'key' => 'hscroll_img_id_3',
                'label' => 'Изображение 3',
                'name' => 'hscroll_img_id_3',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '25',
                ),
            ),
            array(
                'key' => 'hscroll_img_id_4',
                'label' => 'Изображение 4',
                'name' => 'hscroll_img_id_4',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '25',
                ),
            ),
            array(
                'key' => 'hscroll_img_id_5',
                'label' => 'Изображение 5',
                'name' => 'hscroll_img_id_5',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '25',
                ),
            ),
            array(
                'key' => 'hscroll_img_id_6',
                'label' => 'Изображение 6',
                'name' => 'hscroll_img_id_6',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '25',
                ),
            ),
            array(
                'key' => 'hscroll_img_id_7',
                'label' => 'Изображение 7',
                'name' => 'hscroll_img_id_7',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '25',
                ),
            ),
            array(
                'key' => 'hscroll_img_id_8',
                'label' => 'Изображение 8',
                'name' => 'hscroll_img_id_8',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '25',
                ),
            ),
            array(
                'key' => 'hscroll_img_id_9',
                'label' => 'Изображение 9',
                'name' => 'hscroll_img_id_9',
                'type' => 'image',
                'return_format' => 'id',  // 'id' || 'url' || 'array'
                'preview_size' => 'thumbnail', // (thumbnail, medium, large, full or custom size)
                'required' => 1,
                'wrapper' => array (
                    'width' => '100',
                ),
            ),
            array(
                'key' => 'hscroll_first_btn',
                'label' => 'Первая кнопка',
                'name' => 'hscroll_first_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '50',
                ),
            ),
            array(
                'key' => 'hscroll_second_btn',
                'label' => 'Вторая кнопка',
                'name' => 'hscroll_second_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '50',
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
        'menu_order' => 90,
    ));
    // END hscroll section
    // ---------------------------------------------------------

    // BEGIN banner section
    acf_add_local_field_group(array(
        'key' => 'acf_banner_settings',
        'title' => 'Настройки банера',
        'fields' => array(
            array(
                'key' => 'banner_boolean',
                'label' => 'Отображать блок?',
                'name' => 'banner_boolean',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Да',
                'ui_off_text' => 'Нет',
            ),
            array(
                'key' => 'banner_slides',
                'label' => 'Слайды',
                'name' => 'banner_slides',
                'type' => 'repeater',
                'layout' => 'block',  // 'block' || 'row' || 'table'
                'button_label' => 'Добавить',
                'sub_fields' => array(
                    array(
                        'key' => 'banner_title',
                        'label' => 'Заголовок',
                        'name' => 'banner_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'banner_desc',
                        'label' => 'Описание',
                        'name' => 'banner_desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'banner_btn',
                        'label' => 'Кнопка',
                        'name' => 'banner_btn',
                        'type' => 'link',
                        'return_format' => 'array',
                    ),
                    array(
                        'key' => 'banner_img_id',
                        'label' => 'Изображение',
                        'name' => 'banner_img_id',
                        'type' => 'image',
                        'return_format' => 'id',  // 'id' || 'url' || 'array'
                        'preview_size' => 'medium', // (thumbnail, medium, large, full or custom size)
                        'instructions' => 'Рекомендуемое разрешение изображения не более 700/400px.',
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
    // END banner section
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
                'key' => 'test_content',
                'label' => 'Контент',
                'name' => 'test_content',
                'type' => 'wysiwyg',
                'tabs' => 'all',  // 'visual' || 'text' || 'all'
                'toolbar' => 'basic',  // 'basic' \\ 'full'
                'media_upload' => 0,
                'delay' => 0,
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
            array(
                'key' => 'test_first_btn',
                'label' => 'Первая кнопка',
                'name' => 'test_first_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '50',
                ),
            ),
            array(
                'key' => 'test_second_btn',
                'label' => 'Вторая кнопка',
                'name' => 'test_second_btn',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => array (
                    'width' => '50',
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

    // *********************************************************
    // *********************************************************

    // BEGIN POST TYPE product - основные поля
    acf_add_local_field_group(array(
        'key' => 'acf_product_settings',
        'title' => 'Настройки продукта',
        'fields' => array(
            // Изображение товара
            // array(
            //     'key' => 'product_image_id',
            //     'label' => 'Изображение товара',
            //     'name' => 'product_image_id',
            //     'type' => 'image',
            //     'preview_size' => 'thumbnail',
            //     'return_format' => 'id',  // 'id' || 'url' || 'array'
            //     'required' => 1,
            //     'wrapper' => array(
            //         'width' => '100',
            //     ),
            //     'instructions' => 'Загрузите основное изображение товара',
            // ),
            
            // Галерея изображений
            // array(
            //     'key' => 'product_gallery',
            //     'label' => 'Галерея изображений',
            //     'name' => 'product_gallery',
            //     'type' => 'gallery',
            //     'preview_size' => 'thumbnail',
            //     'return_format' => 'id',  // 'id' || 'url' || 'array'
            //     'required' => 0,
            //     'wrapper' => array(
            //         'width' => '100',
            //     ),
            //     'instructions' => 'Дополнительные изображения товара (необязательно)',
            // ),
            
            // Цена НЕ ИЗМЕНЯТЬ KEY, NAME
            array(
                'key' => 'product_price',
                'label' => 'Цена',
                'name' => 'product_price',
                'type' => 'number',
                'wrapper' => array(
                    'width' => '33',
                ),
                'instructions' => 'Цена в рублях',
                'required' => 0,
                'placeholder' => '1000.00',
                'prepend' => '₽',
                'step' => '0.01',
            ),
            
            // // Старая цена (со скидкой)
            // array(
            //     'key' => 'product_old_price',
            //     'label' => 'Старая цена',
            //     'name' => 'product_old_price',
            //     'type' => 'number',
            //     'wrapper' => array(
            //         'width' => '33',
            //     ),
            //     'instructions' => 'Цена до скидки (если есть акция)',
            //     'placeholder' => '1500.00',
            //     'prepend' => '₽',
            //     'step' => '0.01',
            // ),
            
            // Артикул
            array(
                'key' => 'product_sku',
                'label' => 'Артикул (SKU)',
                'name' => 'product_sku',
                'type' => 'text',
                'wrapper' => array(
                    'width' => '33',
                ),
                'instructions' => 'Уникальный артикул товара',
                'placeholder' => 'PRD-001',
            ),
            array(
                'key' => 'product_status',
                'label' => 'Статус',
                'name' => 'product_status',
                'type' => 'select',
                'allow_null' => 0,
                'multiple' => 0,
                // 'ui' => 1,
                'return_format' => 'array',  // 'array' || 'label'
                'choices' => [
                    'instock' => 'В наличии',   
                    'outofstock' => 'Нет в наличии',
                    'hidden' => 'Товар снят с продажи',
                ],
                'default_value' => 'instock',
                'instructions' => 'Статус товара',
                'wrapper' => array (
                    'width' => '33',
                ),
            ),
            array(
                'key' => 'product_quantity_step',
                'label' => 'Шаг количества',
                'name' => 'product_quantity_step',
                'type' => 'number',
                'wrapper' => array(
                    'width' => '33',
                ),
                'instructions' => 'Шаг изменения количества (по умолчанию 1000)',
                'default_value' => 1000,
                'min' => 1,
                'step' => 1,
            ),
            array(
                'key' => 'product_quantity_min',
                'label' => 'Минимальное количество',
                'name' => 'product_quantity_min',
                'type' => 'number',
                'wrapper' => array(
                    'width' => '33',
                ),
                'instructions' => 'Минимальное количество для заказа (по умолчанию 1000)',
                'default_value' => 1000,
                'min' => 1,
                'step' => 1,
            ),
            array(
                'key' => 'product_quantity_max',
                'label' => 'Максимальное количество',
                'name' => 'product_quantity_max',
                'type' => 'number',
                'wrapper' => array(
                    'width' => '33',
                ),
                'instructions' => 'Максимальное количество для заказа (по умолчанию 100000)',
                'default_value' => 100000,
                'min' => 1,
                'step' => 1,
            ),
            array(
                'key' => 'product_content',
                'label' => 'Контент (описание) товара',
                'name' => 'product_content',
                'type' => 'wysiwyg',
                'instructions' => 'Добавьте описание товара',
                'tabs' => 'all',  // 'visual' || 'text' || 'all'
                'toolbar' => 'basic',  // 'basic' \\ 'full'
                'media_upload' => 0,
                'delay' => 0,
                'wrapper' => array(
                    'width' => '50',
                ),
            ),
            array(
                'key' => 'product_characteristic',
                'label' => 'Характеристики',
                'name' => 'product_characteristic',
                'type' => 'wysiwyg',
                'instructions' => 'Добавьте характеристики товара',
                'tabs' => 'all',  // 'visual' || 'text' || 'all'
                'toolbar' => 'basic',  // 'basic' \\ 'full'
                'media_upload' => 0,
                'delay' => 0,
                'wrapper' => array(
                    'width' => '50',
                ),
            ),
            // ------------------------------- tab_product_specifications
            // array(
            //     'key' => 'tab_product_specifications',
            //     'label' => 'Характеристики', 
            //     'type' => 'tab',
            // ),
            // array(
            //     'key' => 'product_specifications',
            //     'label' => 'Характеристики ',
            //     'name' => 'product_specifications',
            //     'type' => 'repeater',
            //     'instructions' => 'Добавьте основные характеристики товара',
            //     'required' => 0,
            //     'min' => 0,
            //     'max' => 20,
            //     'layout' => 'table',
            //     'button_label' => 'Добавить характеристику',
            //     'sub_fields' => array(
            //         array(
            //             'key' => 'product_spec_name',
            //             'label' => 'Название характеристики',
            //             'name' => 'product_spec_name',
            //             'type' => 'text',
            //             'wrapper' => array(
            //                 'width' => '40',
            //             ),
            //         ),
            //         array(
            //             'key' => 'product_spec_value',
            //             'label' => 'Значение',
            //             'name' => 'product_spec_value',
            //             'type' => 'text',
            //             'wrapper' => array(
            //                 'width' => '60',
            //             ),
            //         ),
            //     ),
            // ),
            
            // // Наличие на складе
            // array(
            //     'key' => 'product_stock',
            //     'label' => 'Наличие на складе',
            //     'name' => 'product_stock',
            //     'type' => 'select',
            //     'choices' => array(
            //         'in_stock' => 'В наличии',
            //         'out_of_stock' => 'Нет в наличии',
            //         'preorder' => 'Предзаказ',
            //         'under_order' => 'Под заказ',
            //     ),
            //     'default_value' => 'in_stock',
            //     'wrapper' => array(
            //         'width' => '50',
            //     ),
            //     'instructions' => 'Текущий статус наличия товара',
            // ),
            
            // // Количество
            // array(
            //     'key' => 'product_quantity',
            //     'label' => 'Количество на складе',
            //     'name' => 'product_quantity',
            //     'type' => 'number',
            //     'wrapper' => array(
            //         'width' => '50',
            //     ),
            //     'instructions' => 'Точное количество единиц (для складского учёта)',
            //     'placeholder' => '10',
            //     'min' => 0,
            // ),
            
            // // Вес
            // array(
            //     'key' => 'product_weight',
            //     'label' => 'Вес',
            //     'name' => 'product_weight',
            //     'type' => 'number',
            //     'wrapper' => array(
            //         'width' => '33',
            //     ),
            //     'instructions' => 'Вес товара в кг',
            //     'placeholder' => '0.5',
            //     'step' => '0.01',
            //     'append' => 'кг',
            // ),
            
            // // Размеры
            // array(
            //     'key' => 'product_dimensions',
            //     'label' => 'Размеры (Д×Ш×В)',
            //     'name' => 'product_dimensions',
            //     'type' => 'text',
            //     'wrapper' => array(
            //         'width' => '67',
            //     ),
            //     'instructions' => 'Например: 10×20×30 см',
            //     'placeholder' => '10×20×30 см',
            // ),
            
            // // Видео (YouTube/Vimeo)
            // array(
            //     'key' => 'product_video_url',
            //     'label' => 'Ссылка на видео',
            //     'name' => 'product_video_url',
            //     'type' => 'url',
            //     'wrapper' => array(
            //         'width' => '100',
            //     ),
            //     'instructions' => 'Ссылка на YouTube или Vimeo видео обзора товара',
            //     'placeholder' => 'https://www.youtube.com/watch?v=...',
            // ),
            
            // // SEO заголовок
            // array(
            //     'key' => 'product_seo_title',
            //     'label' => 'SEO заголовок',
            //     'name' => 'product_seo_title',
            //     'type' => 'text',
            //     'wrapper' => array(
            //         'width' => '100',
            //     ),
            //     'instructions' => 'Meta Title (если пусто - используется заголовок товара)',
            //     'maxlength' => 70,
            // ),
            
            // // SEO описание
            // array(
            //     'key' => 'product_seo_description',
            //     'label' => 'SEO описание',
            //     'name' => 'product_seo_description',
            //     'type' => 'textarea',
            //     'wrapper' => array(
            //         'width' => '100',
            //     ),
            //     'instructions' => 'Meta Description (рекомендуемая длина 150-160 символов)',
            //     'rows' => 3,
            //     'maxlength' => 160,
            // ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                )
            ),
        ),
        'menu_order' => 1,
        'position' => 'acf_after_title', // Позиция после заголовка
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));



    // BEGIN дополнительная вкладка "Связанные товары"
    // acf_add_local_field_group(array(
    //     'key' => 'acf_product_related',
    //     'title' => 'Связанные товары',
    //     'fields' => array(
    //         array(
    //             'key' => 'product_bundle',
    //             'label' => 'Комплект товара',
    //             'name' => 'product_bundle',
    //             'type' => 'relationship',
    //             'instructions' => 'Выберите товары',
    //             'post_type' => array('product'),
    //             'filters' => array('search', 'taxonomy'),
    //             'return_format' => 'id',
    //             'min' => 0,
    //             'max' => 10,
    //             'elements' => array('featured_image'),
    //         ),
    //         array(
    //             'key' => 'product_related_products',
    //             'label' => 'Рекомендуемые товары',
    //             'name' => 'product_related_products',
    //             'type' => 'relationship',
    //             'instructions' => 'Выберите товары, которые рекомендуете вместе с этим',
    //             'post_type' => array('product'),
    //             'filters' => array('search', 'taxonomy'),
    //             'return_format' => 'id',
    //             'min' => 0,
    //             'max' => 10,
    //             'elements' => array('featured_image'),
    //         ),
    //         array(
    //             'key' => 'product_cross_sell',
    //             'label' => 'Сопутствующие товары (cross-sell)',
    //             'name' => 'product_cross_sell',
    //             'type' => 'relationship',
    //             'instructions' => 'Товары, которые часто покупают вместе (аксессуары)',
    //             'post_type' => array('product'),
    //             'filters' => array('search', 'taxonomy'),
    //             'return_format' => 'id',
    //             'min' => 0,
    //             'max' => 10,
    //             'elements' => array('featured_image'),
    //         ),
    //         array(
    //             'key' => 'product_up_sell',
    //             'label' => 'Более дорогие альтернативы (up-sell)',
    //             'name' => 'product_up_sell',
    //             'type' => 'relationship',
    //             'instructions' => 'Товары, которые можно предложить вместо этого (более дорогие)',
    //             'post_type' => array('product'),
    //             'filters' => array('search', 'taxonomy'),
    //             'return_format' => 'id',
    //             'min' => 0,
    //             'max' => 10,
    //             'elements' => array('featured_image'),
    //         ),
    //     ),
    //     'location' => array(
    //         array(
    //             array(
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => 'product',
    //             )
    //         ),
    //     ),
    //     'menu_order' => 3,
    // ));

    // // BEGIN дополнительная вкладка "Файлы"
    // acf_add_local_field_group(array(
    //     'key' => 'acf_product_files',
    //     'title' => 'Файлы для скачивания',
    //     'fields' => array(
    //         array(
    //             'key' => 'product_files',
    //             'label' => 'Файлы для скачивания',
    //             'name' => 'product_files',
    //             'type' => 'repeater',
    //             'instructions' => 'Добавьте инструкции, каталоги, сертификаты и другие файлы',
    //             'button_label' => 'Добавить файл',
    //             'sub_fields' => array(
    //                 array(
    //                     'key' => 'product_file_name',
    //                     'label' => 'Название файла',
    //                     'name' => 'product_file_name',
    //                     'type' => 'text',
    //                     'wrapper' => array(
    //                         'width' => '40',
    //                     ),
    //                     'placeholder' => 'Например: Инструкция по эксплуатации',
    //                     'required' => 1,
    //                 ),
    //                 array(
    //                     'key' => 'product_file',
    //                     'label' => 'Файл',
    //                     'name' => 'product_file',
    //                     'type' => 'file',
    //                     'wrapper' => array(
    //                         'width' => '60',
    //                     ),
    //                     'return_format' => 'url',
    //                     'required' => 1,
    //                 ),
    //             ),
    //         ),
    //     ),
    //     'location' => array(
    //         array(
    //             array(
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => 'product',
    //             )
    //         ),
    //     ),
    //     'menu_order' => 4,
    // ));

    // *********************************************************
    // *********************************************************
    // КАТЕГОРИЙ ПРОДУКТОВ
    acf_add_local_field_group(array(
        'key' => 'acf_product_category_settings',
        'title' => 'Изображение категории',
        'fields' => array(
            array(
                'key' => 'product_category_image',
                'label' => 'Изображение категории',
                'name' => 'product_category_image',
                'type' => 'image',
                'preview_size' => 'medium',
                'return_format' => 'id', // Возвращает массив с информацией об изображении
                'required' => 0,
                'wrapper' => array(
                    'width' => '100',
                ),
                'instructions' => 'Загрузите изображение для категории (рекомендуемый размер: 1440x800px)',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'product_category',
                )
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));

    acf_add_local_field_group(array(
        'key' => 'acf_product_tag_settings',
        'title' => 'Изображение метки',
        'fields' => array(
            array(
                'key' => 'product_tag_image',
                'label' => 'Изображение метки',
                'name' => 'product_tag_image',
                'type' => 'image',
                'preview_size' => 'medium',
                'return_format' => 'id', // Можно изменить на 'array' если нужно больше данных
                'required' => 0,
                'wrapper' => array(
                    'width' => '100',
                ),
                'instructions' => 'Загрузите изображение для метки (рекомендуемый размер: 1440x800px)',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'product_tag',
                )
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));


    // *********************************************************
    // *********************************************************





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












