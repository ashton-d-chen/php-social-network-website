<?php
if( !defined('TEMPLATEPATH') )
{
	die(':)');
}

function tp()
{
	bloginfo('template_directory');
	echo '/';
}
header('Content-Type: text/css');

$h = fopen(TEMPLATEPATH .'/style.css', 'rb');
echo fread($h, filesize(TEMPLATEPATH .'/style.css'));
fclose($h);

$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

if( false !== strpos($browser, 'Safari') )
{
	$browser = 2;
}
elseif( false !== strpos($browser, 'MSIE') )
{
	$browser = 1;
}
else
{
	$browser = 0;
}

extract($water);
$head_img['url'] = trim($head_img['url'], '\/');
if( !preg_match('/^(http|ftp)/i', $head_img['url']) )
{
	$head_img['url'] = get_bloginfo('template_directory') .'/'. $head_img['url'];
}

$topmenu = implode(array($page_name, $cat_name, $archive_name, $options_name));
?>

body {
	margin: 0;
	background-color: <?php echo $bdy_bgcolor; ?>;
	font-family: <?php echo $font_fam; ?>;
	font-size: 11px;
	color: <?php echo $bdy_color; ?>;
}

#wrapper {
	vertical-align: middle;
	width: <?php echo $max_width['max']; ?>;
	margin: 0 auto;
}

a:link, a:visited {
	text-decoration: none;
	color: <?php echo $maincolor[0]; ?>;
}

a:hover {
	text-decoration: underline;
}

ul li {
	list-style: none;
}

h4 {
	font-size: 18px;
	color: <?php echo $gray[2]; ?>;
	display: block;
	font-weight: normal;
}

#title {
	float: right;
	margin: 7px 5px 0 0;
	font-size: <?php echo $title_size; ?>;
	font-weight: normal;
}

#title a:link, #title a:visited  {
	color: <?php echo $maincolor[0]; ?>;
	margin-right: 5px;
	font-weight: normal;
}

#title a:hover {
	text-decoration: none;
	color: <?php echo $maincolor[1]; ?>;
}

<?php
	if( $tagline_pos )
	{
?>
#tagline {
	color: <?php echo $maincolor[1]; ?>;
	font-size: 17px;
	<?php echo 'float: ', $tagline_pos == 2 || $tagline_pos == 4 ? 'right' : 'left'; ?>;
<?php
	echo "\t";
	switch($tagline_pos)
	{
		case 1:
			echo 'margin-left: 5px';
			break;
		case 2:
			echo 'margin-right: 5px;';
			break;
		case 3:
			echo 'margin: ', intval($head_img['h']) - 22 , 'px 0 0 5px';
			break;
		case 4:
			echo 'margin: ', intval($head_img['h']) - 22 , 'px 5px 0;';
			break;
	}
	echo "\n";
?>
}
<?php
	}

	if( isset($topmenu[1]) )
	{
?>

#topmenu {
	float: left;
	margin-top: 25px;
	z-index: 5;
}

#topmenu a:link, #topmenu a:visited {
	color: <?php echo $bdy_color; ?>;
}

#topmenu a:hover {
	text-decoration: none;
}

#topmenu ul { 
	margin: 0 0 0 5px;
	padding: 0;
}

<?php
	if( 1 === $browser )
	{
?>
#topmenu ul li ul li, #topmenu ul li ul li a:link,
#topmenu ul li ul li a:visited, #topmenu ul li ul li a {
	_height: 1px;
}
<?php
	}
?>

#topmenu ul li a:link, #topmenu ul li a:visited {
	display: block;
	line-height: 11px;
	padding: 5px 10px 2px 9px;
	margin: 0 7px 0 0;
	font-size: 11px;
	border-bottom: 2px solid <?php echo $maincolor[0]; ?>;
	text-transform: uppercase;
}

#topmenu ul li a:hover {
	border-bottom: 2px solid <?php echo $maincolor[1]; ?>;
}

#topmenu ul li {
	display: block;
	float: left;
	position: relative; 
}

#topmenu ul li ul {
	display: block;
	position: absolute;
	top: auto;
	margin: 0;
	padding: 0;
	visibility: hidden;
	border-top: 1px solid <?php echo $gray[0]; ?>;
	width: 220px;
}

#topmenu ul li:hover ul, #topmenu ul li.msiefix ul {
	visibility: visible;
}

#topmenu ul li ul li {
	position: relative;
	float: none;
	line-height: 18px;
	color: <?php echo $bdy_color; ?>;
	font-size: 10px;
}
	
#topmenu ul li ul li a:link, #topmenu ul li ul li a:visited, #topmenu ul li ul li a {
	display: block;
	border: 0;
	margin: 0;
	padding: 2px 0 2px 10px;
	line-height: 15px;
	text-transform: none;
	color: #FFF;
	background-color: <?php echo $maincolor[0]; ?>;
}
		
#topmenu ul li ul li a:hover {
	background-color: <?php echo $maincolor[1]; ?>;
}
<?php
	}
?>

#headerimage {
	clear: both;
	height: <?php echo $head_img['h']; ?>;
	width: <?php echo $head_img['w']; ?>;
	margin-bottom: 10px;
	border-top: 1px solid <?php echo $gray[0]; ?>;
	border-bottom: 1px solid <?php echo $gray[0]; ?>;
	background: url('<?php echo $head_img['url']; ?>') no-repeat <?php echo $head_img['pos']; ?>;
}

#content {
	margin: 0 15px 0 8px;
	padding: 0;
	width: <?php echo $max_width['content']; ?>;
	float: left;
}

.post {
	margin: 5px 0 30px 3px;
	clear: both;
}

.posttitle, .sidebar h3 {
	font-size: 20px;
	line-height: 20px;
	color: <?php echo $maincolor[1]; ?>;
	margin: 0 0 5px 0;
	font-weight: normal;
	display: block;
	clear: left;
}

.posttitle img {
	float: left;
	margin-right: 3px;
}

.post a:link, .post a:visited {
	color: <?php echo $maincolor[1]; ?>;
}

.post a:hover {
	color: <?php echo $maincolor[0]; ?>;
	text-decoration: none;
}

.post a:link span, .post a:visited span {
	color: <?php echo $gray[0]; ?>;
}

.post a:hover span {
	color: <?php echo $gray[1]; ?>;
}

.post .the_content {
	clear: both;
}

.post .postmeta {
	font-size: 10px;
	line-height: 10px;
	color: <?php echo $gray[1]; ?>;
	text-transform: uppercase;
	margin: 2px 0 5px 0;
}

.post .postmeta a:link, .post .postmeta a:visited {
	color: <?php echo $gray[2]; ?>;
	font-weight: bold;
}

.post .postmeta a:hover {
	color: <?php echo $maincolor[0]; ?>;
	text-decoration: none;
}

.post div h1 {
	color: <?php echo $h1['color']; ?>;
	font-size: <?php echo $h1['size']; ?>;
}

.post div h2 {
	color: <?php echo $h2['color']; ?>;
	font-size: <?php echo $h2['size']; ?>;
}

.post div h3 {
	color: <?php echo $h3['color']; ?>;
	font-size: <?php echo $h3['size']; ?>;
}

.post div h4 {
	color: <?php echo $h4['color']; ?>;
	font-size: <?php echo $h4['size']; ?>;
}

.post div h5 {
	color: <?php echo $h5['color']; ?>;
	font-size: <?php echo $h5['size']; ?>;
}

.post div h6 {
	color: <?php echo $h6['color']; ?>;
	font-size: <?php echo $h6['size']; ?>;
}

.post table {
	background: #FFF;
	margin: 5px 0 10px;
	border: 1px solid <?php echo $gray[2]; ?>;
	border-collapse: collapse;
}

.post th {
	background: <?php echo $gray[0]; ?>;
}

.post th, .post td {
	padding: 3px 10px;
	border: 1px solid <?php echo $gray[1]; ?>;
	vertical-align: top;
}

.post fieldset {
	padding: 0 10px 0 10px;
	border-color: <?php echo $h6['color']; ?>;
}

.post legend {
	color: <?php echo $h1['color']; ?>;
	font-size: <?php echo $h1['size']; ?>;
}

.post p {
	margin: 0 0 10px 0;
	line-height: 15px;
}

.sidebar p a:link, .sidebar p a:visited,
.post p a:link, .post p a:visited,
.post ul a:link, .post ul a:visited,
.post ol a:link, .post ol a:visited {
	color: <?php echo $maincolor[0]; ?>;
}

.sidebar p a:hover, .post p a:hover, .post ul a:hover, .post ol a:hover {
	text-decoration: underline;
}

.post .the_content ul, .post .the_content ol {
	margin-bottom: 10px;
}

.the_content img {
	border: 1px solid <?php echo $maincolor[0]; ?>;
	margin: 0 0 3px 3px;
}

.post .wp-smiley {
	float: none;
	border: 0;
	margin: 0;
}

.postlnk {
	clear: left;
	padding-left: 14px;
	background: url('<?php tp(); ?>images/posts.gif') no-repeat center left;
	margin-right: 50px;
}

.comlnk {
	padding-left: 16px;
	background: url('<?php tp(); ?>images/comments.gif') no-repeat center left;
	margin-right: 50px;
}

.pelnk {
	padding-left: 16px;
	background: url('<?php tp(); ?>images/edit.gif') no-repeat center left;
}

.taglnk {
	clear: left;
	padding-left: 14px;
	background: url('<?php tp(); ?>images/tag.gif') no-repeat center left;
}

#nav {
	padding: 0 0 25px 0;
	margin: -10px 10px <?php echo 1 == $browser ? '-25px 0' : '0'; ?>;
}

#commentlist {
	width: <?php echo $max_width['content']; ?>;
}

#commentlist li {
	width: <?php echo $max_width['comment']; ?>;
	margin: 0 0 10px 0;
	padding: 5px 5px 0;
	border-left: 3px solid <?php echo $maincolor[0]; ?>;
	background-color: <?php echo $comment['even']; ?>;
	float: left;
}

#commentlist li.odd {
	background-color: <?php echo $comment['odd']; ?>;
	border-color: <?php echo $maincolor[1]; ?>;
}

<?php
	if( $comment['author'] )
	{
?>
#commentlist li.bypostauthor {
	background-color: <?php echo $comment['author']; ?>;
}
<?php
	}
?>

.post .commenttitle {
	font-size: 16px;
	color: <?php echo $maincolor[1]; ?>;
	margin: 0 0 5px 0;
	font-weight: normal;
	text-align: left;
}

.post .commenttitle span {
	font-size: 11px;
	float: right;
	color: <?php echo $gray[1]; ?>;
}

blockquote {
	border-left: 2px solid <?php echo $maincolor[0]; ?>;
	margin: 10px 0 10px 5px;
	padding-left: 10px;
}

blockquote blockquote {
	border-left: 2px solid <?php echo $maincolor[1]; ?>;
}

#commentlist li.gravatar {
	border: 0;
	width: <?php echo $gravatar['size']; ?>px;
	display: inline;
	margin-right: 7px;
	padding: 0;
	clear: both;
	text-align: center;
	background: inherit;
}

<?php
	if( !empty($comment['thread']) )
	{
?>
#commentlist .child li {
	float: left;
}

#commentlist .child li.gravatar {
	width: <?php echo $gravatar['size']; ?>px;
}
<?php
		$u = explode(',',$comment['thread']);
		foreach($u as $k=>$v)
		{
			echo '#commentlist .child li.depth-',$k+2,'{width:',$v,'}';
		}
	}
?>

.post .extrameta {
	color: <?php echo $gray[2]; ?>;
}
<?php
	if( !empty($max_width['sidebar_1']) )
	{
?>

#sidebar_one {
	width: <?php echo $max_width['sidebar_1']; ?>;
	float: right;
}
<?php
	}

	if( !empty($max_width['sidebar_2']) )
	{
?>

#sidebar_two {
	width: <?php echo $max_width['sidebar_2']; ?>;
	float: right;
<?php
		if( !empty($max_width['sidebar_1']) )
		{
?>
	margin-right: 20px;
<?php
		}
?>
}
<?php
	}
?>

.sidebar a:link, .sidebar a:visited {
	color: <?php echo $bdy_color; ?>;
}

.sidebar a:hover {
	color: <?php echo $maincolor[0]; ?>;
	text-decoration: none;
}

/* LISTS */

html>body .the_content ul {
	margin-left: 0;
	padding: 0 0 0 10px;
	text-indent: -10px;
} 

html>body .the_content li {
	margin: 4px 0 2px 5px;
}

.the_content ol {
	padding: 0 0 0 15px;
	margin: 0;
	text-indent: -5px;
}

.sidebar ul, .sidebar ul ol {
	margin: 0;
	padding: 0;
}

.sidebar ul li {
	margin-bottom: 15px;
}

.sidebar ul p, .sidebar ul select {
	margin: 5px 0 8px;
}

.sidebar ul ul, .sidebar ul ol {
	margin: 5px 0 0 5px;
}

.sidebar ul ul ul, .sidebar ul ol {
	margin: 0 0 0 10px;
}

.sidebar ul ul li, .sidebar ul ol li {
	margin: 3px 0 0;
	padding: 0;
}

.the_content ul li:before, .sidebar ul ul li:before {
	content: "\00BB\00A0";
	color: <?php echo $maincolor[0]; ?>;
}

<?php
	if( !$hide_calendar )
	{
?>

#wp-calendar {
	vertical-align: middle;
	width: 100%;
	text-align: center;
}

#wp-calendar #prev {
	text-align: justify;
}

#wp-calendar #next {
	text-align: right;
}

#wp-calendar a:link, #wp_calendar a:visited, #next a:link, #next a:visited, #prev a:link, #prev a:visited {
	color: <?php echo $maincolor[1]; ?>;
	text-decoration: underline;
}

#wp-calendar a:hover, #next a:hover, #prev a:hover {
	color: <?php echo $maincolor[0]; ?>;
	text-decoration: underline;
}

#today {
	font-weight: bold;
	color: <?php echo $maincolor[0]; ?>;
}
<?php
	}
?>

#footer {
	clear: both;
	border-top: 1px solid <?php echo $gray[0]; ?>;
	margin: 5px 0 -2px 5px;
	text-transform: uppercase;
	font-size: 10px;
	color: <?php echo $gray[0]; ?>;
}

#footer a:link, #footer a:visited {
	color: <?php echo $gray[1]; ?>;
}

#footer a:hover {
	color: <?php echo $maincolor[0]; ?>;
	text-decoration: none;
}

#s {
	width: 98%;
}
<?php
	if( !empty($custom_css) )
	{
		echo "\n", $custom_css;
	}
?>