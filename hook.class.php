<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_invitation_skip_verification {
	protected $_pvars = array();

	public function __construct(){
		global $_G;
		$this->_pvars = $_G['cache']['plugin']['invitation_skip_verification'];
	}
}

class plugin_invitation_skip_verification_member extends plugin_invitation_skip_verification{
	public function register_input(){
		/* $invitecode = trim( getgpc('invite' , 'g') );
		$invite = C::t('#invitation_skip_verification#intcdz_register_invite')->fetch_all_by_code( $invitecode );
		if( $invite == null || $_G['timestamp'] > $invite['endtime'] || $invite['status'] == 1 ){
			$invitecode = null;
		} */

		if( $_GET['hash'] && $this->_pvars['email_reg_open'] ){
			include template('invitation_skip_verification:register_invite_input');
			return $return;
		}
	}

	function register_message($param){
		global $_G;

		$uid = $param['param'][2]['uid'];
		if( $uid && trim($_POST['invitecode']) != null ){
			$invitecode = trim($_POST['invitecode']);

			$invite = C::t('#invitation_skip_verification#intcdz_register_invite')->fetch_by_code_status( $invitecode , 0 );
			if( $invite == null || $_G['timestamp'] > $invite['endtime'] ){
				return;
			}

			$data_I = array(
				'fuid' => $uid ,
				'fusername' => $param['param'][2]['username'] ,
				'inviteip' => $_G['clientip'] ,
				'regdateline' => $_G['timestamp'] ,
				'status' => 1
			);
			C::t('#invitation_skip_verification#intcdz_register_invite')->update( $invite['id'] , $data_I );

			C::t('common_member')->update( $uid , array('groupid' => $this->_pvars['init_groupid']) );
			C::t('common_member_validate')->delete( $uid );
		}
	}
}

?>
