<?php

class WH_Sermons_Admin {

    public static function init() {

        // Add filters for admin
        add_filter(
            'wp_terms_checklist_args',
            array('WH_Sermons_Admin', 'keep_checklist_heirarchy'),
            10,
            2
        );

        // Add actions for admin
        add_action(
            'admin_enqueue_scripts',
            array('WH_Sermons_Admin', 'enqueue_admin_scripts')
        );

        // Register settings
        add_action( 'admin_init', function() {
            $defaults = [
                'sermons_slug'  => 'sermons',
                'books_slug'    => 'books',
                'series_slug'   => 'series',
                'teachers_slug' => 'teachers'
            ];
            add_option( 'wh_sermons_options', $defaults );
            register_setting('wh_sermons_settings', 'wh_sermons_options');
        });

        // Add settings page to admin menu
        add_action( 'admin_menu', function() {
            add_options_page(
                'Sermon Library', // Page title
                'Sermon Library', // Menu title
                'manage_options', // Capability
                'wh-sermons-settings', // Menu slug
                function() {
                    $settings_page = WH_Sermons::view_path() . 'admin/settings-page.php';
                    $view = WH_Sermons_View::get( $settings_page );
                    echo $view;
                }
            );
        });

        add_action( 'admin_init', function() {
            add_settings_section(
                'wh_sermons_settings_section', // id
                'URL Structure Settings',      // title of section
                function() {
                    echo "<p>You can change the values for Sermon Library slugs.<br>You do not need to change these settings unless you have a conflict with another plugin or would simply prefer a different link structure.</p>";
                },
                'wh-sermons-settings'          // Menu page to display section. Must match menu slug from add_options_page
            );

            add_settings_field(
                'sermon_slug', // id
                'Sermons', // title
                function( $args ) {
                    $settings = get_option('wh_sermons_options');
                    echo "<input name='wh_sermons_options[sermons_slug]' type='text' value='" . $settings['sermons_slug'] . "'>";
                },
                'wh-sermons-settings',
                'wh_sermons_settings_section'
            );

            add_settings_field(
                'books_slug', // id
                'Books', // title
                function( $args ) {
                    $settings = get_option('wh_sermons_options');
                    echo "<input name='wh_sermons_options[books_slug]' type='text' value='" . $settings['books_slug'] . "'>";
                },
                'wh-sermons-settings',
                'wh_sermons_settings_section'
            );

            add_settings_field(
                'series_slug', // id
                'Series', // title
                function( $args ) {
                    $settings = get_option('wh_sermons_options');
                    echo "<input name='wh_sermons_options[series_slug]' type='text' value='" . $settings['series_slug'] . "'>";
                },
                'wh-sermons-settings',
                'wh_sermons_settings_section'
            );

            add_settings_field(
                'teachers_slug', // id
                'Teachers', // title
                function( $args ) {
                    $settings = get_option('wh_sermons_options');
                    echo "<input name='wh_sermons_options[teachers_slug]' type='text' value='" . $settings['teachers_slug'] . "'>";
                },
                'wh-sermons-settings',
                'wh_sermons_settings_section'
            );

            if ( delete_transient('wh-sermons-flush-rewrite-rules') ) {
                WH_Sermons_Log::write('------------- Flushing rewrite rules because the sermon slugs were updated ----------------');
                flush_rewrite_rules();
            }
        });

        add_action( 'update_option_wh_sermons_options', function( $options ) {
            set_transient('wh-sermons-flush-rewrite-rules', 'true');
        });

        add_filter( 'plugin_row_meta', function( $links, $file ) {
            if ( strpos( $file, 'white-harvest-sermons.php' ) !== false ) {
                $links = array_merge( $links, [
                    '<a href="https://whiteharvest.net/contact/" target="_blank">Get Help</a>'
                ]);
            }

        return $links;
        }, 10, 2);

    }

    public static function enqueue_admin_scripts() {
        // Load admin CSS
        $css_path = WH_Sermons::plugin_url() . 'assets/css/wh-sermons-admin.css';

        wp_enqueue_style(
            'wh-sermons-admin-styles',
            $css_path,
            array(),
            '1.0.0',
            'all'
        );

        // Load admin JavaScript
        $js_path = WH_Sermons::plugin_url() . 'assets/js/wh-sermons-admin.js';

        wp_enqueue_script(
            'wh-sermons-admin-js',
            $js_path,
            array('jquery'),
            '1.0'
        );
    }

    public static function keep_checklist_heirarchy( $args, $post_id ) {
        $post_type = get_post_type( $post_id );

        if ( ( 'wh_sermons' == $post_type ) && isset( $args['taxonomy']) ) {
            $args['checked_ontop'] = false;
        }

        return $args;
    }

    /**
     * Return a csv string of the taxonomy slugs
     */
    public static function get_taxonomy_slugs( $taxonomy_name ) {
       $terms = get_terms( array(
           'taxonomy' => $taxonomy_name,
           'hide_empty' => false
       ) );

       $list = array();
       foreach( $terms as $t ) {
           $list[] = '<a href="#" class="wh_data_link" data-dest="' . $taxonomy_name . '">' . $t->slug . '</a>';
       }

       return implode( ', ', $list );
    }

    public static function add_shortcode_button() {
        add_action( 'media_buttons', function() {
            $series_slugs = WH_Sermons_Admin::get_taxonomy_slugs('wh_sermons_series');
            $teacher_slugs = WH_Sermons_Admin::get_taxonomy_slugs('wh_sermons_teacher');
            $book_slugs = WH_Sermons_Admin::get_taxonomy_slugs('wh_sermons_books');

            $icon = WH_Sermons::plugin_url() . 'assets/images/white-harvest-logo_18x18.png';
            $shortcode_button = WH_Sermons::plugin_path() . 'views/admin/shortcode-button.php';
            $view = WH_Sermons_View::get( $shortcode_button, array(
                'wh_icon' => $icon,
                'series_slugs' => $series_slugs,
                'teacher_slugs' => $teacher_slugs,
                'book_slugs' => $book_slugs
            ) );
            echo $view; 
        });
    }
}
