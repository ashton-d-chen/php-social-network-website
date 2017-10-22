<?php
function water_menu()
{
	global $water_menu;
	$index = water_index();
?>

<ul id="watermenu">

<?php
	for($i = 0; $i < sizeof($water_menu); ++$i )
	{
		echo "\t<li><a href=\"themes.php?page=water.php&subpage={$water_menu[$i]['page']}\"",
			($i == $index ? ' class="current"' : ''),
			">{$water_menu[$i]['tab']}</a></li>\n";
	}
?>

</ul>

<?php
	water_setting_data();
}

function add_water_page($title, $tab, $subpage)
{
	global $water_menu;
	$water_menu[] = array('title' => $title, 'tab' => $tab, 'page' => $subpage);
}

function water_submenu_add()
{
	add_water_page('Manage CSS Codes', 'Styling', 'css');
	add_water_page('Manage Header', 'Header/Tabs', 'header-tabs');
	add_water_page('Manage Entries', 'Entries', 'entries');

	add_water_page('Manage Theme Settings', 'All Settings', 'all');
	add_water_page('Delete Settings', 'Delete Options', 'delete');

}

function water_setting_data()
{
	global $water, $water_menu, $wt_alt;
	$wt_alt = NULL;
	merge_water();

	// The (3) or (2) just means the header number; (2) means <h2></h2>, and (3) means <h3></h3>
	switch( $water_menu[water_index()]['page'] )
	{
		case 'all': default:
			$settings = array
			(
				'style(2)',
				'header_tabs(3)',
				'entries(3)',
			);
			break;
		case 'css':
			$settings = 'style(2)';
			break;
		case 'header-tabs':
			$settings = 'header_tabs(2)';
			break;
		case 'entries':
			$settings = 'entries(2)';
			break;
		case 'delete':
			$settings = 'delete(2)';
			break;
	}

	// The functions are called with the argument $water... this actually allows the script to exectute a bit faster...
	$settings = preg_replace(array('/(.*)\((.*)\)/i', '/(.*)\)/i'), array('water_$1($2)', '$1, $water);'), $settings);
	
	if( is_array($settings) )
	{
		$settings = implode("\n", $settings);
	}

	echo "<div class=\"wrap\">\n",
	"<form method=\"post\" action=\"themes.php?page={$_REQUEST['page']}\">",
	(
		isset($_REQUEST['saved']) ?
		'<div id="message" class="updated fade"><p><strong>Your Water settings have been saved.</strong></p></div>' :
		(
			isset($_REQUEST['resetted']) ? '<div id="message" class="updated fade"><p><strong>The setting(s) you deleted have been resetted to its default value.</strong></p></div>' : ''
		)
	);

	eval($settings);

	echo "\n<p class=\"submit\">\n<input name=\"save\" type=\"submit\" value=\"Save changes\" />\n<input type=\"hidden\" name=\"action\" value=\"save\" />\n</p>\n<input type=\"hidden\" name=\"water_last_index\" value=\"", $water_menu[water_index()]['page'] ,"\"/></form>";
}

function water_style($h, $w)
{
?>

<h<?php echo $h; ?>>Stylesheet Settings</h<?php echo $h; ?>>
<p>You can either have the size in px which will result in a fixed width and will not change from monitor to monitor while if you use percentages, it can vary from monitor to monitor. Changing the width of the blog, post width and sidebar width can have undesired effects. You use the px format to make it fit perfectly in your screen but, if someone else had a bigger screen, it would look a lot smaller as it won&#39;t fill the whole screen. If you used percentages, you can have it looking pretty but, as the screen gets bigger, it begins to look odd and not the way you want it.</p>

<table class="widefat post fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" class="manage-column column-author" style="width: 200px;">Option Name</th>
			<th scope="col" class="manage-column column-title" style="">Option Value(s)</th>
		</tr>
	</thead>

	<tr valign="top"<?php wt_alt(true); ?>>
		<th scope="row"><label for="max_width">Blog's Width</label><div class="default">Default Max: 980px<br />Default Post: 760px<br />Default Comment: 700px<br />Default Sidebar Right: 180px<br />Default Sidebar Lef: 0</div></th>
		<td>
			<input name="max_width[max]" type="text" value="<?php echo $w['max_width']['max']; ?>" size="40" /><br />
			<strong>Max Width:</strong> Adjusts the width of the whole blog.<br /><br />

			<input name="max_width[content]" type="text" value="<?php echo $w['max_width']['content']; ?>" size="40" /><br />
			<strong>Post Width:</strong> Adjust the width of the posts only.<br /><br />

			<input name="max_width[comment]" type="text" value="<?php echo $w['max_width']['comment']; ?>" size="40" /><br />
			<strong>Comment Width:</strong> Adjust the width of the comments only.<br /><br />

			<input name="max_width[sidebar_1]" type="text" value="<?php echo $w['max_width']['sidebar_1']; ?>" size="40" /><br />
			<strong>Right Width:</strong> Changes the size of the first sidebar only. <u>Leave it empty or set it to 0 if you want it gone.</u><br /><br />

			<input name="max_width[sidebar_2]" type="text" value="<?php echo $w['max_width']['sidebar_2']; ?>" size="40" /><br />
			<strong>Left Width:</strong> Changes the size of the second sidebar only. <u>Leave it empty or set it to 0 if you want it gone.</u>
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="font_fam">Font Type (Family)</label><div class="default">Default: "Trebuchet MS", sans-serif</div></th>
		<td>
			<select name="font_fam">
<?php
	$options = array
	(
		'"Trebuchet MS", sans-serif',
		'Comic Sans MS',
		'Brush Script MT',
		'Verdana, sans-serif',
		'Arial, sans-serif',
		'Georgia, serif'
	);

	$options = htmlentities_deep($options);

	foreach( $options as $k => $option )
	{
		if( $k )
		{
			echo "\n<br />";
		}
?>

			<option value="<?php echo $option;?>"<?php selected($w['font_fam'], $option); ?>> <?php echo $option; ?></option>

<?php
	}
?>
			</select>
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="bdy_bgcolor">Background Color</label><div class="default">Default: #FFF</div></th>
		<td>
			<input name="bdy_bgcolor" type="text" value="<?php echo $w['bdy_bgcolor']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			Changes the background color of the theme. If you do change the background color, it&#39;s recommended that you replace the default header image.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="bdy_color">Body Color</label><div class="default">Default: #333</div></th>
		<td>
			<input name="bdy_color" type="text" value="<?php echo $w['bdy_color']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			Changes the text color in posts, the sidebar(s), and tabs.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="maincolor">Main Colors</label><div class="default">Default Main 1: #73A533<br />Default Main 2: #0092C8</div></th>
		<td>
			<input name="maincolor[0]" type="text" value="<?php echo $w['maincolor'][0]; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<strong>Main Color 1:</strong> Changes the color of the Title, Tabs, links in comments and etc&#8230;
			<br /><br />
			<input name="maincolor[1]" type="text" value="<?php echo $w['maincolor'][1]; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<strong>Main Color 2:</strong> Changes the color of the blogline tag, title of post, color of links and etc&#8230;
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="gray">Gray Colors</label><div class="default">Default Gray 1: #CCC<br />Default Gray 2: #AAA<br />Default Gray 3: #7E7E7E</div></th>
		<td>
			<input name="gray[0]" type="text" value="<?php echo $w['gray'][0]; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<strong>Gray 1:</strong> Changes the color of the border line that separate the title and tabs, the body  and the footer.<br /><br />
			<input name="gray[1]" type="text" value="<?php echo $w['gray'][1]; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<strong>Gray 2:</strong> Changes the color of the footer info and the &#34;filed under by&#34; description under post title in the blog.<br /><br />
			<input name="gray[2]" type="text" value="<?php echo $w['gray'][2]; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<strong>Gray 3:</strong> Changes the color of the category the post is filed under in a post.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="h1[color]">Heading 1 Color</label><div class="default">Default Color: #177FA5<br />Default Size: 22px</div></th>
		<td>
			<input name="h1[color]" type="text" value="<?php echo $w['h1']['color']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h1[color]"><strong>Heading 1 Color</strong></label> Font color for &lt;h1&gt; (Heading 1) in your posts.
			<br /><br />
			<input name="h1[size]" type="text" value="<?php echo $w['h1']['size']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h1[size]"><strong>Heading 1 Size</strong></label> Font size for &lt;h1&gt; (Heading 1) in your posts.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="h2[color]">Heading 2 Color</label><div class="default">Default Color: #67873E<br />Default Size: 22px</div></th>
		<td>
			<input name="h2[color]" type="text" value="<?php echo $w['h2']['color']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h2[color]"><strong>Heading 2 Color</strong></label> Font color for &lt;h2&gt; (Heading 2) in your posts.
			<br /><br />
			<input name="h2[size]" type="text" value="<?php echo $w['h2']['size']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h2[size]"><strong>Heading 2 Size</strong></label> Font size for &lt;h2&gt; (Heading 2) in your posts.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="h3[color]">Heading 3 Color</label><div class="default">Default Color: #0AA6DF<br />Default Size: 20px</div></th>
		<td>
			<input name="h3[color]" type="text" value="<?php echo $w['h3']['color']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h3[color]"><strong>Heading 3 Color</strong></label> Font color for &lt;h3&gt; (Heading 3) in your posts.
			<br /><br />
			<input name="h3[size]" type="text" value="<?php echo $w['h3']['size']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h3[size]"><strong>Heading 3 Size</strong></label> Font size for &lt;h3&gt; (Heading 3) in your posts.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="h4[color]">Heading 4 Color</label><div class="default">Default Color: #81D417<br />Default Size: 20px</div></th>
		<td>
			<input name="h4[color]" type="text" value="<?php echo $w['h4']['color']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h4[color]"><strong>Heading 4 Color</strong></label> Font color for &lt;h4&gt; (Heading 4) in your posts.
			<br /><br />
			<input name="h4[size]" type="text" value="<?php echo $w['h4']['size']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h4[size]"><strong>Heading 4 Size</strong></label> Font size for &lt;h4&gt; (Heading 4) in your posts.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="h5[color]">Heading 5 Color</label><div class="default">Default Color: #7BBFD8<br />Default Size: 18px</div></th>
		<td>
			<input name="h5[color]" type="text" value="<?php echo $w['h5']['color']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h5[color]"><strong>Heading 5 Color</strong></label> Font color for &lt;h5&gt; (Heading 5) in your posts.
			<br /><br />
			<input name="h5[size]" type="text" value="<?php echo $w['h5']['size']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h5[size]"><strong>Heading 5 Size</strong></label> Font size for &lt;h5&gt; (Heading 5) in your posts.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="h6[color]">Heading 6 Color</label><div class="default">Default Color: #B9E383<br />Default Size: 18px</div></th>
		<td>
			<input name="h6[color]" type="text" value="<?php echo $w['h6']['color']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h6[color]"><strong>Heading 6 Color</strong></label> Font color for &lt;h6&gt; (Heading 6) in your posts.
			<br /><br />
			<input name="h6[size]" type="text" value="<?php echo $w['h6']['size']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="h6[size]"><strong>Heading 6 Size</strong></label> Font size for &lt;h6&gt; (Heading 6) in your posts.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="comment_colors">Comment Background Color</label><div class="default">Default Even: #FFF<br />Default Odd: #F3F3F3</div></th>
		<td>
			<input name="comment[even]" type="text" value="<?php echo $w['comment']['even']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="comment[even]"><strong>Comment Color for Evens:</strong></label> The highlighted color for all even numbered comments.
			<br /><br />
			<input name="comment[odd]" type="text" value="<?php echo $w['comment']['odd']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			<label for="comment[odd]"><strong>Comment Color for Odds:</strong></label> The highlighted color for all odd numbered comments.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="comment[author]">Post Author's Background Color</label><div class="default">Default: #EAF3FA</div></th>
		<td>
			<input name="comment[author]" type="text" value="<?php echo $w['comment']['author']; ?>" size="40" class="color {pickerPosition:'bottom',adjust:false,required:false,pickerMode:'HVS'}" /><br />
			Your own personal color that distinguishes the author from the rest of the other people who commented. If this is left empty, your personal color will be treated as the next odd/even color.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="comment[thread]">Threaded Comment Width</label><div class="default">Default: 88%,86%,83%</div></th>
		<td>
			<input name="comment[thread]" type="text" value="<?php echo implode(',',explode(',',$w['comment']['thread'])); ?>" size="40" /><br />
			The width (percent or pixels) of each threaded comment (for how deep it is). If you want to have 5 "nest levels," here are the numbers for it: 88%,86%,83%,81%,76%. Here's a diagram to illustrate what it means:
<pre>Comment #1
	Comment #3 (Width: 88%)
		Comment #6 (Width: 86%)
	Comment #4 (Width: 88%)
		Comment #5 (Width: 86%)
			Comment #7 (Width: 83%)
Comment #2
	Comment #8 (Width: 88%)
	Comment #9 (Width: 88%)</pre><br />
			Leave empty to disable the CSS bits.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="custom_css">Custom CSS</label><div class="default">Default: <em>Empty</em></div></th>
		<td>
			<textarea name="custom_css" cols="60" rows="10" style="width: 98%; font-size: 12px;" class="code"><?php echo htmlentities($w['custom_css']); ?></textarea><br />
			This is where you place all your own CSS code into for whatever plugin(s) you have. For instance, if you have WordPress.com Stats and wish to hide the smilie permanently, the code below will be auto-added to your style.css when you update your options! No more worries about your own CSS in style.css getting overrided anymore!
		</td>
	</tr>
</table>

<?php
}

function water_header_tabs($h, $w)
{
?>
<h<?php echo $h; ?>>Header Settings</h<?php echo $h; ?>>

<table class="widefat post fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" class="manage-column column-author" style="width: 200px;">Option Name</th>
			<th scope="col" class="manage-column column-title" style="">Option Value(s)</th>
		</tr>
	</thead>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="meta_tags">Meta Tags (Header)</label><div class="default">Default: Disabled</div></th>
		<td>
			<label><input type="radio" name="meta_tags" value="1"<?php checked($w['meta_tags'], 1); ?> /> Enabled</label><br />
			<label><input type="radio" name="meta_tags" value="0"<?php checked($w['meta_tags'], 0); ?> /> Disabled</label><br />
			This shows your blog's post tags in your header to improve Search Engine Optimization (i.e. for sites like Google).
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(true); ?>>
		<th scope="row"><label for="blog_description">Meta Description</label><div class="default">Default: <em>Empty</em></div></th>
		<td>
			<input type="text" name="blog_description"  class="code" value="<?php echo htmlentities($w['blog_description']); ?>" size="40" style="width: 95%;" /><br />
			Leave empty to disable.<br />
			This description will be shown in search engines like Google whenever someone searches for something related to your blog.
			
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="title_size">Title Size</label><div class="default">Default: 30px</div></th>
		<td>
			<input name="title_size" type="text" value="<?php echo $w['title_size']; ?>" size="40" /><br />
			Maximum font size for the theme to use for the Title. Automatically set as pixels.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="head_img">Banner Image</label><div class="default">Default: images/header.jpg</div></th>
		<td>
			<input name="head_img[url]" type="text" value="<?php echo htmlentities($w['head_img']['url']); ?>" size="40" style="width: 80%" class="code" /> <input type="button" value="Preview" onclick="var imgurl = document.getElementsByName('head_img[url]')[0].value, regx = /^(http|ftp)s?:/i; document.getElementById('head_img_prev').src = (regx.test( imgurl ) ? '' : '<?php bloginfo('template_directory');?>/') + imgurl;" /><br />
			The URL of where the banner is supposed to be. The banner defaultly is called header.jpg and in the image folder in the water theme folder. <strong>If you enabled Text CSS, the default value for this will not work!</strong>
			<img width="95%" src="<?php if( preg_match('/^(http|ftp)s?:/i', $w['head_img']['url']) ) : echo $w['head_img']['url']; else: bloginfo('template_directory'); echo '/', $w['head_img']['url']; endif; ?>" id="head_img_prev" />
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="head_img">Banner Position</label><div class="default">Default: Center</div></th>
		<td>
			<select name="head_img[pos]">
				<option value="left"<?php selected($w['head_img']['pos'], 'left'); ?>>Left</option>
				<option value="center"<?php selected($w['head_img']['pos'], 'center'); ?>>Center</option>
				<option value="right"<?php selected($w['head_img']['pos'], 'right'); ?>>Right</option>
			</select><br />
			The position in which the header's image is aligned at.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="head_img">Header Size</label><div class="default">Default Width: 100%<br />Default Height: 150px</div></th>
		<td>
			<input name="head_img[w]" type="text" value="<?php echo $w['head_img']['w']; ?>" size="40" /><br />
			<strong>Header Width:</strong> Maximum width of the header image. This setting can use 100% so it can be left alone.
			<br /><br />
			<input name="head_img[h]" type="text" value="<?php echo $w['head_img']['h']; ?>" size="40" /><br />
			<strong>Header Height:</strong> Maximum height of the header image. You must input the correct height of the image in px if you upload your own banner to use.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="hide">Tab Names</label></th>
		<td>
			<input name="page_name" type="text" value="<?php echo htmlentities($w['page_name']); ?>" size="40" /><br />
			<strong>Page Tab:</strong> Changes the default tab named &#34;Page&#34; into something else. Leave empty to disable tab.<br /><br />
			<input name="cat_name" type="text" value="<?php echo htmlentities($w['cat_name']); ?>" size="40" /><br />
			<strong>Category Tab:</strong> Changes the default tab named &#34;Category&#34; into something else. Leave empty to disable tab.<br /><br />
			<input name="archive_name" type="text" value="<?php echo htmlentities($w['archive_name']); ?>" size="40" /><br />
			<strong>Archive Tab:</strong> Changes the default tab named &#34;Archive&#34; into something else. Leave empty to disable tab.<br /><br />
			<input name="options_name" type="text" value="<?php echo htmlentities($w['options_name']); ?>" size="40" /><br />
			<strong>Options Tab:</strong> Adds a special tab that have meta options like logging in/out, registering and various options depending of user status. Leave empty to disable tab.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="tagline_pos">Tagline Position</label><div class="default">Default: <em>Top Right</em></div></th>
		<td>
			<select name="tagline_pos">
<?php
	$options = array
	(
		'Disable',
		'Top Left',
		'Top Right',
		'Bottom Left',
		'Bottom Right'
	);

	foreach($options as $j => $k)
	{
?>
				<option value="<?php echo $j; ?>"<?php selected($j,$w['tagline_pos']); ?>><?php echo $k; ?></option>
<?php
	}
?>
			</select>
		</td>
	</tr>

</table>

<h<?php echo $h; ?>>Categories</h<?php echo $h; ?>>

<table class="widefat post fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" class="manage-column column-author" style="width: 200px;">Option Name</th>
			<th scope="col" class="manage-column column-title" style="" colspan="2">Option Value(s)</th>
		</tr>
	</thead>

	<tr valign="top"<?php wt_alt(true); ?>>
		<th scope="row"><label for="cat_exclude">Category Exclusion</label></th>
<?php
	$categories = get_categories('orderby=name&order=ASC&hide_empty=0');
	if( empty($categories) )
	{
?>
		<td colspan="2"><em>No Categories Found!</em></td>
	</tr>
<?php
	}
	else
	{
		$categories = separate_array_by_row($categories, 2);
		$w['cat_exclude'] = explode(',', $w['cat_exclude']);
		$cats = array();
		foreach($w['cat_exclude'] as $cat)
		{
			$cats[$cat] = $cat;
		}
		foreach( $categories as $cat )
		{
			$size = sizeof($cat) - 1;
			if( $size < 0 )
			{
				break;
			}
?>
		<td<?php
			if( empty($categories[1]) )
			{
				echo ' colspan="2"';
			}
?>>
<?php
			foreach( $cat as $k => $c )
			{
?>

			<input name="cat_exclude[<?php $c->cat_ID; ?>]" type="checkbox" <?php checked($cats[$c->cat_ID], $c->cat_ID); ?> value="<?php echo $c->cat_ID; ?>" /> <label for="cat_exclude[<?php echo $c->cat_ID; ?>]"><?php echo $c->cat_name; ?></label><?php if( $size != $k ) : ?><br /><?php endif; ?>

<?php
			}
?>
		</td>
<?php
		}
?>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="cat_group">User Permissions for Categories</label><div class="default">Default: Subscriber</div></th>
		<td colspan="2">
			<select name="cat_group">
<?php
		foreach( user_types() as $u => $ug )
		{
?>

				<option<?php selected($w['cat_group'], $ug); ?> value="<?php echo $ug; ?>"><?php echo $u; ?></option>

<?php
		}
?>
			</select><br />
			Sets the lowest user group that is allowed to see excluded categories.
		</td>
	</tr>
<?php
	}
?>
</table>

<h<?php echo $h; ?>>Pages</h<?php echo $h; ?>>

<table class="widefat post fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" class="manage-column column-author" style="width: 200px;">Option Name</th>
			<th scope="col" class="manage-column column-title" style="" colspan="2">Option Value(s)</th>
		</tr>
	</thead>

	<tr valign="top"<?php wt_alt(true); ?>>
		<th scope="row"><label for="pg_exclude">Pages to Exclude</label></th>
<?php
	$pages = get_pages('sort_column=menu_order');
	if( empty($pages) )
	{
?>
		<td colspan="2"><em>No Pages Found!</em></td>
	</tr>
<?php
	}
	else
	{
		$pages = separate_array_by_row($pages, 2);
		$w['pg_exclude'] = explode(',', $w['pg_exclude']);
		$pgs = array();
		foreach( $w['pg_exclude'] as $pg )
		{
			$pgs[$pg] = $pg;
		}
		foreach( $pages as $page )
		{
			$size = sizeof($page) - 1;
			if( $size < 0 )
			{
				break;
			}
?>
		<td<?php
			if( empty($pages[1]) )
			{
				echo ' colspan="2"';
			}
?>>
<?php
			foreach( $page as $k => $p )
			{
?>

			<input name="pg_exclude[<?php $p->ID; ?>]" type="checkbox" <?php checked($pgs[$p->ID], $p->ID); ?> value="<?php echo $p->ID; ?>" /> <label for="pg_exclude[<?php echo $p->ID; ?>]"><?php echo $p->post_title; ?></label><?php if( $size != $k ) : ?><br /><?php endif; ?>

<?php
			}
?>
		</td>
<?php
		}
?>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="cat_group">User permissions for Pages</label><div class="default">Default: Subscriber</div></th>
		<td colspan="2">
			<select name="page_group">
<?php
		foreach( user_types() as $u => $ug )
		{
?>

				<option<?php selected($w['page_group'], $ug); ?> value="<?php echo $ug; ?>"><?php echo $u; ?></option>

<?php
		}
?>
			</select><br />
			Sets the lowest user group that is allowed to see excluded pages.
		</td>
	</tr>
<?php
	}
?>
</table>
<?php
}

function water_entries($h, $w)
{
?>
<h<?php echo $h; ?>>Posts</h<?php echo $h; ?>>

<table class="widefat post fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" class="manage-column column-author" style="width: 200px;">Option Name</th>
			<th scope="col" class="manage-column column-title" style="">Option Value(s)</th>
		</tr>
	</thead>

	<tr valign="top"<?php wt_alt(true); ?>>
		<th scope="row"><label for="excerpt_index">Excerpt in Index/Search</label><div class="default">Default: Disable</div></th>
		<td>
			<label><input type="radio" name="excerpt_index" value="1"<?php checked($w['excerpt_index'], 1); ?> /> Enable</label><br />
			<label><input type="radio" name="excerpt_index" value="0"<?php checked($w['excerpt_index'], 0); ?> /> Disable</label><br />
			Shows your "Optional Excerpt" in Index/Search view. If excerpt does not exist, it will use the full post's content.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="show_tags">Post Tags</label><div class="default">Default: Enable</div></th>
		<td>
			<label><input type="radio" name="show_tags" value="1"<?php checked($w['show_tags'], 1); ?> /> Enable</label><br />
			<label><input type="radio" name="show_tags" value="0"<?php checked($w['show_tags'], 0); ?> /> Disable</label><br />
			Option to show tags in post. Comes in handy when categorizing things even more.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="author_email">Show Author's E-Mail in Author Page</label><div class="default">Default: Disable</div></th>
		<td>
			<label><input type="radio" name="author_email" value="1"<?php checked($w['author_email'], 1); ?> /> Enable</label><br />
			<label><input type="radio" name="author_email" value="0"<?php checked($w['author_email'], 0); ?> /> Disable</label><br />
			Show the author's e-mail in the Author page? Note that this may be an invasion of privacy.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="show_com_top">Comment Count next to Post Title</label><div class="default">Default: Disable</div></th>
		<td>
			<label><input type="radio" name="show_com_top" value="1"<?php checked($w['show_com_top'], 1); ?> /> Enable</label><br />
			<label><input type="radio" name="show_com_top" value="0"<?php checked($w['show_com_top'], 0); ?> /> Disable</label><br />
			Displays a faint grey text next to the title of your post that tells you the total comments in that post.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="gravatar[size]">Gravatar Size</label><div class="default">Default: 45</div></th>
		<td><input name="gravatar[size]" type="text" value="<?php echo $w['gravatar']['size']; ?>" size="40" /><br />
		The maximum size that the gravatar (for comments only!) should be at. It is recommended that it stays the same size because it goes into the lines where the comment text are supposed to be at. All negative values will be changed to positive.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="gravatar[default]">Default Gravatar</label><div class="default">Default: <em>Empty</em></div></th>
		<td><input name="gravatar[default]" type="text" value="<?php echo $w['gravatar']['default']; ?>" size="40" style="width: 80%" class="code" /><br />
		The default Gravatar (link to image) to be shown if the commenter has no e-mail/e-mail does not have a gravatar.
		</td>
	</tr>

	<tr valign="top"<?php wt_alt(); ?>>
		<th scope="row"><label for="page_comments">Comments for Pages</label><div class="default">Default: Disabled</div></th>
		<td>
			<label><input type="radio" name="page_comments" value="1"<?php checked($w['page_comments'], 1); ?> /> Enabled</label><br />
			<label><input type="radio" name="page_comments" value="0"<?php checked($w['page_comments'], 0); ?> /> Disabled</label>
		</td>
	</tr>
</table>
<?php
}

function water_delete($h, $w)
{
?>

<script type="text/javascript">
function all_deletes(is_check) {
	var f = document.getElementsByName('delete_options[]'), i;
	for( i = 0; i < f.length; i++ ) {
		f[i].checked = is_check;
	}
}
</script>

<h<?php echo $h; ?>>Delete Options</h<?php echo $h; ?>>

<table class="widefat post fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" onclick="all_deletes(this.checked || this.getAttribute('checked'));"/></th>
			<th scope="col" class="manage-column column-title" style="">Delete Option with Title:</th>
			<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" onclick="all_deletes(this.checked || this.getAttribute('checked'));"/></th>
			<th scope="col" class="manage-column column-title" style="">Title</th>
		</tr>
	</thead>
<?php
	global $wt_alt;
	$wt_alt = NULL;
	$desc = setting_descriptions();
	$desc = separate_array_by_col($desc, 2);
	$alt = ' class="alternate"';
	foreach($desc as $i => $d)
	{
?>
	<tr valign="top"<?php wt_alt(); ?>>
<?php
		foreach($d as $h => $k)
		{
?>
	<th scope="row" class="check-column"><input type="checkbox" name="delete_options[]" value="<?php echo $h; ?>" /></th>
	<td class="column-title"<?php if( sizeof($d) == 1) echo ' colspan="3"'; ?>><strong><?php echo $k; ?></strong>
<?php
		}
?>
	</tr>
<?php
	}
?>
</table>
<?php
}

function water_index()
{
	global $water_menu;
	$index = 0;
	$_GET['subpage'] = (string)$_GET['subpage'];
	for($i = 0; $i < sizeof($water_menu); ++$i)
		if( $_GET['subpage'] === $water_menu[$i]['page'] )
			$index = $i;
	return $index;
}

function water_settings_save()
{
	if( $_GET['page'] !== 'water.php' || !isset($_REQUEST['action']) || !isset($_REQUEST['water_last_index']) )
	{
		return;
	}
	global $water_menu, $water;
	define('WATER_PREVIEW', 1); // Original data
	merge_water();
	$save = array();
	$resetted = '';

	$_POST = stripslashes_deep($_POST);
	$_REQUEST = array_merge($_REQUEST, $_POST); // Also add it into the requests

	if( isset($_REQUEST['action']) && $_REQUEST['action'] === 'save' && !isset($_REQUEST['delete_options']) )
	{
		$custom_css = $_REQUEST['custom_css'];
		if( $_REQUEST['water_last_index'] === 'all' )
		{
			$f = array
			(
				'css',
				'header-tabs',
				'entries'
			);
		}
		else
		{
			$f = array($_REQUEST['water_last_index']);
		}

		$r = array();
		$custom = array();
		$bcustom = array();

		foreach( $f as $g )
		{
			switch($g)
			{
				case 'css':
					$settings = array
					(
						'max_width'        =>  array
						(
							'max'       => $_REQUEST['max_width']['max'],
							'content'   => $_REQUEST['max_width']['content'],
							'sidebar_1' => $_REQUEST['max_width']['sidebar_1'],
							'sidebar_2' => $_REQUEST['max_width']['sidebar_2'],
							'comment'   => $_REQUEST['max_width']['comment']
						),

						'font_fam'      => $_REQUEST['font_fam'],
						'bdy_bgcolor'   => $_REQUEST['bdy_bgcolor'],
						'bdy_color'     => $_REQUEST['bdy_color'],

						'maincolor'     => array
						(
							$_REQUEST['maincolor'][0],
							$_REQUEST['maincolor'][1]
						),

						'gray'          => array
						(
							$_REQUEST['gray'][0],
							$_REQUEST['gray'][1],
							$_REQUEST['gray'][2]
						),

						'h1' => array
						(
							'color' => $_REQUEST['h1']['color'],
							'size'  => $_REQUEST['h1']['size']
						),

						'h2' => array
						(
							'color' => $_REQUEST['h2']['color'],
							'size'  => $_REQUEST['h2']['size']			
						),

						'h3' => array
						(
							'color' => $_REQUEST['h3']['color'],
							'size'  => $_REQUEST['h3']['size']
						),

						'h4' => array
						(
							'color' => $_REQUEST['h4']['color'],
							'size'  => $_REQUEST['h4']['size']
						),

						'h5' => array
						(
							'color' => $_REQUEST['h5']['color'],
							'size'  => $_REQUEST['h5']['size']
						),

						'h6' => array
						(
							'color' => $_REQUEST['h6']['color'],
							'size'  => $_REQUEST['h6']['size']
						),

						'comment'  => array
						(
							'even'   => $_REQUEST['comment']['even'],
							'odd'    => $_REQUEST['comment']['odd'],
							'author' => $_REQUEST['comment']['author'],
							'thread' => $_REQUEST['comment']['thread']
						)
					);

					$r = array
					(
						'custom_css' => (string) $_REQUEST['custom_css']
					);

					break;
				case 'header-tabs':
					$settings = array
					(
						'meta_tags'        => $_REQUEST['meta_tags'],
						'blog_description' => '',
						'title_size'       => $_REQUEST['title_size'],
						'head_img'         => array
						(
							'url' => trim($_REQUEST['head_img']['url'], '\/'),
							'w'   => $_REQUEST['head_img']['w'],
							'h'   => $_REQUEST['head_img']['h'],
							'pos' => $_REQUEST['head_img']['pos']
						),

						'archive_name'     => $_REQUEST['archive_name'],
						'options_name'     => $_REQUEST['options_name'],
						'cat_name'         => $_REQUEST['cat_name'],
						'page_name'        => $_REQUEST['page_name'],
						'tagline_pos'      => $_REQUEST['tagline_pos'],
						'cat_exclude'      => is_array($_REQUEST['cat_exclude']) ? implode(',', $_REQUEST['cat_exclude']) : '',
						'cat_group'        => $_REQUEST['cat_group'],
						'pg_exclude'       => is_array($_REQUEST['pg_exclude']) ? implode(',', $_REQUEST['pg_exclude']) : '',
						'page_group'       => $_REQUEST['page_group']
					);
					break;
				case 'entries':
					$settings = array
					(
						'excerpt_index'    => $_REQUEST['excerpt_index'],
						'show_tags'        => $_REQUEST['show_tags'],
						'author_email'     => $_REQUEST['author_email'],
						'show_com_top'     => $_REQUEST['show_com_top'],
						'gravatar'         => array
						(
							'size'     => abs(intval($_REQUEST['gravatar']['size'])),
							'default'  => $_REQUEST['gravatar']['default']
						)
					);

					$r = array('page_comments' => intval($_REQUEST['page_comments']));
					break;
			}

			$custom = array_merge($custom, $settings);
			$bcustom = array_merge($bcustom, $r);
		}

		$save = get_option('water_data');
		$save = is_array($save) ? $save : array();

		foreach( $custom as $k => $a )
		{
			if( is_array($a) )
			{
				foreach( $a as $i => $o )
				{
					if( $o === null )
					{
						$o = '';
					}
					if( $o != $water[$k][$i] )
					{
						$save[$k][$i] = $o;
					}
					else
					{
						$save[$k][$i] = NULL;
						unset($save[$k][$i]);
					}
				}
			}
			else
			{
				if( $a === null )
				{
					$a = '';
				}
				if( $a != $water[$k] )
				{
					$save[$k] = $a;
				}
				else
				{
					$save[$k] = NULL;
					unset($save[$k]);
				}
			}
		}

		if( !empty($save) )
		{
			update_option('water_data', $save);
		}
		else
		{
			delete_option('water_data');
		}

		if( isset($bcustom['custom_css']) && $water['custom_css'] != $bcustom['custom_css'] )
		{
			update_option('water_custom_css', $bcustom['custom_css']);
		}
		elseif( isset($bcustom['custom_css']) && $water['custom_css'] == $bcustom['custom_css'] )
		{
			delete_option('water_custom_css');
		}

		$bcustom['custom_css'] = NULL;
		unset($bcustom['custom_css']);

		$bool = get_option('water_booleans');
		$bool = is_array($bool) ? $bool : array();
		foreach( $bcustom as $i => $o )
		{
			if( $o != $water[$i] )
			{
				$bool[$i] = $o;
			}
			else
			{
				$bool[$i] = NULL;
				unset($bool[$i]);
			}
		}

		if( !empty($bool) )
		{
			update_option('water_booleans', $bool);
		}
		else
		{
			delete_option('water_booleans');
		}

		sleep(2); // Rest
		header("Location: themes.php?page=water.php&subpage=" . $_REQUEST['water_last_index'] . "&saved=true");
		die;
	}
	elseif( isset($_REQUEST['delete_options']) )
	{
		global $wpdb;

		$pseudo = setting_descriptions();
		if( sizeof($_REQUEST['delete_options']) >= sizeof($pseudo) )
		{
			delete_option('water_booleans');
			delete_option('water_data');
			delete_option('water_custom_css');
		}
		else
		{
			$data = get_option('water_data');
			if( empty($data) )
			{
				$data = array();
			}

			if( false !== array_search('custom_css', $_REQUEST['delete_options']) )
			{
				delete_option('water_custom_css');
			}

			$bool = array_map('intval', (array)get_option('water_booleans'));

			foreach( $_REQUEST['delete_options'] as $delete )
			{
				eval('unset($data' . $delete . '); unset($bool' . $delete . ');');
			}

			update_option('water_booleans', $bool);
			update_option('water_data', $data);
		}

		sleep(2); // Rest
		header("Location: themes.php?page=water.php&subpage=" . $_REQUEST['water_last_index'] . "&resetted=true");
		die;
	}
}

function user_types()
{
	return array
	(
		'Guest'         => 'guest',
		'Subscriber'    => 'subscriber',
		'Contributor'   => 'contributor',
		'Author'        => 'author',
		'Editor'        => 'editor',
		'Administrator' => 'administrator',
		'None'          => 'none'
	);
}

function setting_descriptions()
{
	return array
	(
		'[text_css]'             =>  'Text CSS',
		'[max_width][max]'       => 'Blog\'s Width',
		'[max_width][content]'   => 'Post Width',
		'[max_width][sidebar_1]' => 'Sidebar 1 Width',
		'[max_width][sidebar_2]' => 'Sidebar 2 Width',
		'[max_width][comment]'   => 'Comment Width',

		'[font_fam]'        => 'Font Family',
		'[bdy_bgcolor]'     => 'Background Color',
		'[bdy_color]'       => 'Body Color',
		'[title_size]'      => 'Title Size',

		'[maincolor][0]'    => 'Main Color 1',
		'[maincolor][1]'    => 'Main Color 2',

		'[gray][0]'         => 'Gray 1',
		'[gray][1]'         => 'Gray 2',
		'[gray][2]'         => 'Gray 3',

		'[h1][color]' => 'Heading 1\'s Color',
		'[h1][size]'  => 'Heading 1\'s Size',
		'[h2][color]' => 'Heading 2\'s Color',
		'[h2][size]'  => 'Heading 2\'s Size',
		'[h3][color]' => 'Heading 2\'s Color',
		'[h3][size]'  => 'Heading 3\'s Size',
		'[h4][color]' => 'Heading 4\'s Color',
		'[h4][size]'  => 'Heading 4\'s Size',
		'[h5][color]' => 'Heading 5\'s Color',
		'[h5][size]'  => 'Heading 5\'s Size',
		'[h6][color]' => 'Heading 6\'s Color',
		'[h6][size]'  => 'Heading 6\'s Size',

		'[head_img][url]'   => 'Banner Image',
		'[head_img][w]'     => 'Header Width',
		'[head_img][h]'     => 'Header Height',
		'[head_img][pos]'   => 'Banner Position',
		'[comment][even]'   => 'Comment - Even Color',
		'[comment][odd]'    => 'Comment - Odd Color',
		'[comment][author]' => 'Post Author\'s Comment Color',
		'[comment][thread]' => 'Nested (Threaded) Comments Width',
		'[custom_css]'      => 'Custom CSS',

		// Boolean Code
		'[show_com_top]'    => 'Comment Count After Post Title',
		'[page_comments]'   => 'Comments in Pages',

		'[show_tags]'       => 'Show Tags in Post',
		'[excerpt_index]'   => 'Excerpt in Index/Search View',
		'[tagline_pos]'     => 'Tagline Position',

		// Settings
		'[archive_name]'      => 'Archives Name',
		'[options_name]'      => 'Options Name',
		'[cat_name]'          => 'Categories Name',
		'[page_name]'         => 'Page Name',
		'[cat_exclude]'       => 'Category Exclusion',
		'[cat_group]'         => 'Category Exclusion Group',
		'[pg_exclude]'        => 'Page Exclusion',
		'[page_group]'        => 'Page Exclusion Group',
		'[gravatar][size]'    => 'Gravatar Size',
		'[gravatar][default]' => 'Default Gravatar',
		'[blog_description]'  => 'Blog Description (for SEO)',
		'[meta_tags]'         => 'Showing the Meta Tags',
		'[author_email]'      => 'Show Author\'s E-Mail in Author Page'
	);
}

function wt_alt($destroy = false)
{
	global $wt_alt;

	if( $destroy === true )
	{
		$wt_alt = NULL;
	}
	if( is_null($wt_alt) )
	{
		$wt_alt = ' class="alternate"';
	}
	else
	{
		$wt_alt = empty($wt_alt) ? ' class="alternate"' : '';
	}

	echo $wt_alt;
}
?>