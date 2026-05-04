// cart.js
(function($) {
    'use strict';
    $(document).ready(function() {

        // ===== ГЕНЕРАЦИЯ КАРТОЧЕК ДЛЯ МОДАЛЬНОГО ОКНА =====
        
        function generateProductCard(product) {
            const imageHTML = product.thumbnail_html || '';
            const imageSecondHTML = product.thumbnail_second_html || '';
            const priceHTML = product.price_formatted || '';
            const buyButtonHTML = product.add_to_cart_html || '';
            
            let bundleHTML = '';
            if (product.has_bundle && product.bundle_products && product.bundle_products.length > 0) {
                product.bundle_products.forEach(bundleItem => {
                    bundleHTML += bundleItem.html || '';
                });
            }
            
            return `
                <div class="mProduct" id="mProduct-${product.id}">
                    <div class="mProduct__row">
                        <div class="mProduct__col">
                            <div class="mProduct__img img">
                                ${imageSecondHTML}
                                <div class="mProduct__label glass_card">
                                    <div class="mProduct__title product__title">Упаковка</div>
                                </div>
                            </div>
                        </div>
                        <div class="mProduct__col">
                            <a class="mProduct__img img" href="${product.permalink}" target="_blank">
                                ${imageHTML}
                                <div class="mProduct__label glass_card">
                                    <div class="mProduct__title product__title">Фото товара</div>
                                </div>
                            </a>
                        </div>
                        <div class="mProduct__col">
                            ${bundleHTML ? `<div class="mProduct__bundle">${bundleHTML}</div>` : ''}
                        </div>
                    </div>

                    <div class="mProduct__row">
                        <div class="mProduct__col flex">
                            <a href="${product.permalink}" target="_blank" class="mProduct__title product__title line_clamp">${product.title}</a>
                            <div class="mProduct__sku product__sku"><strong>Артикул:</strong> ${product.sku || '—'}</div>
                        </div>
              
                        <div class="mProduct__col flex jc_sb">
                            <div class="mProduct__price"><strong>Цена: </strong>${priceHTML}</div>
                            <div class="mProduct__button">${buyButtonHTML}</div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        function setModalContent(products) {
            let productsHTML = '';
            
            if (products && products.length > 0) {
                products.forEach(product => {
                    productsHTML += generateProductCard(product);
                });
            } else {
                productsHTML = '<div class="no-products">В этой категории пока нет товаров</div>';
            }
            return productsHTML;
        }
        
        // ===== МОДАЛЬНОЕ ОКНО =====
        const tagTriggers = document.querySelectorAll('.show_tag_products_js');
        
        if (tagTriggers.length > 0) {
            tagTriggers.forEach((trigger) => {
                trigger.addEventListener('click', (e) => {
                    let tagId = null;
                    let categoryId = null;
                    
                    if (trigger.dataset.tagId) {
                        tagId = parseInt(trigger.dataset.tagId);
                    }
                    if (trigger.dataset.categoryId) {
                        categoryId = parseInt(trigger.dataset.categoryId);
                    }
                    
                    if (typeof productsCombinations === 'undefined') {
                        console.error('productsCombinations не определен');
                        return;
                    }
                    
                    let combo = null;
                    if (tagId && categoryId) {
                        combo = productsCombinations.find(c => c.category_id === categoryId && c.tag_id === tagId);
                    }
                    
                    if (combo) {
                        const modal = document.querySelector('#tag-products');
                        const modalBody = modal ? modal.querySelector('.modal-body') : null;
                        
                        if (modalBody) {
                            modalBody.innerHTML = setModalContent(combo.products);
                            $(modal).modal('show');
                        } else {
                            console.error('Модальное окно #tag-products или его .modal-body не найдены');
                        }
                    } else {
                        console.error('Не найдены товары для этой комбинации', { tagId, categoryId });
                    }
                });
            });
        }

    });
})(jQuery);