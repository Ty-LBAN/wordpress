<?php
/**
 * electro engine room
 *
 * @package electro
 */

/**
 * Initialize all the things.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */
 
 add_action(
    'rest_api_init',
    function () {
        register_rest_route(
            'api',
            'gfareg',
            array(
                'methods'  => 'POST',
                'callback' => 'gfa_register',
            )
        );
    }
);

function gfa_register(WP_REST_Request $request){
    // create a new wp user
	$arr_request = json_decode( $request->get_body() );
	$user = get_user_by( 'email', $arr_request->email );
	if(!($user)){
		$user_id = wp_insert_user(array(
			'user_login' => $arr_request->username,
			'user_pass' => $arr_request->password,
			'user_email' => $arr_request->email,
			'first_name' => $arr_request->firstname,
			'last_name' => '',
			'role' => 'seller'
		));
		
		$user = get_user_by( 'id', $user_id );
	}
	
	$user_detail = [
	    'Name' => $user->data->display_name,
	    'Email' => $user->data->user_email,
	    'Username' => $user->data->user_nicename
	];
	
	return $user_detail;
}


//Get Revenue report

add_action(
    'rest_api_init',
    function () {
        register_rest_route(
            'api',
            'gfareport',
            array(
                'methods'  => 'POST',
                'callback' => 'gfa_report',
            )
        );
    }
);

function gfa_report(WP_REST_Request $request){
    // create a new wp user
    global $wpdb;
    $sellers_list = [];
    $all_sellers = sort_sellers();
    for($i = 0; $i<count($all_sellers); $i++){
        $seller = [
            'email' => get_seller_email(intval($all_sellers[$i])),
            'service' => '',
            'revenue' =>count_sellers_revenue(intval($all_sellers[$i])),
            'transaction' => count_sellers_transaction(intval($all_sellers[$i]))
        ];
        
        array_push($sellers_list, $seller);
    }
    
    return $sellers_list;
    
    
}

function get_seller_email($seller_id){
    $user = get_user_by( 'ID', $seller_id)->user_email;
    return $user;
}


function sort_sellers(){
    global $wpdb;
    $sellers = [];
    $results = $wpdb->get_results("SELECT seller_id FROM wprv_dokan_orders");
    for($i = 0; $i < count($results); $i++){
        
        if(!(in_array($results[$i]->seller_id, $sellers))){
            array_push($sellers, $results[$i]->seller_id);
        }
        
    }
    return $sellers;
}

function count_sellers_revenue($seller_id){
    global $wpdb;
    $total = [];
    $results = $wpdb->get_results("SELECT * FROM wprv_dokan_orders WHERE seller_id=$seller_id AND order_status='wc-completed'");
    for($i = 0; $i < count($results); $i++){
        array_push($total, $results[$i]->net_amount);
    }
    return array_sum($total);
}

function count_sellers_transaction($seller_id){
    global $wpdb;
    $results = $wpdb->get_results("SELECT seller_id FROM wprv_dokan_orders WHERE seller_id=$seller_id AND order_status='wc-completed'");
    return count($results);
}

add_action(
    'rest_api_init',
    function () {
        register_rest_route(
            'api',
            'gfaapplycoupon',
            array(
                'methods'  => 'POST',
                'callback' => 'apply_coupon',
            )
        );
    }
);

function apply_coupon(WP_REST_Request $request) {
    
    $arr_request = json_decode( $request->get_body() );
    
    if(auto_apply_coupon($arr_request->coupon_id)){
        return 1;
    } else {
        return 0;
    }
    
    
}

function auto_apply_coupon($coupon_id){
    global $wpdb;
    
    $postmeta_table = 'wprv_postmeta';
    
    if(check_coupon_data($coupon_id, "_wc_make_coupon_available")){
            
        $wpdb->update(
            $postmeta_table,
            array( 
                'meta_value' => "checkout,cart"
            ),
            array(
                'post_id' => $coupon_id,
                'meta_key'   => "_wc_make_coupon_available",
            )
        );
        
    } else {
        $wpdb->insert( 
            $postmeta_table, 
            array( 
                'post_id' => $coupon_id,
                'meta_key' => "_wc_make_coupon_available",
                'meta_value' => "checkout,cart"
            ) 
        );
    }
    
    if(check_coupon_data($coupon_id, "_wt_make_auto_coupon")){
            
        $wpdb->update(
            $postmeta_table,
            array( 
                'meta_value' => 1
            ),
            array(
                'post_id' => $coupon_id,
                'meta_key'   => "_wt_make_auto_coupon",
            )
        );
        
    } else {
        $wpdb->insert( 
            $postmeta_table, 
            array( 
                'post_id' => $coupon_id,
                'meta_key' => "_wt_make_auto_coupon",
                'meta_value' => 1
            ) 
        );
    }
    
    if(check_coupon_data($coupon_id, "wt_apply_discount_before_tax_calculation")){
            
        $wpdb->update(
            $postmeta_table,
            array( 
                'meta_value' => 1
            ),
            array(
                'post_id' => $coupon_id,
                'meta_key'   => "wt_apply_discount_before_tax_calculation",
            )
        );
        
    } else {
        $wpdb->insert( 
            $postmeta_table, 
            array( 
                'post_id' => $coupon_id,
                'meta_key' => "wt_apply_discount_before_tax_calculation",
                'meta_value' => 1
            ) 
        );
    }
    
    if(check_coupon_data($coupon_id, "_wt_sc_bogo_customer_gets")){
            
        $wpdb->update(
            $postmeta_table,
            array( 
                'meta_value' => "specific_product"
            ),
            array(
                'post_id' => $coupon_id,
                'meta_key'   => "_wt_sc_bogo_customer_gets",
            )
        );
        
    } else {
        $wpdb->insert( 
            $postmeta_table, 
            array( 
                'post_id' => $coupon_id,
                'meta_key' => "_wt_sc_bogo_customer_gets",
                'meta_value' => "specific_product"
            ) 
        );
    }
    
    return "success";
}

function check_coupon_data($coupon_id, $key){
    global $wpdb;
    
    $key = json_encode($key);
    
    $results = $wpdb->get_results("SELECT * FROM wprv_postmeta WHERE post_id=$coupon_id AND meta_key=$key");
    
    if(count($results) > 0){
        return 1;
    } else {
        return 0;
    }
}


include('custom-shortcode.php');
?>