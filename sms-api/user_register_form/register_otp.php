<?php

// enqueue and localise scripts
 wp_enqueue_script( 'elit-ajax-handle', plugin_dir_url( __dir__ ) . 'elitajax.js', array( 'jquery' ) );
 wp_localize_script( 'elit-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

 // THE AJAX ADD ACTIONS
 

// THE AJAX ADD ACTIONS
add_action( 'wp_ajax_the_ajax_hook_otp', 'elitbuzz_action_function_otp' );
add_action( 'wp_ajax_nopriv_the_ajax_hook_otp', 'elitbuzz_action_function_otp' ); //
 

 // THE FUNCTION
 function elitbuzz_action_function_otp(){
	 
$tz = 'Asia/Dubai'; // your required location time zone.
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
$opt = NULL;
$opt = rand ( 10000 , 99999 );
setcookie ("otp", $opt, time()+ (60 * 20), '/', NULL, 0 ); 

//**************** Send SMS ******///
$get_data_sms = json_decode(get_option('sms_api_elitbuzz'));
$mymob = ltrim($_GET['mob'], '0');
if($get_data_sms->otpmessage){
$mes = (str_replace('%OTP%',"$opt","$get_data_sms->otpmessage"));
}else{
$mes = ("Your OTP is $opt");
}
 
 if(strlen($mymob) == 12){
	 $get_data_sms = json_decode(get_option('sms_api_elitbuzz'));
	 $api_keys = $get_data_sms->api_key;
	 $senderid = $get_data_sms->sender_id;
    
	$url = "http://nejoumaljazeera.com/rest_api.php";
	$array = array("api_key" => $api_keys,
	"type" => 'text',
	"contacts" => $mymob,
	"senderid" => $senderid,
	"msg" => $mes);
   $response = wp_remote_post(
			$url,
			array(
				'method'      => 'POST',
				'timeout'     => 30,
				'redirection' => 10,
				'httpversion' => '1.1',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => $array,
				'cookies'     => array(),
			)
		);

		$decoded_response = json_decode( $response['body'] );

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			return false;
		} elseif ( ( 'OK' === $response['response']['message'] ) && $decoded_response->success ) {
			//return true;
			 echo 'You will get OTP in a min.';
		}
 
	
   
 }else{
	 echo 'Please enter valid Mobile Number with country code <br>';
 }
 die(); 
 }
 
 
 