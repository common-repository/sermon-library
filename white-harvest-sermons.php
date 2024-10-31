<?php
/*
Plugin Name: Sermon Library
Plugin URI: https://whiteharvest.net/plugins/sermon-library/
Description: This plugin helps you sort, manage, and share your library of sermons.
Version: 1.1.1
Author: Lee Blue
Author URI: https://whiteharvest.net

-------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define constants
define('WH_SERMONS_VERSION_NUMBER', '1.1.1');
define('WH_SERMONS_DEBUG', false);

include_once 'includes/class-wh-sermons.php';
add_action( 'plugins_loaded', array('WH_Sermons', 'get_instance'), 10 );

// Check for PowerPress plugin
add_action( 'plugins_loaded', function() {
    if( ! defined('POWERPRESS_VERSION') ) {
        add_action( 'admin_notices', function() {
            $notice = "Please install and activate the free <a href='plugin-install.php?s=powerpress+podcasting&tab=search&type=term'>PowerPress Podcasting plugin by Blubrry</a> to manage your White Harvest Sermon Library audio files and podcast.";
            echo "<div class='notice notice-warning'><p>$notice</p></div>";
        });
    }
});

register_activation_hook( __FILE__, function() {
    set_transient('wh-sermons-flush-rewrite-rules', 'true');
});