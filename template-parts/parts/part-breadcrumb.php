<?php if (
    !is_page_template(['template-homepage.php']) && 
    !is_page_template(['template-thank.php']) && 
    !is_404() &&
    // !is_archive() &&
    !is_page_template(['template-quiz.php'])

    ) { ?>
    <!-- begin breadcrumbs-->
    <div class="breadcrumbs">
        <?php kama_breadcrumbs(''); ?>
    </div>
    <!-- end breadcrumbs -->
    <?php } ?>
    