<a href="#TB_inline?width=480&height=600&inlineId=wh-sermons-modal" class="button thickbox" id="wh-sermons-editor-button" title="Add Sermon Shortcode">
    <img src="<?php echo $wh_icon; ?>" />
    Add Sermon
</a>

<style type="text/css">
label.wh-label {
    font-weight: bold;
    width: 100px;
    display: inline-block;
}

.wh-sermon-list {
    display: block;
    float: left;
    margin: 10px 30px 10px 0px;
}

.wh-clear-fix {
    clear: both;
    width: 100%;
}
</style>


<div id="wh-sermons-modal" style="display: none;">
    <div id="wh-sermons-shortcode-editor" class="wrap">

        <h3>Configure Sermon Shortcode</h3>

        <form method="post" id="wh-sermon-settings">
            <div class="wh-sermon-list">
                <label class="wh-label">Series</label>
                <input type="text" class="regular-text" name="wh_sermons_series" id="wh_sermons_series" placeholder="All Series" />
                <p class="description">Comma separated list of series slugs:<br/>
                    <?php echo $series_slugs; ?>
                </p>
            </div>

            <div class="wh-sermon-list">
                <label class="wh-label">Teachers</label>
                <input type="text" class="regular-text" name="wh_sermons_teacher" id="wh_sermons_teacher" placeholder="All Teachers" />
                <p class="description">Comma separated list of teacher slugs:<br/>
                    <?php echo $teacher_slugs; ?>
                </p>
            </div>

            <div class="wh-clear-fix"></div>

            <div class="wh-sermon-list">
                <label class="wh-label">Books</label>
                <input type="text" class="regular-text" name="wh_sermons_books" id="wh_sermons_books" placeholder="All Books" />
                <p class="description">Comma separated list of book slugs:<br/>
                    <?php echo $book_slugs; ?>
                </p>
            </div>

            <div class="wh-sermon-list">
                <label class="wh-label">Page Size</label>
                <input type="text" name="wh_page_size" id="wh_page_size" placeholder="10" />
                <p class="description">Number of sermons shown per page.<br/>Default: 10</p>
            </div>

            <div class="wh-sermon-list">
                <label class="wh-label">Player</label>
                <ul>
                    <li><input type="radio" name="wh_player" value="HTML5" checked="checked"> HTML5 (recomended)</li>
                    <li><input type="radio" name="wh_player" value="WP"> WordPress Player</li>
                </ul>
            </div>

            <div class="wh-clear-fix"></div>

            <button class="button button-primary button-large" name="wh_insert_shortcode" id="wh_insert_shortcode">Insert Shortcode</button>
        </form> 
    </div>
</div>
