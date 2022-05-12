<?php 

namespace PBDigital;

class PBDigital{
    static $requires_auth = true;
    static $user_id = 0;
    static $request;
    
    static function wpdb(){
        global $wpdb;
        return $wpdb;
    }
    

    static function pb_auth_user ( $request ) {
        global $wpdb, $user;
  
        #$wpdb->insert('mobile_app_log', array('token_used' => $token));
        if(!empty(get_current_user_id())){
            $user_id = get_current_user_id();
            self::$user_id = $user_id;
            return $user_id;
        }
        
        $token = $request->get_header('Authorization');
        $token = preg_replace('/Bearer /', '', $token);

        //If token is empty, user is probably logged into the website
        if (empty($token)){
            $user_cookie = (wp_parse_auth_cookie( '', 'logged_in' ));
            $user = get_user_by( 'email', $user_cookie['username'] );
            if (isset( $user->data->ID)){
                self::$user_id = $user->data->ID;
                return $user->data->ID;
            } else {
                return false;
            }
        } else {
            $user = $wpdb->get_row( "SELECT * FROM $wpdb->usermeta WHERE meta_value = '$token'" );
            if (isset($user)){
                self::$user_id = $user->user_id;
                wp_set_current_user( $user->user_id );
                return $user->user_id;
            } else {
                return false;
            }
        }
        
    }

}