<?php
// Получаем главные категории
$parent_categories = get_terms(array(
    'taxonomy' => 'product_category',
    'parent' => 0,
    'hide_empty' => false,
    // 'orderby' => 'name',
    // 'order' => 'ASC'
    'orderby' => 'term_order',
    'order' => 'ASC',
));

if (!empty($parent_categories) && !is_wp_error($parent_categories)) : ?>
    <!-- begin topCategories -->
    <section class="topCategories section" id="topCategories">
        <div class="container_center container_center_sm">
            
            <h2 class="section__title">Категории продуктов</h2>
            <div class="section__desc">Выберите интересующую вас категорию</div>

            <div class="section__wrap">
                <div class="topCategories__grid">
                    
                    <?php 
                    foreach ($parent_categories as $category) {
                        $image_html = get_product_category_image_html($category->term_id);
                    ?>
                        <a class="topCategories__item" href="<?php echo esc_url(get_term_link($category)); ?>">
                            <div class="topCategories__img img"><?php echo $image_html; ?></div>
                            <div class="topCategories__title"><?php echo esc_html($category->name); ?></div>
                            <?php // if ($category->count > 0) : ?>
                                <!-- <div class="topCategories__count"><?php // echo $category->count; ?> товаров</div> -->
                            <?php // endif; ?>
                        </a>
                    <?php 
                    }
                    ?>
                    
                </div>
            </div>
            
            <div class="section__btns">
                <a class="btn" href="<?php echo esc_url(get_post_type_archive_link('product')); ?>">Все товары</a>
            </div>
            
        </div>
    </section>
    <!-- end topCategories -->
    
<?php endif; ?>