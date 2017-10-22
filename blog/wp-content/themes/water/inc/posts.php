<?php
function the_posts($t='',$c='')
{
	global $water;

	/* Variables to check if you're viewing a page, a single post, or both */
	$sing  = is_single();
	$page  = is_page();
	$singu = is_singular();

	// Add in filters/actions
	add_filter('edit_post_link', create_function('$a', 'return str_replace("post-edit-link", "pelnk", $a);'));
	add_filter('edit_comment_link', create_function('$a', 'return str_replace(" class=\"comment-edit-link\"", "", $a);'));
	add_filter('next_posts_link_attributes', create_function('', 'return "class=\"left\"";'));
	add_filter('previous_posts_link_attributes', create_function('', 'return "class=\"right\"";'));
	add_filter('next_comments_link_attributes', create_function('', 'return "class=\"right\"";'));
	add_filter('previous_comments_link_attributes', create_function('', 'return "class=\"left\"";'));

	if( have_posts() )
	{
		$e = implode(array('while( have_posts() )
	{
		the_post();
		', $sing? 'the_next_prev_posts();' : '' ,'
?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h2 class="posttitle">',
		$singu ? '<?php the_title(); ?>' : '<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>',
		$water['show_com_top'] ? ' <?php comment_parenthesis(\'No Comments\', \'1 Comment\', \'% Comments\', \'Comments Hidden\', false); ?>' : '',
		'</h2>
		<p class="postmeta clear">Filed under <?php the_category(\', \'); ?> by <?php the_author_posts_link(); ?></p>
		<div class="the_content">
<?php
			wp_link_pages(array(\'before\' => \'<p><strong>Pages:</strong> \', \'after\' => \'</p>\', \'next_or_number\' => \'number\'));
		',
			( $singu ? 'the_content();' :
				( $water['excerpt_index'] ?
					'the_excerpt(); ?><a href="<?php the_permalink(); ?>" title="<?php the_title(\'Continue Reading &quot;\', \'&quot;\', false); ?>">Continue Reading <?php the_title(\'&quot;\', \'&quot;\'); ?></a><?php' :
					'the_content();'
				)
			),
		'
?>
		</div>
		', ( $water['show_tags'] ? '<?php the_tags(\'<a href="#" class="taglnk"><span></span></a>\', \', \', "<br />\n"); ?>' : '' ) ,
		"\n",
		( $page ? 
			(
				(
					$water['page_comments'] ? 
					(
						$water['show_com_top'] ? '' :
							' <?php comment_parenthesis(\'Comments (0)\', \'Comment (1)\', \'Comments (%)\' , \'Comments Hidden\'); ?>'
					) :
					''
				)
			): 
			( $sing ?
				'<a href="<?php the_permalink(); ?>" class="postlnk"><?php the_time_format(true); ?></a>' : 
				'<a href="<?php the_permalink(); ?>" class="postlnk"><?php the_time_format(true); ?></a>'. ($water['show_com_top'] ? '' : ' <?php comment_parenthesis(\'Comments (0)\', \'Comment (1)\', \'Comments (%)\' , \'Comments Hidden\'); ?>')
			)
		),
		'<?php edit_post_link(\'Edit\'); ?>
	</div>
<?php
	}
	', ( $sing || ($page && $water['page_comments']) ? 'comments_template();' : ( !$singu ? 'the_nav_link();' : '') )));
	}
	else
	{
		if( !empty($c) )
		{
			$c = "\n\t<div class=\"the_content\">\n\t\t\t<p>{$c}</p>\n\t\t</div>";
		}

		$e = "\n?>\n\t<div class=\"post\">\n\t\t<h2 class=\"posttitle\">{$t}</h2>{$c}\n\t</div>\n<?php\n";
	}


	echo "\n", '<div id="content">';
	eval($e);
	echo '</div>';
	unset($e);

	// Add in sidebars and footer
	do_action('template_content_end');
}

function the_time_format($is_post = true)
{
	static $today = 0, $formats = array();
	if( !$today )
	{
		$today   = strtotime('Today', current_time('timestamp',true));
		$formats = array('date' => get_option('date_format'), 'time' => get_option('time_format'));
	}

	$the_time = true === $is_post ? get_the_time('U') : get_comment_time('U');
	$when     = floor(($today - strtotime('Today', $the_time)) / 86400);

	if( !$when )
	{
		echo 'Today at ', date($formats['time'], $the_time);
	}
	elseif( $when == 1 )
	{
		echo 'Yesterday at ', date($formats['time'], $the_time);
	}
	elseif( $when > 1 )
	{
		echo date(implode(' \a\t ', $formats), $the_time);
	}
	else
	{
		echo absint($when) ,' day', 1 == absint($when) ? '' : 's' ,' later at ', date($extra, $the_time);
	}
}

function edit_post_button()
{
	global $post;

	if( current_user_can("edit_{$post->post_type}") )
	{
?>
<input type="button" class="edit right" value="Edit" onclick="window.location='<?php echo get_edit_post_link(); ?>'" />
<?php
	}
}

function edit_comment_button()
{
	global $comment, $post;

	// One basic statement
	if( current_user_can( "edit_{$post->post_type}", $post->ID ) )
	{
?>
<input type="button" class="edit" value="Edit" onclick="window.location='<?php echo get_edit_comment_link( $comment->comment_ID ); ?>'" />
<?php
	}
}

function comment_parenthesis($zero, $one, $more, $disabled, $attr = true)
{
	$class  = ' class="comlnk"';
	$n      = '#comments';
	$add    = array('','');
	if( !$attr )
	{
		$class = '';
		$add   = array('<span>','</span>');
	}

	$text = '';
	if( post_password_required() )
	{
		$text = $disabled;
		$n    = '';
	}
	elseif( !($c = get_comments_number()) )
	{
		$text = $zero;
		$n    = '#respond';
	}
	elseif( $c == 1 )
	{
		$text = $one;
	}
	else
	{
		$text = str_replace('%', $c, $more);
	}
?>
<a href="<?php the_permalink(); echo $n; ?>"<?php echo $class; ?>><?php echo $add[0], $text, $add[1]; ?></a>
<?php
}

function get_the_next_post()
{
	$post = get_next_post(false, '');
	if( !$post )
	{
		return null;
	}

	return implode(array('<a href="', get_permalink($post->ID) ,'" class="right">', apply_filters( 'the_title', $post->post_title ) .' &raquo;</a>'));
}

function get_the_previous_post()
{
	$post = get_previous_post(false, '');
	if( !$post	)
	{
		return null;
	}
	return implode(array('<a href="', get_permalink($post->ID), '" class="left">&laquo; ', apply_filters( 'the_title', $post->post_title ), '</a>'));
}

function the_next_prev_posts()
{
	$links = array(get_the_next_post(), get_the_previous_post());
	$links = array_filter($links);
	if( !empty($links) )
	{
		echo '<p style="margin-bottom:20px">',implode($links) ,'</p>';
	}
}

function the_nav_link()
{
	$links = array(get_next_posts_link('&laquo; Older Posts'), get_previous_posts_link('Newer Posts &raquo;'));
	$links = array_filter($links);
	if( !empty($links) )
	{
		echo '<p>', implode($links) ,'</p>';
	}
}

function the_next_prev_comments()
{
	$links = array(get_previous_comments_link(), get_next_comments_link());
	$links = array_filter($links);
	if( !empty($links) )
	{
		echo '<p style="clear:both;">', implode($links), '</p>';
	}
}

function the_avatar( $id_or_email, $size = '96', $default = '', $alt = false, $extra = '' )
{
	static $rating = null;
	if( is_null($rating) )
	{
		$rating = get_option('avatar_rating');
	}

	$safe_alt = false === $alt ? '' : attribute_escape($alt);

	$size = strval($size);
	if( !is_numeric($size) )
	{
		$size = '96';
	}

	$email = '';
	if( is_numeric($id_or_email) )
	{
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
		{
			$email = $user->user_email;
		}
	}
	elseif( is_object($id_or_email) )
	{
		if( isset($id_or_email->comment_type) && '' != $id_or_email->comment_type && 'comment' != $id_or_email->comment_type )
		{
			return false; // No avatar for pingbacks or trackbacks
		}

		if( !empty($id_or_email->user_id) )
		{
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user )
			{
				$email = $user->user_email;
			}
		}
		elseif( !empty($id_or_email->comment_author_email) )
		{
			$email = $id_or_email->comment_author_email;
		}
	}
	else
	{
		$email = $id_or_email;
	}

	if( empty($default) )
	{
		$avatar_default = get_option('avatar_default');
		if( empty($avatar_default) )
		{
			$default = 'mystery';
		}
		else
		{
			$default = $avatar_default;
		}
	}

	if( 'mystery' == $default )
	{
		// ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
		$default = "http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}";
	}
	elseif( 'blank' == $default )
	{
		$default = includes_url('images/blank.gif');
	}
	elseif( empty($email) )
	{
		$default = "http://www.gravatar.com/avatar/?d=$default&amp;s={$size}";
	}
	elseif( strpos($default, 'http://') === 0 )
	{
		$default = add_query_arg('s', $size, $default );
	}

	if( !empty($email) )
	{
		$out = implode( array('http://www.gravatar.com/avatar/',
						md5( strtolower( $email ) ),
						'?s='.$size,
						'&amp;d=' . urlencode( $default ),
						!empty($rating) ? "&amp;r={$rating}" : ''
				));

		$avatar = "<img alt='{$safe_alt}' src='{$out}' class='avatar photo' />";
	}
	else
	{
		$avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar photo avatar-default' />";
	}

	echo '<li class="gravatar">'.apply_filters('get_avatar', $avatar, $id_or_email, $size, $default, $alt).'</li>';
}

// How comments are done
class Walker_Water_Comment extends Walker
{
	var $tree_type = 'comment';
	var $db_fields = array ('parent' => 'comment_parent', 'id' => 'comment_ID');
	function start_lvl(&$output, $depth, $args)
	{
		$GLOBALS['comment_depth'] = $depth + 1;
		echo "<ul class='child'>\n";
	}

	function end_lvl(&$output, $depth, $args)
	{
		$GLOBALS['comment_depth'] = $depth + 1;
		echo "</ul>\n";
	}

	function start_el(&$output, $comment, $depth, $args)
	{
		$depth++;
		$water = $GLOBALS['water'];
		$GLOBALS['comment_depth'] = $depth;

		if ( !empty($args['callback']) ) {
			call_user_func($args['callback'], $comment, $args, $depth);
			return;
		}

		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}

		if( false === strpos($alt, 'track') )
		{
			the_avatar($comment, $water['gravatar']['size'], $water['gravatar']['default']);
		}
?>
<<?php echo $tag ?> <?php comment_class('') ?> id="comment-<?php comment_ID() ?>">
	<p class="commenttitle commentmeta"><span><?php the_time_format(false); ?></span><?php comment_author(); ?></p>
	<div class="commenttext">
<?php
		if( $comment->comment_approved == '0' )
		{
			echo '<p><em>Your comment is awaiting moderation.</em></p>';
		}
		else
		{
?>
		<p class="postmeta">
<?php
			$args['after'] = ' | ';
			comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])));
			echo implode(array('<a href="', get_comment_link() ,'">link</a>'));
			edit_comment_link('edit', ' | ');
			if( isset($comment->comment_author_url[13]) )
			{
				echo implode(array(' | ', '<a href="', get_comment_author_url() ,'">my site</a>'));
			}
			if ( $comment->user_id > 0 && $user = get_userdata($comment->user_id) )
			{
				// For all registered users, 'byuser'
				$useris = 'registered';
				// For comment authors who are the author of the post
				if ( $post = get_post($post_id) ) {
					if ( $comment->user_id === $post->post_author )
						$useris = 'author';
				}
			}
			if( isset($useris) )
			{
				echo ' | ', $useris;
			}
?>
		</p>
<?php 
			comment_text();
		}
?>
	</div>
<?php
	}

	function end_el(&$output, $comment, $depth, $args)
	{
		if ( !empty($args['end-callback']) ) {
			call_user_func($args['end-callback'], $comment, $args, $depth);
			return;
		}

		echo "</li>\n";
	}
}
?>