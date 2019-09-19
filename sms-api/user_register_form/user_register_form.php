<?php


function elit_wooocommerce_register_otp() {
	
    ?>

    <p class="form-row form-row-wide">
    <label for="reg_woo_register_mobile"><?php _e( 'Mobile NO.', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="14" class="input-text" name="woo_register_mobile" id="reg_woo_register_mobile" maxlenth="" value="<?php if ( ! empty( $_POST['woo_register_mobile'] ) ) esc_attr_e( $_POST['woo_register_mobile'] ); ?>" />
	<span id="response_area" style="margin:0; color:red"></span><div style="clear:both"></div>
	<span id="remove-all" onClick="submit_mepop();" style="background:#ddd; color:black; padding:5px; border:1px solid #cacaca; border-radius:3px; cursor:pointer" >Get OTP</span>
    </p>
	
	
	<p class="form-row form-row-wide">
    <label for="reg_woo_register_mobile_otp"><?php _e( 'OTP', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="elitbuzz_otp" id="reg_woo_register_mobile_otp" value="<?php echo $_COOKIE['my_cookiez'];; ?>" />
    </p>

	

    <?php


}



add_action( 'woocommerce_register_form', 'elit_wooocommerce_register_otp' );
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function elit_validate_extra_register_fields( $username, $email, $validation_errors ) {
	
    if ( isset( $_POST['woo_register_mobile'] ) && empty( $_POST['woo_register_mobile'] ) ) {
        $validation_errors->add( 'woo_register_mobile_error', __( 'Please enter valid mobile phone number.', 'woocommerce' ) );
    }
	

	
	 if ( isset( $_POST['elitbuzz_otp'] ) && empty( $_POST['elitbuzz_otp'] ) ) {
        $validation_errors->add( 'elitbuzz_otp', __( 'OTP is not match', 'woocommerce' ) );
    } 
	
	 
	if($_COOKIE['otp'] !=  $_POST['elitbuzz_otp'] ){
		 
		$validation_errors->add( 'elitbuzz_otp', __( 'OTP is not  match', 'woocommerce' ) );
	}
	 
	
	
}

add_action( 'woocommerce_register_post', 'elit_validate_extra_register_fields', 10, 3 );

  
function elit_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['woo_register_mobile'] )) {
        update_user_meta( $customer_id, 'woo_register_mobile', $_POST['woo_register_mobile']);
    }
}
add_action( 'woocommerce_created_customer', 'elit_save_extra_register_fields' );



function elit_print_user_frontend_fields(){
$current_user = wp_get_current_user();
  
$mobi = get_user_meta($current_user->ID, "woo_register_mobile", true );
	?>
	 <p class="form-row form-row-wide">
    <label for="reg_woo_register_mobile"><?php _e( 'Mobile NO.', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" readonly class="input-text" name="woo_register_mobile" id="reg_woo_register_mobile" value="<?php echo $mobi; ?>" />
	 
    </p>
<?php 	
}
 
 

add_action( 'woocommerce_edit_account_form', 'elit_print_user_frontend_fields', 10 ); // my account






add_action( 'show_user_profile', 'elit_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'elit_show_extra_profile_fields' );

function elit_show_extra_profile_fields( $user ) {
	?>
	<h3><?php esc_html_e( 'Personal Information', 'crf' ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="woo_register_mobile"><?php esc_html_e( 'Mobile NO.', 'crf' ); ?></label></th>
			<td><?php echo esc_html( get_the_author_meta( 'woo_register_mobile', $user->ID ) ); ?></td>
		</tr>
	</table>
	<?php
}