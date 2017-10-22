<?php
function merge_water()
{
	global $water;
	$water = array
	(
		// CSS Code
		'max_width'     => array
		(
			'max'       => '980px',
			'content'   => '760px',
			'sidebar_1' => '180px',
			'sidebar_2' => '0',
			'comment'   => '695px',
		),

		'font_fam'      => '"Trebuchet MS", sans-serif',
		'bdy_bgcolor'   => '#FFF',
		'bdy_color'     => '#333',

		'maincolor'     => array
		(
			'#73A533',
			'#0092C8'
		),

		'gray'          => array
		(
			'#CCC',
			'#AAA',
			'#7E7E7E'
		),

		'h1' => array
		(
			'color' => '#177FA5',
			'size'  => '22px'
		),

		'h2' => array
		(
			'color' => '#67873E',
			'size'  => '22px'				
		),

		'h3' => array
		(
			'color' => '#0AA6DF',
			'size'  => '20px'				
		),

		'h4' => array
		(
			'color' => '#81D417',
			'size'  => '20px'				
		),

		'h5' => array
		(
			'color' => '#7BBFD8',
			'size'  => '18px'				
		),

		'h6' => array
		(
			'color' => '#B9E383',
			'size'  => '18px'				
		),

		'head_img' => array
		(
			'url' =>  'images/header.jpg',
			'w'   =>  '100%',
			'h'   =>  '150px',
			'pos' =>  'center'
		),

		'title_size'       => '30px',
		'custom_css'       => '',

		'comment'          => array
		(
			'even'         => '#FFF',
			'odd'          => '#F3F3F3',
			'author'       => '#EAF3FA',
			'thread'       => '88%,86%,83%'
		),

		'gravatar'         => array
		(
			'size'         => '45',
			'default'      => ''
		),

		// Boolean Code
		'show_com_top'     => 0,
		'show_tags'        => 1,
		'excerpt_index'    => 0,
		'tagline_pos'      => 2,
		'page_comments'    => 0,

		// Settings
		'archive_name'     => 'Archives',
		'cat_name'         => 'Categories',
		'page_name'        => 'Page',
		'options_name'     => '',
		'cat_exclude'      => '',
		'cat_group'        => 'subscriber',
		'pg_exclude'       => '',
		'page_group'       => 'subscriber',
		'blog_description' => '',
		'meta_tags'        => 0,
		'author_email'     => 0
	);

	if( !defined('WATER_PREVIEW') )
	{
		$data = get_option('water_data');
		if( empty($data) )
		{
			$data = array();
		}

		$bools = get_option('water_booleans');
		if( empty($bools) )
		{
			$bools = array();
		}

		$custom_css = get_option('water_custom_css');
		if( !empty($custom_css) )
		{
			$water['custom_css'] = $custom_css;
		}

		foreach( array($data, $bools) as $t => $d )
		{
			foreach($d as $k => $v)
			{
				if( is_array($v) )
				{
					foreach($v as $i => $s)
					{
						$water[$k][$i] = $t ? intval($s) : $s;
					}
				}
				else
				{
					$water[$k] = $t ? intval($v) : $v;
				}
			}
		}
	}
}

$water = array();
?>