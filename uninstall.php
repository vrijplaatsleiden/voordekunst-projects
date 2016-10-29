<?php
/**
 * File that is run during plugin uninstall (not just de-activate)
 * @TODO: delete all tables in network if on multisite
 */

define('VOORDEKUNST_PROJECTS__PLUGIN_DIR', plugin_dir_path( __FILE__ ));

require_once(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'class.voordekunst-projects-db.php');
require_once(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'class.voordekunst-projects-db.options');

// If uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

// Remove options
voordekunst_projects_options::delete_options();

// Remove database table
voordekunst_projects_db::delete_tables();