<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if( getgpc('invdel' , 'g') ){

	if( getgpc('formhash','g') == FORMHASH ){
		$inv_id = intval( getgpc('invdel' , 'g') );
		C::t('#invitation_skip_verification#intcdz_register_invite')->delete( $inv_id );
	}
	exit;
}

$page = getgpc('page' , 'G') ? getgpc('page' , 'G') : 1;
$limit = 20;
$start = ($page - 1) * $limit;

//
if( getgpc('uid' , 'p') || getgpc('uid' , 'G') ){
	$uid = getgpc('uid' , 'p') ? getgpc('uid' , 'p') : getgpc('uid' , 'g');

	$invites = C::t('#invitation_skip_verification#intcdz_register_invite')->fetch_all_by_uid( $uid , $start , $limit );
	$counts	= C::t('#invitation_skip_verification#intcdz_register_invite')->count_by_uid( $uid );

}else{
	$invites = C::t('#invitation_skip_verification#intcdz_register_invite')->range( $start , $limit , 'desc' );
	$counts	= C::t('#invitation_skip_verification#intcdz_register_invite')->count( $username );
}

//
foreach( $invites as $invite ){
	$uids[] = $invite['uid'];
}
$usernames = C::t('common_member')->fetch_all_username_by_uid( $uids );

$mpurl = 'admin.php?action=plugins&operation=config&identifier=invitation_skip_verification&pmod=admin_invite_list';
$mpurl .= '&uid=' . $uid;

$multi = multi($counts, $limit, $page, $mpurl);
include template('invitation_skip_verification:admin_invite_list');
?>
