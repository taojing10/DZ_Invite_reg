<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$pvars = $_G['cache']['plugin']['invitation_skip_verification'];

if( !in_array($_G['groupid'], dunserialize($pvars['allow_groups']) ) ){
	showmessage('ÄãËùÔÚµÄÓÃ»§×éÎÞ·¨ÉêÇëÑûÇëÂë' );
}

$pvars['buy_price'] = intval( $pvars['buy_price'] );
$mem_extcredit = getuserprofile('extcredits'.$pvars['buy_extcredit']);

require_once libfile('function/process' , 'plugin/invitation_skip_verification');

if( $_POST && submitcheck('invitesubmit', 1) ){
	$invitenum = intval( getgpc('invitenum' ,'p') );
	for( $i=0;$i<$invitenum;$i++ ){
		$data_I = array(
			'uid'	=> $_G['uid'] ,
			'code' 	=> substr($_G['timestamp'],-4) . make_invite_code() ,
			'dateline'	=> $_G['timestamp'] ,
			'endtime'	=> $_G['timestamp'] + (86400 * $pvars['expire_time'])
		);

		C::t('#invitation_skip_verification#intcdz_register_invite')->insert( $data_I , true );

		if( $pvars['buy_price'] > 0 ){
			$data_E[ 'extcredits'.$pvars['buy_extcredit'] ] = $pvars['buy_price'] * $invitenum * -1;
			updatemembercount($_G['uid'], $data_E , true, '', $_G['uid'] , '' , 'ÑûÇëÂë¹ºÂò', 'ÑûÇëÂë¹ºÂò' );
		}
	}

	showmessage( 'ÑûÇëÂë»ñÈ¡³É¹¦' , 'home.php?mod=spacecp&ac=plugin&id=invitation_skip_verification:register_invite' );
}

//
$invites = C::t('#invitation_skip_verification#intcdz_register_invite')->fetch_all_by_uid_endtime_status( $_G['uid'] , $_G['timestamp'] );

?>
