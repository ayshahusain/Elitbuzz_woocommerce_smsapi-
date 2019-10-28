<?php
 
  add_action( 'woocommerce_thankyou', 'elit_woocommerce_new_order');
  
function elit_woocommerce_new_order( $order_id ){
    $order = wc_get_order( $order_id );
    if($order_id){
	$order = wc_get_order( $order_id );
	$mymob = $order->get_billing_phone();
	$country = $order->get_billing_country();
    $get_data_sms = json_decode(get_option('sms_api_elitbuzz'));
	$api_keys = $get_data_sms->api_key;
	$senderid = $get_data_sms->sender_id;
	
	if($get_data_sms->ordermessage){
    $mes =  (str_replace('%orderid%',"$order_id","$get_data_sms->ordermessage"));
    }else{
     $mes =  ("Your Order id is $order_id");
     }

	$idd_elit=json_decode(file_get_contents('https://restcountries.eu/rest/v1/alpha?codes='.$country));
	$mymob = ltrim($mymob, '0');
    $idd_elit=json_decode(file_get_contents('https://restcountries.eu/rest/v1/alpha?codes='.$country));
    if (substr($mymob, 0, strlen($idd_elit[0]->callingCodes[0])) !== $idd_elit[0]->callingCodes[0]) { 
     $mymob = $idd_elit[0]->callingCodes[0].$mymob;}
	
    
	$url = "http://elitbuzz-me.com/sms/smsapi";
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
			 return true;

			  
		}
		
	 }

echo '  
 Responce: '.$response['body'].' 
 
 ';	 
     
}
