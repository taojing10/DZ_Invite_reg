<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_intcdz_register_invite extends discuz_table
{
	public function __construct() {
		$this->_table = 'intcdz_register_invite';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function fetch_by_code( $code ){
		return DB::fetch_first('select * from %t where code=%s' , array($this->_table,$code ));
	}

	public function fetch_by_code_status( $code , $status ){
		return DB::fetch_first('select * from %t where code=%s and status=%d' , array($this->_table,$code ,$status));
	}

	public function fetch_all_by_uid( $uid , $start= 0 , $limit= 0 , $desc = 'desc' ){
		$sql = 'select * from %t where uid=%d order by %i %i';
		$arg = array(
				$this->_table ,
				$uid ,
				DB::order( $this->_pk , 'desc' ) ,
				DB::limit( $start , $limit )
		);

		return DB::fetch_all($sql , $arg);
	}

	public function fetch_all_by_uid_endtime_status($uid ,$endtime,$status ,$start , $limit , $desc = 'desc' ){
		$endtime = $endtime ? $endtime : 0;
		$sql = 'select * from %t where uid=%d and endtime>%i and status=%d order by %i %i';
		$arg = array(
				$this->_table ,
				$uid ,
				$endtime,
				$status,
				DB::order( $this->_pk , $desc ) ,
				DB::limit( $start , $limit )
		);

		return DB::fetch_all($sql , $arg);
	}

	public function count_by_uid( $uid ){
		$sql = 'select count(*) from %t where uid=%d';
		$arg = array(
				$this->_table ,
				$uid ,
		);

		return DB::result_first($sql , $arg);
	}
}


?>
