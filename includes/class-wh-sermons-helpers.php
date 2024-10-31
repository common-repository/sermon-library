<?php
class WH_Sermons_Helpers {

    public static function get_audio_url ( $post_id) {
        $url = '';
        $meta = get_post_meta( $post_id );

        foreach( $meta as $key => $value ) {
            if ( WH_Sermons::ends_with( $key, 'enclosure' ) ) {
                $url_data = explode("\n", $value[0]);
                $url = array_shift( $url_data );
            }
        }

        return $url;
    }

    public static function get_teachers ( $post_id ) {
        $teacher_list = array();
        $teachers = wp_get_post_terms( $post_id, 'wh_sermons_teacher');

        foreach ( $teachers as $teacher ) {
            $teacher_list[] = $teacher->name;
        }

        $teacher_list = implode( ', ', $teacher_list );

        return $teacher_list;
    }
}
