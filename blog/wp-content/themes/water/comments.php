<?php
	if( !defined('ABSPATH') )
	{
		die ('Please do not load this page directly. Thanks!');
	}

	if( post_password_required() )
	{
		return;
	}

	global $water;
	if( have_comments() )
	{
?>
<div class="post" id="comments">
	<div class="posttitle"><span id="comment_count"><?php comments_number('No comments', '1 comment', '% comments' ); ?></span> <a href="<?php the_permalink(); ?>#respond" title="Respond to <?php the_title(); ?>">&raquo;</a></div>
	<ul id="commentlist">
<?php
	wp_list_comments(array('walker' => new Walker_Water_Comment, 'type' => 'comment'));
	the_next_prev_comments();
?>
	</ul>
<?php
	$pings = separate_comments($comments);
	$pings = $pings['pings'];
	if( !empty($pings) )
	{
?>
	<div class="posttitle"><br />Trackbacks/Pingbacks</div>
	<div class="sidebar">
		<ul>
			<li>
				<ul>
<?php
		foreach($pings as $comment)
		{
?>
					<li><a href="<?php trackback_url(); ?>"><?php comment_author(); ?></a><?php edit_comment_link(__('(Edit)'),'&nbsp;&nbsp;',''); ?></li>
<?php	
		}
?>
				</ul>
			</li>
		</ul>
	</div>
<?php
	}
?>
</div>
<?php
	}
?>

<div class="post" id="respond">
<?php
	if( comments_open() )
	{
?>
	<div class="posttitle"><?php comment_form_title('Leave a Reply', 'Leave a Reply to %s');
		if( pings_open() )
		{
?>
 or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a>
<?php
		}
?></div>
	<div class="cancel-comment-reply">
		<small><?php cancel_comment_reply_link(); ?></small>
	</div>
	<div class="the_content">

<?php
		if ( get_option('comment_registration') && !is_user_logged_in() )
		{
?>
			<p>You must be <a href="<?php bloginfo('home'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php
		}
		else
		{
?>
		<form action="<?php bloginfo('home'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php
			if ( is_user_logged_in() )
			{
?>
			<p>Logged in as <a href="<?php bloginfo('home'); ?>/wp-admin/profile.php"><?php echo $user_identity ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
<?php
			}
			else
			{
?>
			<p>
				<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" />
				<label for="author"><small>Name <?php echo $req ? "(required)" : ''; ?></small></label>
			</p>

			<p>
				<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" />
				<label for="email"><small>Mail (will not be published) <?php echo $req ? "(required)" : ''; ?></small></label>
			</p>

			<p>
				<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
				<label for="url"><small>Website</small></label>
			</p>
<?php
			}
?>
			<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
			<p>
				<textarea name="comment" rows="10" cols="0" tabindex="4" style="width: 99.8%;"></textarea>
			</p>
			<p>
				<input name="submit" type="submit" class="edit" id="submit" tabindex="5" value="Submit Comment" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id ?>" />
				<?php comment_id_fields(); ?>
			</p>
			<?php do_action('comment_form', $id); ?>
		</form>
	</div>
<?php
		}
	}
	else
	{
?>
<div class="posttitle">Commenting is closed<?php
		if( pings_open() )
		{
?>
 but you may <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a>
<?php
		}
?></div>
<?php
	}
?>
</div>