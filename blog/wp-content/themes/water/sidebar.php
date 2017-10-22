<?php
	global $water;
	if( !empty($water['max_width']['sidebar_1']) )
	{
?>
<div id="sidebar_one" class="sidebar">
	<ul>
<?php
			if( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) )
			{
?>
		<li>
			<h3>Search</h3>
			<form method="get" id="searchform" action="<?php bloginfo('home'); ?>">
				<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
			</form>
		</li>

		<li>
<?php
					get_calendar();
?>
		</li>

		<li>
			<h3>Recent Entries</h3>
			<ul>
				<?php wp_get_archives('type=postbypost&limit=10'); ?>
			</ul>
		</li>

		<li>
			<h3><?php echo $water['cat_name']; ?></h3>
			<ul>
<?php
					wp_list_categories('title_li=');
?>
			</ul>
		</li>
<?php
				wp_list_bookmarks('title_before=<h3>&title_after=</h3>');
?>

		<li>
			<h3>Popular Tags</h3>
			<?php wp_tag_cloud(''); ?>
		</li>

		<li>
			<h3>Meta</h3>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="<?php bloginfo('rss2_url'); ?>" title="Syndicate this site using RSS">Entries <abbr title="Really Simple Syndication">RSS</abbr></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="The latest comments to all posts in RSS">Comments <abbr title="Really Simple Syndication">RSS</abbr></a></li>
				<?php wp_meta(); ?>
			</ul>
		</li>

<?php
			} /* End of non-widget data */
?>

	</ul>
</div>
<?php
	}

	if( !empty($water['max_width']['sidebar_2']) )
	{
?>

<div id="sidebar_two" class="sidebar">
	<ul>
<?php
			if( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) )
			{
			} /* End of non-widget data */
?>

	</ul>
</div>
<?php
	}
?>