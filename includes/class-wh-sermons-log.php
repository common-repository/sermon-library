<?php

class WH_Sermons_Log {

    public static $log_file;

    public static function init() {
        if ( ! isset( self::$log_file ) ) {
            self::$log_file = WH_Sermons::plugin_path() . 'log.txt';
        }
    }

    public static function write( $data ) {
        if ( WH_Sermons::debug() ) {
            self::init();
            $backtrace = debug_backtrace();
            $file = $backtrace[0]['file'];
            $line = $backtrace[0]['line'];
            $date = current_time('m/d/Y g:i:s A') . ' ' . get_option('timezone_string');
            $out = "========== $date ==========\nFile: $file" . ' :: Line: ' . $line . "\n$data";

            if( is_writable( WH_Sermons::plugin_path() ) ) {
                file_put_contents( self::$log_file, $out . "\n\n", FILE_APPEND );
            }
            else {
                echo WH_Sermons::plugin_path();
                die();
            }
        }
    }

    public static function write_array( $data ) {
        self::write( print_r( $data, true ) );
    }

    public static function download() {
        self::init();
        $data = 'The White Harvest Sermons log file contains no data';

        if ( file_exists( self::$log_file ) ) {
            $data = file_get_contents( self::$log_file );
        }

        header( 'Content-type: text/plain' );
        header( 'Content-Disposition: attachment; filename="wh_sermons_log.txt"' );
        echo $data;
        exit();
    }

    /**
     * Delete all of the contents from the log file
     */
    public static function reset() {
        self::init();
        if ( file_exists( self::$log_file ) ) {
            file_put_contents( self::$log_file, '' );
        }
    }

}
