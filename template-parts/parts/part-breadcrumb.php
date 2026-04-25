<?php if (
    !is_page_template(['template-homepage.php']) && 
    !is_page_template(['template-thank.php']) && 
    !is_404() &&
    // !is_archive() &&
    !is_page_template(['template-quiz.php'])

    ) { ?>

        <!-- begin breadcrumbs -->
        <section id="breadcrumbs" class="breadcrumbs section">
            <div class="container_center">
                <a id="back-btn" class="breadcrumb__back mobile" href="#">
                    <i class="icon_arrow_left_sm"></i>
                   <span>Назад</span>
                </a>
                <div class="breadcrumbs__content desktop">
                    <?php kama_breadcrumbs(''); ?>
                </div>
            </div>
        </section>
        <!-- end breadcrumbs -->

    <?php } ?>
    