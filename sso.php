<?php

require_once( 'wp-load.php' ); //put correct absolute path for this file


global $wpdb;

if(isset($_GET['key']) && !empty($_GET['key'])){

$email_decoded = base64_decode(strtr($_GET['key'], '-_', '+/'));

$received_email = sanitize_text_field($email_decoded);

$product = $_GET['product'];


if( email_exists( $received_email ) || $received_email == '') {

        //get the user id for the user record exists for received email from database 
        $user_id = $wpdb->get_var($wpdb->prepare("SELECT * FROM ".$wpdb->users." WHERE user_email = %s", $received_email ) );

        wp_set_auth_cookie( $user_id); //login the previously exist user

         // put the url where you want to redirect user after logged in
        
        if($product == 'buy'){
            wp_redirect('http://98.71.186.202/shop/');
        } else{
            wp_redirect('http://98.71.186.202/dashboard/products/');
        }

}else{
    wp_redirect('http://98.71.186.202');
}

 die;

 }else {
     wp_redirect('http://98.71.186.202');
 }?>