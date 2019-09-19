<?php

add_action( 'admin_menu', 'elit_plugin_menu' );

/** Step 1. */
function elit_plugin_menu() {
	add_options_page( 'SMS API Setting', 'SMS API', 'manage_options', 'sms-api-setting', 'elit_sms_api_setting' );
}

 function  elit_setting_admin_init(){
    
    	$url = plugin_dir_url(__FILE__);
    	wp_enqueue_script('jquery');
    	wp_enqueue_script( 'jquery.validate', $url.'js/jquery.validate.js' );
        wp_enqueue_style( 'admin-css', plugins_url('css/admin-css.css', __FILE__) );
    
 }
   add_action( 'admin_head', 'elit_setting_admin_init' );
	
/** Step 3. */
function elit_sms_api_setting() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	$check = json_decode(get_option('sms_api_elitbuzz'));
	if(isset($_POST['btnsave'])){
	
	$array['api_key']= trim(htmlentities(sanitize_text_field($_POST['api_key']),ENT_QUOTES));
    $array['sender_id'] = trim(htmlentities(sanitize_text_field($_POST['senderid']),ENT_QUOTES));
	$array['otpmessage'] = trim(htmlentities(sanitize_text_field($_POST['otpmessage']),ENT_QUOTES));	
    $array['active_otp'] = trim(htmlentities(sanitize_text_field($_POST['active_otp']),ENT_QUOTES));
    $array['ordermessage'] =trim(htmlentities(sanitize_text_field($_POST['ordermessage']),ENT_QUOTES));	
    $array['active_order'] =trim(htmlentities(sanitize_text_field($_POST['active_order']),ENT_QUOTES));	
	 
	$var = json_encode($array);
	if(empty($check)){
    add_option('sms_api_elitbuzz', $var); 
	}else{
	update_option('sms_api_elitbuzz', $var); 	
	}
	}
	$get_sms = json_decode(get_option('sms_api_elitbuzz'));
	 
	echo '<div class="wrap">';
	echo '<h1>SMS API Setting</h1>';
	
	echo '<p style="background-color:#fff; border-top:2px solid #333; padding:10px">This Plugin is supported by Woocommerce user registration mobile verification and Order conformation. Demo API key or Sender id Contact us at <b>info@elitbuzz.com</b> or call <b>+971 4 8189666</b> </p>';
	 ?>
	 <style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
.red{color:red}
</style>
 <form method="post" action="" id="addnews" name="addnews">
	 <table width="42%" cellpadding="10">
	 <!--<tr>
	 <td width="30%"><b>Select Type of API:</b></td>
	 <td><select style="width:100%">
	 <option>Select Type API</option>
	 <option>Elitbuzz API</option>
	 <option>Demo API</option></select></td>
	 <td width="5%"></td>
	 </tr>-->
	 
	 <tr>
	 <td ><b>API Key:</b> <span class="red" >*</span></td>
	 <td><input type="text" style="width:100%" class="required" name="api_key" value="<?= $get_sms->api_key; ?>" >
	 <div style="clear:both"></div>
	  <div></div>
	  <div style="clear:both"></div></td>
	 <td><div class="tooltip"> help?
  <span class="tooltiptext">Contact with Elitbuzz info@elitbuzz.com </span>
</div></td>
	 </tr>
	 
	 <tr>
	 <td><b>Sender Id:</b> <span class="red" >*</span></td>
	 <td><input type="text" id="senderid"  class="required"  size="30" name="senderid" value="<?= $get_sms->sender_id; ?>" >
	  <div style="clear:both"></div>
	  <div></div>
	  <div style="clear:both"></div>
                                                    
                                                     </td>
	 <td><div class="tooltip"> help?
  <span class="tooltiptext">Contact with Elitbuzz info@elitbuzz.com </span>
</div></td>
	 </tr>
	 <tr>
	 <td><b>Active Mobile varification:</b></td>
	 <td><input type="checkbox" value="1" name="active_otp" <?php if($get_sms->active_otp == 1){echo 'checked';};?>>  </td>
	 <td></td>
	 </tr>
	 
	 <tr>
	 <td><b>Message Box:</b> 
	 <br><span style="font-size:11px">(Mobile No. varification sms)</span></td>
	 <td><textarea style="width:100%"  maxlength="160" name="otpmessage"><?= $get_sms->otpmessage; ?></textarea> </td>
	 <td><div class="tooltip"> help?
  <span class="tooltiptext">Your OTP is %OTP% </span>
</div></td>
	 </tr>
	 
	 <tr>
	 <td><b>Active Order sms:</b></td>
	 <td><input type="checkbox" name="active_order" value="1" <?php if($get_sms->active_order == 1){echo 'checked';};?>>  </td>
	 <td></td>
	 </tr>
	 <tr>
	 <td><b>Order Message Box:</b> 
	 <br><span style="font-size:11px">(Order Message sms box)</span></td>
	 <td><textarea style="width:100%"  maxlength="160" name="ordermessage"><?= $get_sms->ordermessage; ?></textarea> </td>
	 <td><div class="tooltip"> help?
  <span class="tooltiptext">Your Order id is %orderid% </span>
</div></td>
	 </tr>
	 
	 
	 <tr>
	 <td> </td>
	 <td><input type="submit" name="btnsave" id="btnsave" value="<?php echo __('Save Changes','vertical-news-scroller'); ?>" class="button-primary">&nbsp;&nbsp;<input type="button" name="cancle" id="cancle" value="<?php echo __('Cancel','vertical-news-scroller'); ?>" class="button-primary" onclick="location.href='admin.php?page=Scrollnews-settings'"> </td>
	 <td> </td>
	 </tr>
	 </table>
	 </form>
	  <script>
                                            var $n = jQuery.noConflict();  
                                            $n(document).ready(function() {  
                                                    $n("#addnews").validate({
                                                            errorClass: "news_error",
                                                            errorPlacement: function(error, element) {
                                                                error.appendTo( element.next().next().next());
                                                            }

                                                    })
                                            });

                                        </script> 
	 <?php
	echo '</div>';
	
	
}