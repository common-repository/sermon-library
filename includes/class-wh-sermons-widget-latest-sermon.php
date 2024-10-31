<?php 
class WH_Sermons_Widget_Latest_Sermon extends WP_Widget {

    public function __construct() {
        $options = array(
            'classname' => 'WH_Sermons_Widget_Latest_Sermon',
            'description' => 'Show a mini-player for the latest sermon from the selected series.'
        );

        parent::__construct( 'wh-sermons-widget-latest-sermon', 'WH - Latest Sermon', $options );
    }

    public static function register() {
        register_widget('WH_Sermons_Widget_Latest_Sermon');
    }

    /**
     * Front end display for widget
     */
    public function widget( $args, $instance ) {
        $title             = isset( $instance['title'] ) ? $instance['title'] : '';
        $slug              = isset( $instance['wh_sermons_latest_term'] ) ? $instance['wh_sermons_latest_term'] : '';
        $background_color  = isset( $instance['background_color'] ) ? $instance['background_color'] : '';
        $footer_color      = isset( $instance['footer_color'] ) ? $instance['footer_color'] : '';
        $border_color      = isset( $instance['border_color'] ) ? $instance['border_color'] : '';
        $title_color       = isset( $instance['title_color'] ) ? $instance['title_color'] : '';
        $description_color = isset( $instance['description_color'] ) ? $instance['description_color'] : '';

        // Filter the title
        $title = apply_filters( 'widget_title', $title );

        $attrs = array(
            'series' => $slug,
            'background_color' => $background_color,
            'footer_color' => $footer_color,
            'border_color' => $border_color,
            'title_color' => $title_color,
            'description_color' => $description_color,
        );

        // Build shortcode for wh_sermons_latest
        $attr_list = array();
        foreach ( $attrs as $name => $value ) {
            $attr_list[] = $name . '="' . $value . '"';
        }

        $shortcode = '[wh_sermons_latest ' . implode(' ', $attr_list) . ']';
        WH_Sermons_Log::write("Shortcode: $shortcode");

        $attrs = implode(' ', $attr_list);
        $view = $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
        $view .= do_shortcode( $shortcode );
        $view .= $args['after_widget'];

        echo $view;
    }

    /**
     * The admin form to display for the widget
     */
    public function form( $instance ) {
        $title             = isset( $instance['title'] ) ? $instance['title'] : '';
        $selected_term     = isset( $instance['wh_sermons_latest_term'] ) ? $instance['wh_sermons_latest_term'] : '';
        $background_color  = isset( $instance['background_color'] ) ? $instance['background_color'] : '';
        $footer_color      = isset( $instance['footer_color'] ) ? $instance['footer_color'] : '';
        $border_color      = isset( $instance['border_color'] ) ? $instance['border_color'] : '';
        $title_color       = isset( $instance['title_color'] ) ? $instance['title_color'] : '';
        $description_color = isset( $instance['description_color'] ) ? $instance['description_color'] : '';

        $series_terms = get_terms([
            'taxonomy' => 'wh_sermons_series',
            'orderby' => 'name',
            'hide_empty' => false
        ]);

        $data = [
            'title' => $title,
            'series_terms' => $series_terms,
            'selected_term' => $selected_term,
            'background_color' => $background_color,
            'footer_color' => $footer_color,
            'border_color' => $border_color,
            'title_color' => $title_color,
            'description_color' => $description_color,
            'widget' => $this
        ];

        $path = WH_Sermons::view_path() . 'admin/widget-latest.php';
        $view = WH_Sermons_View::get( $path, $data );

        echo $view;
    }

    /**
     * Save the changes when the widget is updated
     */
    public function update( $new, $old ) {
        $instance = $old;
        $instance['title'] = $new['title'];
        $instance['wh_sermons_latest_term'] = $new['wh_sermons_latest_term'];
        $instance['background_color'] = $new['background_color'];
        $instance['footer_color'] = $new['footer_color'];
        $instance['border_color'] = $new['border_color'];
        $instance['title_color'] = $new['title_color'];
        $instance['description_color'] = $new['description_color'];

        return $instance;
    }

}
