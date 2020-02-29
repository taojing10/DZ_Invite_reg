<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
$tablePre = $_G['config']['db'][1]['tablepre'];

$sql = <<<EOF
create table if not exists `{$tablePre}intcdz_register_invite`(
	id int(10) unsigned primary key AUTO_INCREMENT,
	uid int(10) unsigned default 0,
    code varchar(20) null,
	fuid int(10) unsigned default 0,
    fusername varchar(30) null,
    inviteip varchar(30) null,
    dateline int(10) unsigned null,
    endtime int(10) unsigned null,
    regdateline int(10) unsigned null,
    status tinyint(1) default 0
) ENGINE = MYISAM CHARACTER SET gbk COLLATE gbk_chinese_ci;
EOF;

runquery($sql);

$finish = TRUE;

?>
