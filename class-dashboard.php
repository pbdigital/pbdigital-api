<?php
namespace PBDigital;

class Dashboard extends PBDigital
{

    static function get_data(\WP_REST_Request $request)
    {
        $posts = get_posts();
        foreach ($posts as $post){
            $post->url = get_permalink( $post->ID );
            $post->image_url = get_the_post_thumbnail_url( $post->ID, 'full' );
        }
        return $posts;
    }

    
}