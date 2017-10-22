<?php
function user_group()
{
	static $uigroup = '';

	if( empty($uigroup) )
	{
		global $wpdb;
		$uigroup = wp_get_current_user();
		$uigroup = $uigroup->roles[0];
		if( empty($uigroup) )
			$uigroup = 'guest';
	}

	return $uigroup;
}

function isingroup($group)
{
	$user_groups = array
	(
		'guest'         => 0,
		'subscriber'    => 1,
		'contributor'   => 2,
		'author'        => 3,
		'editor'        => 4,
		'administrator' => 5,
		'none'          => 6
	);

	return $user_groups[$group] >= $user_groups[user_group()];
}

/**
* Splits an array into columns
* if $array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
* separate_array_by_col($array, 5); will return
* array( 0 => array(1,2,3,4,5), 1 => array(6,7,8,9, 10) )
* The array now has 2 keys, but 5 elements within it.
*/
function separate_array_by_col($array, $separate = 3)
{
	$size = sizeof($array);
	$turn = ceil($size/$separate);

	$partition = array();
	$start = 0;

	for( $i = 0; $i < $turn; ++$i )
	{
		$partition[$start] = array();
		for( $f = 0; $f < $separate; ++$f )
		{
			if( !empty($array) )
			{
				list($k, $v) = each($array);
				$partition[$start] = array_merge($partition[$start], array($k => $v));
				array_shift($array);
			}
		}
		++$start;
	}

	return $partition;
}

/* Splits an array into rows
* if $array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
* separate_array_by_row($array, 5); will return
* array( 0 => array(1, 2), 1 => array(3, 4), 2 => array(5, 6), 3 => array(7, 8), 4 => array(9, 10) )
* The aray now has 5 keys.
*/
function separate_array_by_row($array, $separate = 3)
{
	$size = sizeof($array);
	$partition = array();
	$turn = ceil($size/$separate);
	$start = 0;

	for( $i = 0; $i < $separate; ++$i )
	{
		$partition[$start] = array();
		for( $f = 0; $f < $turn; ++$f )
		{
			if( !empty($array) )
			{
				list($k, $v) = each($array);
				$partition[$start] = array_merge($partition[$start], array($k => $v));
				array_shift($array);
			}
		}
		++$start;
	}

	return $partition;
}

function htmlentities_deep($r)
{
	return is_array($r) ? array_map('htmlentities_deep', $r) : htmlentities($r);
}
?>