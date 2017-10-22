<div id="content">
<?php
	global $wp_query, $wpdb, $posts, $water;
	$author = $wp_query->get_queried_object();

	if( !empty($author) )
	{
		$show = array();

		if( !empty($author->first_name) || !empty($author->last_name) )
		{
			$a = array();
			if( !empty($author->first_name) )
			{
				$a[] = $author->first_name;
			}
			if( !empty($author->last_name) )
			{
				$a[] = $author->last_name;
			}
			if( !empty($a) )
			{
				$show['Real Name']  = implode(' ', $a);
			}
		}
		else
		{
			$show['Real Name'] = '<em>Not Applicable</em>';
		}

		$show['E-Mail']               = $water['author_email'] ? '<a href="'. $author->email .'">'. $author->email .'</a>' : '<em>Withheld</em>';
		$show['Website']              = isset($author->user_url[7]) ? '<a href="' . $author->user_url . '">' .$author->user_url . '</a>' : '<em>Not Applicable</em>';
		$show['AIM']                  = empty($author->aim) ? '<em>Not Applicable</em>' : $author->aim;
		$show['Yahoo IM']             = empty($author->yim) ? '<em>Not Applicable</em>' : $author->yim;
		$show['Jabber / Google Talk'] = empty($author->jabber) ? '<em>Not Applicable</em>' : $author->jabber;
		$show['Biographical Info']    = empty($author->description) ? '<em>Not Applicable</em>' : $author->description;

		echo '<div class="post">';
		echo '<p class="right">', get_avatar($author->user_email, 75), '</p>';
		echo '<h2 class="posttitle">', $author->display_name , '\'s Information</h2>';

		echo '<p class="postmeta clear">Registered on ', mysql2date('F j, Y \a\t g:i A', $author->user_registered) , '</p>';

		echo '<div class="the_content" style="clear: none;">';
		foreach( $show as $name => $text )
		{
			echo apply_filters('the_content', implode(array('<strong>',$name,':','</strong>', "\n", $text)));
		}

		if( have_posts() )
		{
			echo "<h5>Posts</h5>\n<ul class=\"sidebar\">\n";
			while( have_posts() )
			{
				the_post();
?>
	<li class="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> <?php the_time_format(true); ?></li>
<?php
			}
		}

		echo "</ul>\n</div>\n</div>";
		the_nav_link();
	}
	else
	{
?>
	<div class="post">
		<h2 class="posttitle">User does not exist</h2>
	</div>
<?php
	}
?>
</div>
<?php
	do_action('template_content_end');
?>