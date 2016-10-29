<?php
/*
Plugin Name: Voor de Kunst projects
Plugin URI: https://github.com/vrijplaatsleiden/voordekunst-projects
Description:  Wordpress plugin to display the status (i.e. donated amount, percentage) of your Voor de kunst crowdfunding project on your Wordpress site.
Version: 0.1
Author: Ronald
Author URI: https://vrijplaatsleiden.nl
License: MIT
*/

/**
 *  The MIT License (MIT)
 *
 * Copyright (c) 2016 Vrijplaats Leiden
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('VOORDEKUNST_PROJECTS__VERSION', '3.1.11');
define('VOORDEKUNST_PROJECTS__MINIMUM_WP_VERSION', '4.5');
define('VOORDEKUNST_PROJECTS__PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('VOORDEKUNST_PROJECTS__PLUGIN_URL', plugins_url(__FILE__));

// activation / deactivation
register_activation_hook(__FILE__, 'vpl_vdk_activate');
register_deactivation_hook(__FILE__, 'vpl_vdk_deactivate');

if (is_admin()) {
    require_once(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'class.voordekunst-projects-admin.php');
    add_action( 'init', array( 'voordekunst_projects_admin', 'init' ) );
}
require_once(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'class.voordekunst-projects-db.php');
require_once(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'class.voordekunst-projects-options.php');
require_once(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'class.voordekunst-projects-display.php');
require_once(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'class.voordekunst-projects-widget.php');

// register short codes
voordekunst_projects_display::register_shortcodes();

/**
 * On plugin activation
 */
function vpl_vdk_activate() {
    // create database table if not exists
    voordekunst_projects_db::create_tables();
    add_option(voordekunst_projects_options::OPTIONS_KEY, []);
}

/**
 * On plugin deactivation
 */
function vpl_vdk_deactivate() {
    // do nothing
}

