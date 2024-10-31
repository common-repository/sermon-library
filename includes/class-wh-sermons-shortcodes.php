<?php

class WH_Sermons_Shortcodes {

    public static function init() {
        self::register_shortcodes();
    }

    public static function register_shortcodes() {
        add_shortcode( 'wh_sermons', array( 'WH_Sermons_Shortcodes', 'wh_sermons' ) );
        add_shortcode( 'wh_sermons_latest', array( 'WH_Sermons_Shortcodes', 'wh_sermons_latest') );
    }

    /**
     * Show the library of sermons.
     *
     * The library can be filterd with the following parameters:
     *
     * series: CSV list of series slugs
     * teacher: CSV list of teacher slugs
     * books: CSV list of book slugs
     * order: Either asc or desc (Default: desc)
     * limit: The max number of sermons to load into the library (Default: 1,000)
     * page_size: The number of sermons to show per page (Default: 10)
     * player: HTML5 of WP (Default: HTML5)
     */
    public static function wh_sermons( $attrs, $content ) {
        // Set default attributes
        $attrs = shortcode_atts (
            array(
                'series' => 'all',
                'teacher' => 'all',
                'books' => 'all',
                'order' => 'desc',
                'limit' => 1000,
                'page_size' => 10,
                'player' => 'HTML5'
            ),
            $attrs,
            'wh_sermons'
        );

        $series  = $attrs['series'];
        $teacher = $attrs['teacher'];
        $books   = $attrs['books'];
        $order   = $attrs['order'];
        $limit   = $attrs['limit'];
        $player  = strtoupper( $attrs['player'] );

        $table_template = WH_Sermons::view_path() . 'media-table.php';
        $table = WH_Sermons_View::get( $table_template, array(
            'page_size' => $attrs['page_size'],
            'player' => $player
        ) );

        $row_template = WH_Sermons::view_path() . 'media-row.php';
        $rows = '';

        // Make sure $order has a valid value
        $order = strtolower( $order );
        $sort_values = array('desc', 'asc');
        if ( ! in_array( $order, $sort_values ) ) {
            $order = 'desc';
        }

        $args = array( 
            'post_type' => 'wh_sermons', 
            'nopaging' => 'true', 
            'tax_query' => null,
            'order' => $order
        );

        // Incorporate book filters
        if ( 'all' != $books ) {
            $book_params = array(
                'taxonomy' => 'wh_sermons_books',
                'field' => 'slug',
                'terms' => str_getcsv( $books )
            );
            $args['tax_query'][] = $book_params;
        }

        // Incorporate series filters
        if ( 'all' != $series ) {
            $series_params = array(
                'taxonomy' => 'wh_sermons_series',
                'field' => 'slug',
                'terms' => str_getcsv( $series )
            );
            $args['tax_query'][] = $series_params;
        }

        // Incorporate series filters
        if ( 'all' != $teacher ) {
            $teacher_params = array(
                'taxonomy' => 'wh_sermons_teacher',
                'field' => 'slug',
                'terms' => str_getcsv( $teacher )
            );
            $args['tax_query'][] = $teacher_params;
        }

        $media = new WP_Query( $args );

        $dbg_sql = $media->request;
        WH_Sermons_Log::write( "Working with media query: $dbg_sql \n\n" . print_r( $args, true ) );

        $i = 0;
        while ( $media->have_posts() && $i < $limit ) {
            $i++;
            $media->the_post();
            
            $book_names    = WH_Sermons_Post_Type::get_links_for( $media->post->ID, 'wh_sermons_books' );
            $series_names  = WH_Sermons_Post_Type::get_links_for( $media->post->ID, 'wh_sermons_series', array('orderby' => 'parent') );
            $teacher_names = WH_Sermons_Post_Type::get_links_for( $media->post->ID, 'wh_sermons_teacher' );
            $video_link = '';
            $audio_link = '';
            $pdf_link = '';

            $scripture_reference  = get_post_meta( $media->post->ID, '_scripture_reference', true );

            $rows .= WH_Sermons_View::get( $row_template, array (
                'post' => $media->post,
                'books' => implode(', ', $book_names),
                'series' => implode(', ', $series_names),
                'teachers' => implode(', ', $teacher_names),
                'video_link' => $video_link,
                'audio_link' => $audio_link,
                'pdf_link' => $pdf_link,
                'scripture_reference' => $scripture_reference,
                'player' => $player
            ) );
        }

        $view = str_replace( '{{media_rows}}', $rows, $table );
        return $view;
    }

    public static function wh_sermons_latest( $attrs, $content ) {
        $widget_title      = isset( $attrs['title'] ) ? $attrs['title'] : '';
        $series_slugs      = isset( $attrs['series'] ) ? $attrs['series'] : false;
        $background_color  = isset( $attrs['background_color'] ) ? $attrs['background_color'] : '';
        $footer_color      = isset( $attrs['footer_color'] ) ? $attrs['footer_color'] : '';
        $border_color      = isset( $attrs['border_color'] ) ? $attrs['border_color'] : '';
        $title_color       = isset( $attrs['title_color'] ) ? $attrs['title_color'] : '';
        $description_color = isset( $attrs['description_color'] ) ? $attrs['description_color'] : '';

        // Write background color css if provided
        $background_color_css = '';
        if ( !empty( $background_color ) ) {
            $background_color_css .= 'background-color: ' . $background_color . '; ';
        }

        if ( !empty( $border_color ) ) {
            $background_color_css .= 'border-color: ' . $border_color . '; ';
        }

        // Write title color css if provided
        $title_color_css = '';
        if ( !empty( $title_color ) ) {
            $title_color_css .= 'color: ' . $title_color . '; ';
        }

        // Write footer color css if provided
        $footer_color_css = '';
        if ( !empty( $footer_color ) ) {
            $footer_color_css .= 'background-color: ' . $footer_color . '; ';
        }

        if ( !empty( $description_color ) ) {
            $footer_color_css .= 'color: ' . $description_color . '; ';
        }

        // Default instance values
        $data = array (
            'title' => "Sermon title not set",
            'teacher' => 'Pastor name not set',
            'sermon' => 'Sermon name not set',
            'url' => '',
            'description' => ''
        );

        $args = array ( 'post_type' => 'wh_sermons' );

        if ( false !== $series_slugs ) {
            $args['tax_query'] = array (
                array (
                    'taxonomy' => 'wh_sermons_series',
                    'field' => 'slug',
                    'terms' => str_getcsv( $series_slugs )
                )
            );
        }

        WH_Sermons_Log::write( print_r( $args, true ) );
        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            $query->the_post();
            $post = get_post();
            $data = array (
                'title' => $widget_title,
                'teacher' => WH_Sermons_Helpers::get_teachers( $post->ID ),
                'sermon' => $post->post_title,
                'url' => WH_Sermons_Helpers::get_audio_url( $post->ID ),
                'description' => strip_tags( get_post_meta( $post->ID, '_scripture_reference', true ) ),
                'background_color_css' => $background_color_css,
                'footer_color_css' => $footer_color_css,
                'title_color_css' => $title_color_css
            );
        }
        
        $view = WH_Sermons_View::get( WH_Sermons::view_path() . 'latest-widget.php', $data ); 
        // WH_Sermons_Log::write( print_r( $data, true ) );   
        // WH_Sermons_Log::write( $view );

        return $view;
    }
}
