<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// display activation notice
function naas_contact_form_7_redirect_my_plugin_admin_notices() {
	if (!get_option('naas_contact_form_7_redirect_my_plugin_notice_shown')) {
		
        $message = sprintf(
            esc_html__( '%1$s has been activated', 'naas_contact_form_7_redirect' ),
            '<strong>'.esc_html__( 'NAAS Contact Form 7 Redirect', 'naas_contact_form_7_redirect' ).'</strong>'
        );

        printf('<div class="notice notice-success is-dimissible"><p>%1$s</p></div>', $message);

		update_option("naas_contact_form_7_redirect_my_plugin_notice_shown", "true");
	}
}
add_action('admin_notices', 'naas_contact_form_7_redirect_my_plugin_admin_notices');