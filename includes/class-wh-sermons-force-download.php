<?php

class WH_Sermons_Force_Download {

    public static function check() {
        if ( defined('ABSPATH') ) {
            if ( isset( $_GET['task'] ) && $_GET['task'] == 'download') {
                $url = $_GET['dl'];
                $file_name = basename( $url );

                // Assuming the file is in the /mp3 off the root of the website
                $file_path = ABSPATH . 'mp3/' . $file_name;

                // Check for file on local file system before downloading a remote file
                if ( file_exists( $file_path ) ) {
                    WH_Sermons_Log::write( "Using local file: $file_path" );
                    $content = file_get_contents( $file_path );
                }
                else {
                    WH_Sermons_Log::write( "Using remote file: $url" );
                    $content = file_get_contents( $url );
                }

                header("Content-Disposition: attachment; filename=\"$file_name\"");
                echo $content;
                die();
            }
        }
    }

}
