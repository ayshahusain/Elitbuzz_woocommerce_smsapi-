<?php

/**
* Plugin Name: SMS API
* Plugin URI: 
* Description: This SMS API Supported by woocommerce and it is used for user verification and order confirmation.
* Version: 1.0
* Author: Elitbuzz
* Author URI: http://elitbuzz.com
**/

include_once dirname( __FILE__ ) . '/admin/index.php';
$options = json_decode(get_option('sms_api_elitbuzz')); 
 
if($options->active_otp == 1){	
include_once dirname( __FILE__ ) . '/user_register_form/user_register_form.php';
include_once dirname( __FILE__ ) . '/user_register_form/register_otp.php';
}
 if($options->active_order == 1)
{
include_once dirname( __FILE__ ) . '/user_register_form/completed_order_sms.php';
}

  











