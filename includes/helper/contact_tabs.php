<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// hook into contact form 7 form
function naas_contact_form_7_redirect_editor_panels ( $panels ) {

	$new_page = array(
		'Redirect' => array(
			'title' => __( 'NAAS Redirect', 'naas_contact_form_7_redirect' ),
			'callback' => 'naas_contact_form_7_redirect_admin_after_additional_settings'
		)
	);

	$panels = array_merge($panels, $new_page);

	return $panels;

}
add_filter( 'wpcf7_editor_panels', 'naas_contact_form_7_redirect_editor_panels' );


function naas_contact_form_7_redirect_admin_after_additional_settings(){

    $post_id = sanitize_text_field($_GET['post']);

    $enable = 						get_post_meta($post_id, "_naas_contact_form_7_redirect_enable", true);
	$naas_contact_form_7_redirect_redirect_type = 			get_post_meta($post_id, "_naas_contact_form_7_redirect_redirect_type", true);
	$naas_contact_form_7_redirect_url = 					get_post_meta($post_id, "_naas_contact_form_7_redirect_url", true);
	$tab = 							get_post_meta($post_id, "_naas_contact_form_7_redirect_tab", true);
	$naas_contact_form_7_redirect_page = 		get_post_meta($post_id, "_naas_contact_form_7_redirect_page", true);

    if ($enable == "1") { 			
        $checked = "CHECKED"; 
    } else {
        $checked = ""; 
    }

	if ($tab == "1") { 				
        $tab = "CHECKED"; 
    } else { 				
        $tab = ""; 
    }

    $admin_table_output = "";
    $admin_table_output .= "<h2><b>NAAS Redirect Settings</b></h2>";

    $admin_table_output .= "<table class='naas_contact_form_7_redirect_tabs_table_main'>";

    $admin_table_output .= "<tr>";
    $admin_table_output .= "<td><h4><b>General Settings</b></h4></td>";
    $admin_table_output .= "</tr>";

    $admin_table_output .= "<tr><td class='naas_contact_form_7_redirect_tabs_table_title_width'><label>Enable Redirect: </label></td>";
	$admin_table_output .= "<td class='naas_contact_form_7_redirect_tabs_table_body_width'><input name='naas_contact_form_7_redirect_enable' value='1' type='checkbox' $checked></td></tr>";

    $admin_table_output .= "<tr><td class='naas_contact_form_7_redirect_tabs_table_title_width'><label>Redirect Type: </label></td>";
	$admin_table_output .= "<td class='naas_contact_form_7_redirect_tabs_table_body_width'><select class='naas_contact_form_7_redirect_select_dropdown' id='naas_contact_form_7_redirect_redirect_type' name='naas_contact_form_7_redirect_redirect_type'>
	<option  "; if ($naas_contact_form_7_redirect_redirect_type == 'url') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='url'>URL</option>
	<option  "; if ($naas_contact_form_7_redirect_redirect_type == 'page') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='page'>Page</option></select></td></tr>";

    //url redirect
    $admin_table_output .= "<tr class='naas_contact_form_7_redirect_url naas_contact_form_7_redirect_redirect_option'><td><br /><h4><b>URL Redirect Settings</b></h4></td></tr>";
	
	$admin_table_output .= "<tr class='naas_contact_form_7_redirect_url naas_contact_form_7_redirect_redirect_option'><td>URL: </td>";
	$admin_table_output .= "<td><input type='url' name='naas_contact_form_7_redirect_url' value='$naas_contact_form_7_redirect_url'> </td><td> Example: http://www.domain.com</td></tr><tr><td colspan='3'></td></tr>";
	
	$admin_table_output .= "<tr class='naas_contact_form_7_redirect_url naas_contact_form_7_redirect_redirect_option'><td class='naas_contact_form_7_redirect_tabs_table_title_width'><label>Open In New Tab: </label></td>";
	$admin_table_output .= "<td class='naas_contact_form_7_redirect_tabs_table_body_width'><input name='naas_contact_form_7_redirect_tab' value='1' type='checkbox' $tab></td></tr>";



    //page
    $admin_table_output .= "<tr class='naas_contact_form_7_redirect_thank naas_contact_form_7_redirect_redirect_option' style='display:none;'><td><br /><b><h4>Page Settings</h4></b></td></tr>";
	
	$admin_table_output .= "<tr class='naas_contact_form_7_redirect_thank naas_contact_form_7_redirect_redirect_option' style='display:none;'><td valign='top'>Page: </td>";
	$admin_table_output .= "<td><select name='naas_contact_form_7_redirect_page' class='naas_contact_form_7_redirect_select_dropdown'>
    <option value=''>".esc_attr( 'Select Page' )."</option>";

    $pages = get_pages(); 
    foreach ( $pages as $page ) {
        if($naas_contact_form_7_redirect_page == $page->ID){
            $selected = "selected";
        }else{
            $selected = "";
        }
        $admin_table_output .= '<option value="' . $page->ID . '" '.$selected.' >';
        $admin_table_output .= $page->post_title;
        $admin_table_output .= '</option>';
    }

    $admin_table_output .= "</select></td></tr>";

    $admin_table_output .= "<input type='hidden' name='naas_contact_form_7_redirect_post' value='$post_id'>";


    $admin_table_output .= "</table>";

    $admin_table_output .= "<br><br><p>Developed by NAAS Digital</p>";

    echo $admin_table_output;

}



// hook into contact form 7 admin form save
add_action('wpcf7_after_save', 'naas_contact_form_7_redirect_save_contact_form');

function naas_contact_form_7_redirect_save_contact_form( $cf7 ) {
		
		$post_id = sanitize_text_field($_POST['naas_contact_form_7_redirect_post']);
		
		if (!empty($_POST['naas_contact_form_7_redirect_enable'])) {
			$enable = sanitize_text_field($_POST['naas_contact_form_7_redirect_enable']);
			update_post_meta($post_id, "_naas_contact_form_7_redirect_enable", $enable);
		} else {
			update_post_meta($post_id, "_naas_contact_form_7_redirect_enable", 0);
		}
		
		if (!empty($_POST['naas_contact_form_7_redirect_tab'])) {
			$tab = sanitize_text_field($_POST['naas_contact_form_7_redirect_tab']);
			update_post_meta($post_id, "_naas_contact_form_7_redirect_tab", $tab);
		} else {
			update_post_meta($post_id, "_naas_contact_form_7_redirect_tab", 0);
		}
		
		$naas_contact_form_7_redirect_redirect_type = sanitize_text_field($_POST['naas_contact_form_7_redirect_redirect_type']);
		update_post_meta($post_id, "_naas_contact_form_7_redirect_redirect_type", $naas_contact_form_7_redirect_redirect_type);
		
		$naas_contact_form_7_redirect_url = sanitize_text_field($_POST['naas_contact_form_7_redirect_url']);
		update_post_meta($post_id, "_naas_contact_form_7_redirect_url", $naas_contact_form_7_redirect_url);
		
		$naas_contact_form_7_redirect_page = sanitize_text_field($_POST['naas_contact_form_7_redirect_page']);
		update_post_meta($post_id, "_naas_contact_form_7_redirect_page", $naas_contact_form_7_redirect_page);
		
		
}