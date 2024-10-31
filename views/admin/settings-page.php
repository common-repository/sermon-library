<div class="wrap">
    <h1>Sermon Library by White Harvest</h1>

    <form method="post" action="options.php">
        <?php 
            settings_fields('wh_sermons_settings'); 
            do_settings_sections('wh-sermons-settings');
            submit_button();
        ?>
    </form>
</div>