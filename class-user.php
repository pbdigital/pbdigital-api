<?php
namespace PBDigital;

class Users extends PBDigital
{

    static function login_user(\WP_REST_Request $request)
    {
        $username = $request->get_param('username');
		$password = $request->get_param('password');
		$user = wp_authenticate( $username, $password );
		if(is_wp_error($user)) {
			return new \WP_REST_Response(array("success"=>false,"message"=>"Username or Password Incorrect"), 403);
		} else {
			$credentials = [
				'user_login' => $username,
				'user_password' => $password,
				'rememberme' => true,
			];
			wp_signon($credentials, true);
			$response['token'] = bin2hex(random_bytes(64));
			$response['user_id'] = $user->data->ID ;
			$response['user_email'] = $user->data->user_email ;
			$response['user_nicename'] = $user->data->user_nicename ;
			$response['user_display_name'] = $user->data->display_name ;
			$response['avatar'] = get_avatar_url($user->data->ID );
			update_user_meta( $user->data->ID , 'mobile_app_token_'.time(), $response['token'] );
		}
		$response = new \WP_REST_Response($response);
		return $response;
        $response = array(
            "success" => true
        );

        return $response;
    }

    static function get_user(\WP_REST_Request $request){
        $user_id = parent::pb_auth_user($request);

    }
}