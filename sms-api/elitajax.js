function submit_mepop(){
	var mob = jQuery('#reg_woo_register_mobile').val();
	 
	var data = {
		'action': 'the_ajax_hook_otp',
        'mob':mob		// We pass php values differently!
	};
	
	 jQuery.get(the_ajax_script.ajaxurl, data
    ,
    function(response_from_the_action_function){
        jQuery("#response_area").html(response_from_the_action_function);
    }
    );

}