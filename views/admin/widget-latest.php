<div class="text-widget-fields">
    <p>
        <label for="<?php echo $widget->get_field_id( 'title' ); ?>">Title:</label>
        <input 
            type="text" 
            class="widefat title" 
            id="<?php echo $widget->get_field_id( 'title' ); ?>" 
            name="<?php echo $widget->get_field_name( 'title' ); ?>" 
            value="<?php echo esc_attr( $title ); ?>" 
        />
    </p>
</div>

<p>Show a player for the latest sermon from the series selected below:</p>

<ul>
<?php foreach( $series_terms as $term ): ?>
    <?php $checked = ( $selected_term == $term->slug ) ? 'checked="checked"' : ''; ?>
    <li><input type="radio" 
        id="<?php echo $widget->get_field_id('wh_sermons_latest_term'); ?>"
        name="<?php echo $widget->get_field_name('wh_sermons_latest_term'); ?>" 
        value="<?php echo $term->slug; ?>" <?php echo $checked; ?>> <?php echo $term->name; ?> 
        (<?php echo $term->count; ?>)
    </li>
<?php endforeach; ?>
</ul>

<p>Specify colors for the sermon player.</p>
 <div class="text-widget-fields">
    <p>
        <label for="<?php echo $widget->get_field_id( 'background_color' ); ?>">Background color:</label>
        <input 
            type="text" 
            class="widefat title" 
            id="<?php echo $widget->get_field_id( 'background_color' ); ?>" 
            name="<?php echo $widget->get_field_name( 'background_color' ); ?>" 
            value="<?php echo esc_attr( $background_color ); ?>" 
            placeholder="#050505"
        />
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id( 'border_color' ); ?>">Border color:</label>
        <input 
            type="text" 
            class="widefat title" 
            id="<?php echo $widget->get_field_id( 'border_color' ); ?>" 
            name="<?php echo $widget->get_field_name( 'border_color' ); ?>" 
            value="<?php echo esc_attr( $border_color ); ?>" 
            placeholder="#CCCCCC"
        />
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id( 'title' ); ?>">Title color:</label>
        <input 
            type="text" 
            class="widefat title" 
            id="<?php echo $widget->get_field_id( 'title_color' ); ?>" 
            name="<?php echo $widget->get_field_name( 'title_color' ); ?>" 
            value="<?php echo esc_attr( $title_color ); ?>" 
            placeholder="#FFFFFF"
        />
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id( 'footer_color' ); ?>">Description background color:</label>
        <input 
            type="text" 
            class="widefat title" 
            id="<?php echo $widget->get_field_id( 'footer_color' ); ?>" 
            name="<?php echo $widget->get_field_name( 'footer_color' ); ?>" 
            value="<?php echo esc_attr( $footer_color ); ?>" 
            placeholder="#EFEFF0"
        />
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id( 'title' ); ?>">Description text color:</label>
        <input 
            type="text" 
            class="widefat title" 
            id="<?php echo $widget->get_field_id( 'description_color' ); ?>" 
            name="<?php echo $widget->get_field_name( 'description_color' ); ?>" 
            value="<?php echo esc_attr( $description_color ); ?>" 
            placeholder="#060606"
        />
    </p>
</div>