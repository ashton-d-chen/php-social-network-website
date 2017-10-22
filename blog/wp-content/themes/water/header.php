<?php
	if( is_404() )
	{
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		die;
	}
	global $water;

	$css = 'style.css';
	if( isset($_GET['preview'],$_GET['template'],$_GET['stylesheet']) )
	{
		$css = "preview.css&preview=".$_GET['preview'] ."&template=".$_GET['template']."&stylesheet=". $_GET['stylesheet'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<?php
	echo '<title>';
	wp_title('|', true, 'right');
	bloginfo('name');
	echo '</title>';
?>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php
	if( !empty($water['blog_description']) )
	{
		echo "\n", '<meta name="description" content="', htmlentities($water['blog_description']) ,'" />';
	}

	if( $water['meta_tags'] )
		{
		if( is_singular() )
		{
			$k = get_the_term_list($post->ID,'post_tag', '', ', ', '');
			if( !empty($k) )
			{
				$k = explode(', ', strip_tags($k));
			}
		}
		else
		{
			$k = wp_tag_cloud('format=array&orderby=count&order=DESC');
		}
		if( !empty($k) )
		{
			$k = array_map('strip_tags', $k);
			echo "\n", '<meta name="keywords" content="', implode(', ', $k) ,'" />', "\n";
		}
		unset($k); // Who wants it anyways?
	}
?>
<link rel="stylesheet" href="<?php bloginfo('home'); ?>/?try=<?php echo $css; ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
	if( is_singular() )
	{
		wp_enqueue_script( 'comment-reply' );
	}
	wp_head();
	$water = htmlentities_deep($water);
?>
</head>
<body>
<div id="wrapper">
	<h1 id="title"><a href="<?php bloginfo('home'); ?>"><?php bloginfo('name'); ?></a></h1>
<?php
	$test = implode(array($water['page_name'], $water['cat_name'], $water['archive_name'], $water['options_name']));
	if( isset($test[1]) )
	{
		unset($test);
?>
	<div id="topmenu">
		<ul>
<?php
		if( !empty($water['page_name']) )
		{
?>
			<li onmouseover="this.className='msiefix'" onmouseout="this.className=''"><a href="#"><?php echo $water['page_name']; ?></a>
				<ul>
					<?php wp_list_pages('title_li=&depth=-1&exclude=' . ( isingroup($water['page_group']) ? $water['pg_exclude'] : '')); ?>
				</ul>
			</li>
<?php
		}

		if( !empty($water['cat_name']) )
		{
?>
			<li onmouseover="this.className='msiefix'" onmouseout="this.className=''"><a href="#"><?php echo $water['cat_name']; ?></a>
				<ul>
					<?php wp_list_categories('depth=-1&title_li=&exclude=' . $water['cat_exclude']); ?>
				</ul>
			</li>
<?php
		}

		if( !empty($water['archive_name']) )
		{
?>
			<li onmouseover="this.className='msiefix'" onmouseout="this.className=''" ><a href="#"><?php echo $water['archive_name']; ?></a>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>
<?php
		}

		if( !empty($water['options_name']) )
		{
?>
			<li onmouseover="this.className='msiefix'" onmouseout="this.className=''" ><a href="#"><?php echo $water['options_name']; ?></a>
				<ul>
<?php
			if( !is_user_logged_in() )
			{
?>
					<li><?php wp_loginout(); ?></li>
<?php
			}

			wp_register();

			if( current_user_can('publish_posts') )
			{
?>
					<li><a href="<?php bloginfo('home'); ?>/wp-admin/post-new.php">Write New Post</a></li>
					<li><a href="<?php bloginfo('home'); ?>/wp-admin/page-new.php">Write New Page</a></li>
<?php
			}

			if( current_user_can('moderate_comments') )
			{
?>
					<li><a href="<?php bloginfo('home'); ?>/wp-admin/edit-comments.php">View Comments</a></li>
<?php
			}

			if( current_user_can('edit_themes') )
			{
?>
					<li><a href="<?php bloginfo('home'); ?>/wp-admin/themes.php">Edit Themes</a></li>
<?php
			}

			if( current_user_can('edit_plugins') )
			{
?>
					<li><a href="<?php bloginfo('home'); ?>/wp-admin/plugins.php">Edit Plugins</a></li>
<?php
			}

			if( current_user_can('edit_users') )
			{
?>
					<li><a href="<?php bloginfo('home'); ?>/wp-admin/users.php">Edit Users</a></li>
<?php
			}

			if( current_user_can('manage_options') )
			{
?>
					<li><a href="<?php bloginfo('home'); ?>/wp-admin/options-general.php">Edit Settings</a></li>
<?php
			}

			if( is_user_logged_in() )
			{
?>
					<li><?php wp_loginout(); ?></li>
<?php
			}
?>
				</ul>
			</li>
<?php
		}
?>
		</ul>
	</div>
<?php
	}

	echo "\n\t", '<div id="headerimage">';
	if( $water['tagline_pos'] )
	{
?>
<div id="tagline"><?php bloginfo('description'); ?></div>
<?php
	}
	echo '</div>';
?>
