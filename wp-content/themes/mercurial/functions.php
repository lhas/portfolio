<?php

// settings
include("functions/settings.php");
// page meta
include("functions/pagemeta.php");
// post meta
include("functions/postmeta.php");
//front page custom post type
include("functions/frontpagesections.php");
include("functions/frontpagesectionsmeta.php");
//portfolio custom post type
include("functions/portfolio.php");
include("functions/portfoliometa.php");
// info columns custom post type
include("functions/infocolumns.php");
include("functions/infocolumnsmeta.php");
// team custom post type
include("functions/team.php");
include("functions/teammeta.php");
// prices custom post type
include("functions/pricetables.php");
include("functions/pricetablesmeta.php");
// clients custom post type
include("functions/clients.php");
// sliders custom post type
include("functions/sliders.php");
include("functions/slidersmeta.php");
// cliens custom post type
include("functions/clientsmeta.php");
// queue scripts
include("functions/scripts.php");
// additional helper functions
include("functions/utils.php");



// Add the Theme Shortcodes
include("functions/shortcodes.php");
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

define('COLL_FILEPATH', get_template_directory());
define('COLL_DIRECTORY', get_template_directory_uri());
require_once (COLL_FILEPATH . '/tinymce/tinymce.loader.php');
/*-----------------------------------------------------------------------------------*/
// Options Framework
/*-----------------------------------------------------------------------------------*/

// Paths to admin functions
define('ADMIN_PATH', get_template_directory() . '/admin/');
define('ADMIN_DIR', get_template_directory_uri() . '/admin/');
define('LAYOUT_PATH', get_template_directory() . '/css/skins/');

// You can mess with these 2 if you wish.
//$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
$themedata = wp_get_theme();
define('THEMENAME', $themedata->Name);
define('OPTIONS', 'of_options'); // Name of the database row where your options are stored
define('BACKUPS', 'of_backups'); // Name of the database row for options backup

// Build Options
require_once (ADMIN_PATH . 'admin-interface.php'); // Admin Interfaces
require_once (ADMIN_PATH . 'theme-options.php'); // Options panel settings and custom settings
require_once (ADMIN_PATH . 'admin-functions.php'); // Theme actions based on options settings
require_once (ADMIN_PATH . 'medialibrary-uploader.php'); // Media Library Uploader
