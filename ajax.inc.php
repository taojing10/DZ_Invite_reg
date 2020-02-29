<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$formhash = trim(getgpc('hash','g'));
if($formhash != FORMHASH){
	exit;
}

include template('common/header_ajax');
if( getgpc('act','g') == 'invite_ck' ){
	$code = trim( getgpc('code','g') );

	if( strlen($code) == 15 ){
		$invite = C::t('#invitation_skip_verification#intcdz_register_invite')->fetch_by_code( $code );
		if( $invite == null ){
			echo '�����벻����';
		}

		if( $invite['status'] == 1 ){
			echo '�������ѱ�ʹ��';
		}

		if( $invite != null && $invite['status'] == 0 && $_G['timestamp'] > $invite['endtime'] ){
			echo '�������ѹ���';
		}

		if( $invite['status'] == 0 && $_G['timestamp'] < $invite['endtime'] ){
			echo '���������ʹ��';
		}
	}
}

include template('common/footer_ajax');
?>
