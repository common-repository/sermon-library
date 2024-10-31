<div class="wh_sermons_latest_widget" style="<?php echo $background_color_css; ?>">
    <?php if ( ! empty( $thumbnail ) ): ?>
        <div class="thumbnail">
            <?php echo '<img alt="audio" src="' . $thumbnail . '">'; ?>
        </div>
    <?php endif; ?>
    <?php if ( ! empty( $sermon ) || ! empty( $teacher ) ) : ?>
        <div class="details" style="<?php echo $title_color_css; ?>">
            <?php
                if ( ! empty( $sermon ) ) {
                    echo '<span class="sermon">' . $sermon . '</span>';
                }
                if ( ! empty( $teacher ) ) {
                    echo '<span class="teacher">by ' . $teacher . '</span>';
                } 
            ?>
        </div>
    <?php endif; ?>
    <audio preload="metadata" controls="" src="<?php echo $url; ?>"></audio>
    <?php if ( ! empty( $description )  ): ?>
        <div class="meta" style="<?php echo $footer_color_css; ?>">
            <?php echo $description; ?>
        </div>
    <?php endif; ?>
</div>
