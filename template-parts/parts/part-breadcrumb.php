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
                <div class="breadcrumbs__content">
                    <?php kama_breadcrumbs(''); ?>
                </div>
            </div>
        </section>
        <!-- end breadcrumbs -->

    <?php } ?>
    