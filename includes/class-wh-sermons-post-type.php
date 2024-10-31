<?php

class WH_Sermons_Post_Type {

    protected static $instance;
    protected static $slugs;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function init() {
        $instance = self::get_instance();
        $instance->load_slugs();
        $instance->create_post_type();
        $instance->create_series();
        $instance->create_teachers();
        $instance->create_books();

        add_action(
            'admin_init',
            array( 'WH_Sermons_Post_Type', 'relocate_series_meta_box'),
            0
        );

        add_action( 'add_meta_boxes_wh_sermons', function( $post ) {
            add_meta_box(
                'wh_sermons_scripture',
                'Description / Scripture Reference',
                function( $post ) {
                    WH_Sermons_Log::write( 'Adding scripture reference meta box for post: ' . print_r( $post->ID, true ) );
                    $scripture_reference = get_post_meta( $post->ID, '_scripture_reference', true );
                    $data = array( 'scripture_reference' => $scripture_reference );
                    $view = WH_Sermons_View::get( WH_Sermons::view_path() . 'scripture-reference-meta-box.php', $data );
                    echo $view;
                },
                'wh_sermons',
                'normal',
                'high',
                array ( 'taxonomy' => 'wh_sermons_series' )
            );

            add_meta_box (
                'wh_sermons_cart66',
                '<span style="color: #35495E" class="dashicons dashicons-cart"></span> Add Ecommerce',
                function( $post ) {
                    $data = array();
                    $data['cart66'] = WH_Sermons::plugin_url() . 'assets/images/cart66-logo_500x125.png';
                    $data['ichthys'] = WH_Sermons::plugin_url() . 'assets/images/ichthys_80.png';
                    $view = WH_Sermons_View::get( WH_Sermons::view_path() . 'admin/box-cart66.php', $data );
                    echo $view;
                },
                'wh_sermons',
                'side',
                'low'
            );

            add_meta_box (
                'wh_sermons_whiteharvest',
                '<span style="color: #51737d;" class="dashicons dashicons-sos"></span> Need Help?',
                function( $post ) {
                    $data = array();
                    $data['whiteharvest'] = WH_Sermons::plugin_url() . 'assets/images/white-harvest_430x52.png';
                    $data['ichthys'] = WH_Sermons::plugin_url() . 'assets/images/ichthys_80.png';
                    $view = WH_Sermons_View::get( WH_Sermons::view_path() . 'admin/box-white-harvest.php', $data );
                    echo $view;
                },
                'wh_sermons',
                'side',
                'low'
            );

            add_meta_box(
                'wh_sermons_links',
                '<span style="color: red;" class="dashicons dashicons-heart"></span> Help Us Help You - Save money on great services',
                function( $post ) {
                    $data = array();
                    $data['flywheel'] = WH_Sermons::plugin_url() . 'assets/images/flywheel-banner.jpg';
                    $data['blubrry'] = WH_Sermons::plugin_url() . 'assets/images/blubrry-banner.jpg';
                    $data['transcribeme'] = WH_Sermons::plugin_url() . 'assets/images/transcribe-me-banner.jpg';
                    $view = WH_Sermons_View::get( WH_Sermons::view_path() . 'admin/box-resources.php', $data );
                    echo $view;
                },
                'wh_sermons',
                'normal',
                'low'
            );
        });

        add_action( 'save_post_wh_sermons', function( $post_id) {
            // Verify nonce
            if ( 
                ! isset( $_POST['wh_sermons_scripture_reference_nonce'] ) || 
                ! wp_verify_nonce( $_POST['wh_sermons_scripture_reference_nonce'], 'save_wh_sermons_scripture_reference' ) 
            ) { return; }

            // Ignore autosave
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                return;
            }

            // Save scripture reference
            if ( isset( $_REQUEST['wh_sermons_scripture_reference'] ) ) {
                $scripture_reference = sanitize_text_field( $_REQUEST['wh_sermons_scripture_reference'] );
                update_post_meta( $post_id, '_scripture_reference', $scripture_reference );
            }

        }, 10, 2);
    }

    public function load_slugs() {
        $sermon_options = get_option('wh_sermons_options');
        $sermons_slug   = isset( $sermon_options['sermons_slug'] ) ? $sermon_options['sermons_slug'] : 'sermons';
        $books_slug     = isset( $sermon_options['books_slug'] ) ? $sermon_options['books_slug'] : 'books';
        $series_slug    = isset( $sermon_options['series_slug'] ) ? $sermon_options['series_slug'] : 'series';
        $teachers_slug  = isset( $sermon_options['teachers_slug'] ) ? $sermon_options['teachers_slug'] : 'teachers';

        self::$slugs = [
            'sermons'  => $sermons_slug,
            'books'    => $books_slug,
            'series'   => $series_slug,
            'teachers' => $teachers_slug
        ];
    }

    public function create_post_type() {

        $labels = array(
            'name'               => __( 'Sermons', 'wh_sermons' ),
            'singular_name'      => __( 'Sermon', 'wh_sermons' ),
            'menu_name'          => __( 'Sermons', 'wh_sermons' ),
            'parent_item_colon'  => __( 'Parent Media', 'wh_sermons' ),
            'all_items'          => __( 'All Sermons', 'wh_sermons' ),
            'view_item'          => __( 'View Sermons', 'wh_sermons' ),
            'add_new_item'       => __( 'Add New Sermon', 'wh_sermons' ),
            'add_new'            => __( 'Add New', 'wh_sermons' ),
            'edit_item'          => __( 'Edit Sermon', 'wh_sermons' ),
            'update_item'        => __( 'Update Sermon', 'wh_sermons' ),
            'search_items'       => __( 'Search Sermons', 'wh_sermons' ),
            'not_found'          => __( 'Not Found', 'wh_sermons' ),
            'not_found_in_trash' => __( 'Not found in Trash', 'wh_sermons' ),
        );

        $options = array (
            'description' => 'White Harvest Sermons',
            'labels' => $labels,
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
            'taxonomies' => array( 'wh_sermons_series' ),
            'hierarchcical' => true,
            'capability_type' => 'page',
            'public' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => self::$slugs['sermons'] ),
            'menu_icon' => 'dashicons-book-alt'
        );

        register_post_type( 'wh_sermons', $options );
    }

    public function create_series() {
        $labels = array(
            'name' => 'Series',
            'singular_name' => 'Series',
        );

        $options = array(
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => self::$slugs['series'] )
        );

        register_taxonomy (
            'wh_sermons_series',
            'wh_sermons',
            $options
        );
    }

    public function create_teachers() {
        $labels = array(
            'name' => 'Teachers',
            'singular_name' => 'Teacher',
        );

        $options = array(
            'labels' => $labels,
            'hierarchical' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => self::$slugs['teachers'] )
        );

        register_taxonomy (
            'wh_sermons_teacher',
            'wh_sermons',
            $options
        );
    }

    public function create_books() {
        $labels = array(
            'name' => 'Books',
            'singular_name' => 'Book',
        );

        $options = array(
            'labels' => $labels,
            'hierarchical' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => self::$slugs['books'] )
        );

        register_taxonomy (
            'wh_sermons_books',
            'wh_sermons',
            $options
        );
    }

    public static function relocate_series_meta_box() {
        remove_meta_box( 'wh_sermons_seriesdiv', 'wh_sermons', 'side' );
        add_meta_box(
            'wh_sermons_seriesdiv',
            'Sermon Series',
            'post_categories_meta_box',
            'wh_sermons',
            'normal',
            'high',
            array (
                'taxonomy' => 'wh_sermons_series'
            )
        );
    }

    public static function get_links_for( $post, $taxonomy, $args=array() ) {
        $links = array();
        $terms = wp_get_post_terms( $post, $taxonomy, $args );
        foreach ( $terms as $term ) {
            $link = get_term_link( $term, $taxonomy );

            /**
             * Uncomment this line if you want taxonomies linked to their archive views
             * $links[] = "<a href='$link'>$term->name</a>";
             */
            
            /**
             * Uncomment this link if you do NOT want to link taxonomies to their archive views
             */
            $links[] = $term->name;
        }

        return $links;
    }

}
