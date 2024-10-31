<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// returns the form id of the forms that have redirect enabled
function naas_contact_form_7_redirect_forms_enabled() {

	// array that will contain which forms redirect is enabled on
	$enabled = array();
	
	$args = array(
		'posts_per_page'   => 999,
		'post_type'        => 'wpcf7_contact_form',
		'post_status'      => 'publish',
	);
	$posts_array = get_posts($args);
	
	
	// loop through them and find out which ones have redirect enabled
	foreach($posts_array as $post) {
		
		$post_id = $post->ID;
		
		// url
		$enable = get_post_meta( $post_id, "_naas_contact_form_7_redirect_enable", true);
		
		if ($enable == "1") {
			
			$naas_contact_form_7_redirect_redirect_type = get_post_meta( $post_id, "_naas_contact_form_7_redirect_redirect_type", true);
			$naas_contact_form_7_redirect_url = get_post_meta( $post_id, "_naas_contact_form_7_redirect_url", true);
			$naas_contact_form_7_redirect_tab = get_post_meta( $post_id, "_naas_contact_form_7_redirect_tab", true);
			
			$enabled[] = '|'.$post_id.'|'.$naas_contact_form_7_redirect_redirect_type.'|'.$naas_contact_form_7_redirect_url.'|'.$naas_contact_form_7_redirect_tab.'|';
			
		}
		
	}

	return json_encode($enabled);

}



//redirect page
add_action('wp_ajax_naas_contact_form_7_redirect_get_form_page', 'naas_contact_form_7_redirect_get_form_page_callback');
add_action('wp_ajax_nopriv_naas_contact_form_7_redirect_get_form_page', 'naas_contact_form_7_redirect_get_form_page_callback');
function naas_contact_form_7_redirect_get_form_page_callback() {

	$formid =						sanitize_text_field($_POST['formid']);
	$naas_contact_form_7_redirect_page = 		get_post_meta($formid, "_naas_contact_form_7_redirect_page", true);	
	
	$url = get_page_link( $naas_contact_form_7_redirect_page );
	
	


	$response = array(
		'url'         		=> $url,
	);

	echo json_encode($response);
	wp_die();
}