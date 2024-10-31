<style type="text/css">
  #wh_sermons_scripture_reference {
    width: 100%;
    height: 4em;
  }
</style>
<label class="screen-reader-text" for="wh_sermons_scripture_reference">Description / Scripture Reference</label>
<textarea rows="1" cols="40" name="wh_sermons_scripture_reference" id="wh_sermons_scripture_reference"><?php echo $scripture_reference; ?></textarea>
<?php wp_nonce_field( 'save_wh_sermons_scripture_reference', 'wh_sermons_scripture_reference_nonce'); ?>
<p>This appears in the footer description when using the Latest Sermon widget or the latest sermon shortcode. <br><code>[wh_sermons_latest]</code></p>