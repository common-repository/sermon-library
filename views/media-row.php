        <tr>
            <td class="date"><?php echo date( "m/d/Y", strtotime($post->post_date) ); ?></td>
            <td class="title">
                <?php $featured_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>
                <?php  if ( ! empty( $featured_image ) ): ?>
                    <img src="<?php echo $featured_image; ?>" height="75" width="75" class="playlist" />
                <?php endif; ?>

                <a href="<?php echo get_permalink( $post->ID ); ?>" class="wh_sermons_action_link">
                    <?php echo $post->post_title ?>
                    <?php if ( ! empty( $scripture_reference ) ): ?>
                        <span class="scripture-reference">(<?php echo $scripture_reference; ?>)</span>
                    <?php endif; ?>
                </a><br>
                
                <span class="reference">
                    <?php echo $books ?>

                    <?php if ( ! empty( $books ) ): ?>
                        &ndash;
                    <?php endif; ?>

                    <?php echo $series; ?>

                    <?php if ( ! empty( $study_ref ) ): ?>
                        &ndash; Study&nbsp;Reference:&nbsp;<?php echo $study_ref; ?>
                    <?php endif; ?>

                    <?php if ( ! empty( $teachers ) ): ?>
                        &ndash; <?php echo $teachers; ?>
                    <?php endif; ?>
                </span>

                <!-- Sermon excerpt -->
                <?php if ( ! empty( $post->post_excerpt ) ): ?>
                    <br>
                    <span class="wh_sermon_excerpt">
                        <?php echo $post->post_excerpt; ?>
                    </span>
                <?php endif; ?>

                <!-- Audio player -->
				<?php
                    $audio_url = WH_Sermons_Helpers::get_audio_url( $post->ID );
                    WH_Sermons_Log::write( "Audio URL: $audio_url" );
                    if ( $player == 'WP') {
                        echo do_shortcode('[audio src="' . $audio_url . '"]');
                    }
                    else {
                        ?>
                        <audio preload="metadata" controls="" style="width: 100%;" src="<?php echo $audio_url; ?>"></audio>
                        <?php
                    }
                ?>
                
            </td>
        </tr>
