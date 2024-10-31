<?php wp_nonce_field( 'save_media_links', 'media_links_nonce' ); ?>

<div>
    <input type="text" id="wh_sermons_link_audio" name="wh_sermons_link_audio" class="large-text" placeholder="Audio Link"  value="<?php echo $wh_sermons_link_audio ?>" />
    <p class="description">Audio resource link</p>
</div>

<div>
    <input type="text" id="wh_sermons_link_video" name="wh_sermons_link_video" class="large-text" placeholder="Video Link"  value="<?php echo $wh_sermons_link_video ?>" />
    <p class="description">Video resource link</p>
</div>

<div>
    <input type="text" id="wh_sermons_link_pdf" name="wh_sermons_link_pdf" class="large-text" placeholder="PDF Link"  value="<?php echo $wh_sermons_link_pdf ?>" />
    <p class="description">PDF resource link - Notes / Homework</p>
</div>

<div>
    <input type="text" id="wh_sermons_study_reference" name="wh_sermons_study_reference" class="large-text" placeholder="Study Reference Number"  value="<?php echo $wh_sermons_study_reference ?>" />
    <p class="description">Study Reference Number</p>
</div>
