<?php
/*
    Wordpress Water Theme - Copyright © 2008  Fallen Tsubasa

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

include_once(TEMPLATEPATH ."/inc/global.php");
include_once(TEMPLATEPATH ."/inc/posts.php");
include_once(TEMPLATEPATH ."/inc/vars.php");
include_once(TEMPLATEPATH ."/inc/sidebar.php");

// Basic things to avoid errors!
function water_loaded()
{
	if( !is_robots() && !is_feed() && !is_trackback() )
	{
		// Get the header
		add_action('get_header', 'merge_water');
		add_action('template_redirect', 'get_header');
		add_action('template_content_end', 'get_sidebar');
		add_action('template_content_end', 'get_footer');
	}
}

function water_theme($wp)
{
	$switch = @$wp->query_vars['try'];
	if( !empty($switch) )
	{
		switch($switch)
		{
			default:
				wp_die('Invalid CSS File.');
			case 'preview.css':
				define('WATER_PREVIEW', 1);
			case 'style.css':
				break;
		}
		global $water;
		merge_water();
		$water = (array)$water;
		require_once(TEMPLATEPATH .'/style.php');
		die;
	}
}

function water_menu_add()
{
	global $water_menu;
	require TEMPLATEPATH . '/inc/settings.php';
	$water_menu = array();
	water_submenu_add();
	water_settings_save();
	add_theme_page(
		$water_menu[water_index()]['title'],
		'Settings',
		'edit_themes',
		'water.php',
		'water_menu'
	);
}

// Add the filters and actions
add_filter('query_vars', create_function("\$a","\$a[]='try';return \$a;"));
add_action('parse_request', 'water_theme');
add_action('wp', 'water_loaded');
add_action('admin_menu', 'water_menu_add');
add_action('admin_head', create_function('', 'echo "<style type=\"text/css\">\r\n#excerpt {\r\n\theight: 150px;\r\n}\r\n\r\n#watermenu {\r\n\tmargin: 0;\r\n\tlist-style: none;\r\n\tpadding: 0 0 3px 0;\r\n}\r\n\r\n#watermenu a {\r\n\ttext-decoration: none;\r\n\tcolor: #2583ad;\r\n}\r\n\r\n#watermenu a:hover, #watermenu a.current {\r\n\tcolor: #d54e21;\r\n}\r\n\r\n#watermenu li {\r\n\tdisplay: inline;\r\n\tline-height: 200%;\r\n\tlist-style: none;\r\n\ttext-align: center;\r\n\twhite-space: nowrap;\r\n\tmargin: 0;\r\n\tpadding: 0 0 8px 17px;\r\n\tfont-size: 14px;\r\n}\r\n.default {\r\n\tdisplay: block;\r\n\tfont-weight: normal;\r\n}\r\n</style>\r\n", \'<script type="text/javascript" src="\', get_bloginfo(\'template_directory\') , \'/jscolor/jscolor.js"></script>\', "\r\n";'));
?>