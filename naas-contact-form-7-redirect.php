<?php

/*
Plugin Name: NAAS Contact Form 7 Redirect
Plugin URI: https://naasdigital.com
Description: A plugin for redirection after contact form 7 submission. it will be very usefull if we want add thank you page after submission
Author: NAAS Digital
Author URI: http://itsaboutafshan.com
License: GPL2
Version: 1.0.1
*/

/*  Copyright 2021-2021 NAAS Digital    
Barsha Heights, Dubai, United Arab Emirates
*/


/* plugin variable: naas_contact_form_7_redirect */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

register_activation_hook( 	__FILE__, "naas_contact_form_7_redirect_activate" );
register_deactivation_hook( __FILE__, "naas_contact_form_7_redirect_deactivate" );
register_uninstall_hook( 	__FILE__, "naas_contact_form_7_redirect_uninstall" );

function naas_contact_form_7_redirect_activate() {

}


function naas_contact_form_7_redirect_deactivate() {
    delete_option( 'naas_contact_form_7_redirect_my_plugin_notice_shown' );
}


function naas_contact_form_7_redirect_uninstall(){
    //perform on uninstall the plugin
}


// check to make sure contact form 7 is installed and active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ){

    // public includes
	include_once('includes/functions.php');
    include_once('includes/notices.php');
    include_once('includes/enqueue.php');
    include_once('includes/library/redirect.php');

    if(is_admin()){
        include_once('includes/helper/contact_tabs.php');
    }

} else {
    // give warning if contact form 7 is not active
		function naas_contact_form_7_redirect_my_admin_notice() {

            $message = sprintf(
                esc_html__( '%1$s %2$s is not installed and / or active| Please install or activate: %3$s', 'naas_contact_form_7_redirect' ),
                '<strong>'.esc_html__( 'NAAS Contact Form 7 Redirect Alert:', 'naas_contact_form_7_redirect' ).'</strong>',
                '<strong>'.esc_html__( 'Contact Form 7', 'naas_contact_form_7_redirect' ).'</strong>',
                '<a href="'.esc_url( 'https://wordpress.org/plugins/contact-form-7/' ).'" target="_blank">'.esc_html__( 'Contact Form 7', 'naas_contact_form_7_redirect' ).'</a>'
            );

            printf('<div class="notice notice-warning is-dimissible"><p>%1$s</p></div>', $message);

			
		}
		add_action( 'admin_notices', 'naas_contact_form_7_redirect_my_admin_notice' );
}


