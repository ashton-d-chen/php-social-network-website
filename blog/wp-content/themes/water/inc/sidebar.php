<?php
// Sidebar stuff
if( function_exists('register_sidebar') )
{
	register_sidebar(array(
		'name' => 'Right Sidebar',
		'id' => "sidebar-1",
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => "</li>\n",
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => "</h3>\n"));

	register_sidebar(array(
		'name' => 'Left Sidebar',
		'id' => "sidebar-2",
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => "</li>\n",
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => "</h3>\n"));
}

function widget_water_search()
{
?>
		<li id="search" class="widget search">
			<h3>Search</h3>
			<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
				<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
			</form>
		</li>
<?php
}

if( function_exists('register_sidebar_widget') )
{
	register_sidebar_widget(__('Search'), 'widget_water_search');
}
?>