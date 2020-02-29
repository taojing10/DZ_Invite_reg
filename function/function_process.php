<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function make_invite_code( $length = 11 ){
	$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$randtxt = '';
	for ( $i = 0; $i < $length; $i++ ){
		$randtxt .= $chars[ mt_rand(0, strlen($chars) - 1) ];
	}
	return $randtxt;
}

?>
