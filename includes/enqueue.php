<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// admin enqueue
function naas_contact_form_7_redirect_admin_enqueue() {

	// admin css
	wp_register_style('naas_contact_form_7_redirect-admin-css',plugins_url('../assets/css/admin.css',__FILE__),false,false);
	wp_enqueue_style('naas_contact_form_7_redirect-admin-css');
	
	// admin js
	wp_enqueue_script('naas_contact_form_7_redirect-admin',plugins_url('../assets/js/admin.js',__FILE__),array('jquery'),false);


}
add_action('admin_enqueue_scripts','naas_contact_form_7_redirect_admin_enqueue');

// public enqueue
function naas_contact_form_7_redirect_public_enqueue() {

	// client css
	wp_register_style('naas_contact_form_7_redirect-client-css',plugins_url('../assets/css/client.css',__FILE__),false,false);
	wp_enqueue_style('naas_contact_form_7_redirect-client-css');
	
	// client js
	wp_enqueue_script('naas_contact_form_7_redirect-client',plugins_url('../assets/js/client.js',__FILE__),array('jquery'),false);

	wp_enqueue_script('naas_contact_form_7_redirect-redirect_method',plugins_url('../assets/js/naas_redirect_method.js',__FILE__),array('jquery'),null);
	wp_localize_script('naas_contact_form_7_redirect-redirect_method', 'naas_contact_form_7_redirect_ajax_object',
		array (
			'naas_contact_form_7_redirect_ajax_url' 		=> admin_url('admin-ajax.php'),
			'naas_contact_form_7_redirect_forms' 			=> naas_contact_form_7_redirect_forms_enabled(),
		)
	);

}
add_action('wp_enqueue_scripts','naas_contact_form_7_redirect_public_enqueue',10);