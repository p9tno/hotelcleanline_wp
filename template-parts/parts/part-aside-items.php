<?php 
$rows = get_field('aside_items', 'option');
if( $rows ) { ?>
    <?php foreach( $rows as $row ) { ?>
        
        <div class="aside__item aside__item_global <?php echo $row['aside_color']; ?>">
            <?php if ($row['aside_title']) { ?>
                <div class="aside__title"><?php echo $row['aside_title']; ?></div>
            <?php } ?>
            <?php if ($row['aside_text']) { ?>
                <div class="aside__text"><?php echo $row['aside_text']; ?></div>
            <?php } ?>
            <div class="aside__btns">
                <?php if ($row['aside_btn_first_btn']) { ?>
                    <?php 
                        $link = $row['aside_btn_first_btn'];
                        $title = $link['title'];
                        $url = $link['url'];
                        $target = $link['target'];
                    ?>
                        <a class="btn" href="<?php echo $url; ?>" <?php if ($target) { echo 'target="_blank"'; } ?>><?php echo $title; ?></a>
                <?php } ?>

                <?php if ($row['aside_btn_second_btn']) { ?>
                    <?php 
                        $link = $row['aside_btn_second_btn'];
                        $title = $link['title'];
                        $url = $link['url'];
                        $target = $link['target'];
                    ?>
                        <a class="btn" href="<?php echo $url; ?>" <?php if ($target) { echo 'target="_blank"'; } ?>><?php echo $title; ?></a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>