<?php if (get_field('footer_wp_form_relations', 'option')) {
    $form_id = get_field('footer_wp_form_relations', 'option');    
    ?>
    <div class="footer__col desktop footer_form">
    
        <div class="footer__form">
            <div class="footer__label hide_wp_success_js">Send Us a Message</div>
            <?php echo do_shortcode('[wpforms id="' . $form_id . '"]'); ?>
        </div>
        
    </div>
<?php } ?>