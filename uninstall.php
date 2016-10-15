<?php
/**
 * File that is run during plugin uninstall (not just de-activate)
 * @TODO: delete all tables in network if on multisite
 */

// If uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

/*
Go on with uninstall actions:
 - Remove our database table
 - Remove options:
*/

// Remove options
$arr_options = [];
foreach ($arr_options as $one_option) {
	delete_option( $one_option );
}

global $wpdb;

// Remove database tables
$table_name = $wpdb->prefix . "vdk_projects";
$wpdb->query("DROP TABLE IF EXISTS $table_name");

