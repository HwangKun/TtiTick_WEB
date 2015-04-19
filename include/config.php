<?php
/**
 * config.php 메인 설정파일
 * @author Steve
 * @reauthor kun
 * @date 2013.08.27
 * @redate 2015.04.19
 */

/* 공통 config 파일 include */
include('mobile.php');
include('config/path.inc.php');
include('config/db.inc.php');
include('config/config_fn.inc.php');
include('functions/maybe_manager.php');
include("lang/korean.php");

//@ini_set('display_errors', 'on');
//define('_PS_DEBUG_SQL_', true);
-error_reporting(E_ALL & ~E_NOTIC);
-ini_set("display_errors", 1);

session_start();
date_default_timezone_set('Asia/Seoul');

/**
 * 써드 파티 라이브러리 로드하기 시작
 */
require_once($config['basedir'] . '/smarty/libs/Smarty.class.php');
require_once($config['basedir'] . '/libraries/mysmarty.class.php');
require_once($config['basedir'] . '/libraries/SConfig.php');
require_once($config['basedir'] . '/libraries/SError.php');
require_once($config['basedir'] . '/libraries/phpmailer/class.phpmailer.php');
require_once($config['basedir'] . '/libraries/SEmail.php');
require_once($config['basedir'] . '/libraries/apache-log4php-2.3.0/Logger.php');
/* 써드 파티 라이브러리 로드하기 종료 */

//메니저에서 설정한 셋팅 정보 가져오기 시작
// TODO: cache로 옮길 것.
$sql = "select * from config";
$rsc = $conn->Execute($sql);

if ($rsc) {
    while (!$rsc->EOF) {
        $field = $rsc->fields['setting'];
        $config[$field] = $rsc->fields['value'];
        STemplate::assign($field, strip_mq_gpc($config[$field]));
        @$rsc->MoveNext();
    }
}
//메니저에서 설정한 셋팅 정보 가져오기 끝

//아예 공격정인 사용자 접속 차단 시작
if ($sban != "1") {
    $bquery = "SELECT count(*) as total from bans_ips WHERE '" . mysql_real_escape_string($_SERVER['REMOTE_ADDR']) . "' LIKE CONCAT('%', ip, '%') ";
    $bresult = $conn->execute($bquery);
    $bcount = $bresult->fields['total'];
    if ($bcount > "0") {
        $brdr = "https://www.google.com/";
        header("Location:$brdr");
        exit;
    }
}
//아예 공격정인 사용자 접속 차단 끝

// 페이지 이동시 로그인 시간 갱신 시작
// NO_TRACE가 있는 경우엔느 로그인 시간을 갱신하지 않는다.
if ( $_SESSION['NO_TRACE'] && $_SESSION['NO_TRACE'] == 1 ) {

} else {
    //아이디 저장, 로그인 저장 쿠키 체크 시작
    if (isset($_COOKIE['slrememberme'])) {
        list($username, $key, $logSign) = unserialize(gzuncompress(stripslashes($_COOKIE['slrememberme'])));

    	STemplate::assign('cookingId', $username);
    	STemplate::assign('logSign', $logSign);

    	$config['logSign'] = $logSign;
    	$config['thisIds'] = $username;
    }
    //아이디 저장, 로그인 저장 쿠키 체크 끝

    //크몽 자동로그인 처리 시작
    if (strlen($logSign) > 0 && strlen($key) > 0) {
    		$sql = "SELECT USERID,email,username,verified,penalty, funds, grade, lastlogin from members WHERE username='" . mysql_real_escape_string($username) . "' and remember_me_key='" . mysql_real_escape_string($key) . "'";
    		$rs = $conn->execute($sql);

    		if ($rs->recordcount() < 1) {
    			//$error = "Error: Could not locate your account.";
    		} elseif ($rs->fields['grade'] == "0"){
    			$error = "Error: Your account has been disabled by the administrator.";
    		}
    		if ($error == "") {
    			$UID = $rs->fields['USERID'];

    				$query = "update members set lastlogin='" . time() . "', lip='" . $_SERVER['REMOTE_ADDR'] . "' WHERE USERID='" . mysql_real_escape_string($UID) . "'";
    				$conn->execute($query);

    			$_SESSION['USERID'] = $UID;
    			$_SESSION['EMAIL'] = $rs->fields['email'];
    			$_SESSION['USERNAME'] = $rs->fields['username'];
    			$_SESSION['VERIFIED'] = $rs->fields['verified'];
    			$_SESSION['PENALTY'] = $rs->fields['penalty'];
    			$_SESSION['FUNDS'] = $result->fields['funds'];
    			$_SESSION['GRADE'] = $result->fields['grade'];
    			$_SESSION['LASTLOGIN'] = $result->fields['lastlogin'];
    			//create_slrememberme();
    		}
    }

    //크몽 자동로그인 처리 끝

	$query = "update members set lastlogin='" . time() . "' WHERE USERID='" . mysql_real_escape_string($_SESSION['USERID'])  . "'";
	$conn->execute($query);
}

for ($i = 0; $i < count($lang); $i++) {
    STemplate::assign('lang' . $i, $lang[$i]);
}


STemplate::assign('baseurl', $config['baseurl']);
STemplate::assign('basedir', $config['basedir']);
STemplate::assign('mainurl', $config['mainurl']);
STemplate::assign('sslurl', $config['sslurl']);
STemplate::assign('relurl', $config['relurl']);

STemplate::assign('imagedir', $config['imagedir']);
STemplate::assign('imageurl', $config['imageurl']);
STemplate::assign('pdir', $config['pdir']);
STemplate::assign('purl', $config['purl']);
STemplate::assign('membersprofilepicdir', $config['membersprofilepicdir']);
STemplate::assign('membersprofilepicurl', $config['membersprofilepicurl']);
STemplate::assign('mcheck', $config['mcheck']);
STemplate::assign('whoau', $config['whoau']);
STemplate::assign('baseimg', $config['baseimg']);
STemplate::assign('adminurl', $config['adminurl']);
STemplate::assign('cssurl', $config['cssurl']);

STemplate::assign('mobilebaseurl', $config['mobilebaseurl']);
STemplate::assign('mobilesslurl', $config['mobilesslurl']);
STemplate::assign('mobilerelurl', $config['mobilerelurl']);
STemplate::assign('mobileimgurl', $config['mobileimgurl']);

STemplate::setCompileDir($config['basedir'] . "/temporary");
STemplate::setTplDir($config['basedir'] . "/themes");


// 재능 카테고리 불러오기 시작
// $cat1Arr			- 상위 카테고리
// $cat2AllArr		- 하위 카테고리
// $wantTotal2		- 도와 주세요 전체 건수
// $wantCat1Arr		- 도와주세요 상위 카테고리
// $wantCat2AllArr	- 도와주세요 하위 카테고리
// TODO : 도와주세요 카테고리는 메뉴에서 안쓰므로, 기본 카테고리 사용하도록 수정할 것
require_once ('dao/gig_list.class.php');
$userid = $_SESSION['USERID'];
$gigCls = new gig_list_class($userid, $_REQUEST, "", false);
$cat1Arr = $gigCls->mainCatList();

$cat2All = array();
for($i=0 ; $i < count($cat1Arr); $i++) {
    $cat2All[$i] = $gigCls->subCatAllListHeader($cat1Arr[$i]['id']);

}

$cat2AllArr = $gigCls->subCatAllList();

STemplate::assign('cat1Arr', $cat1Arr);//메인 카테고리
STemplate::assign('cat2All', $cat2All);//서브카테고리
STemplate::assign('cat2AllArr', $cat2AllArr);//서브카테고리
// 재능 카테고리 불러오기 끝

// 상단 마이페이지 드롭다운 시작
if($_SESSION['USERID']>0){

	if(strpos($_SERVER["REQUEST_URI"],'/manager')===false){
		require_once('dao/profile.class.php');
		require_once('dao/my_page.class.php');

		$profleCls = new profile_class($_SESSION['USERID'], $_REQUEST, $_FILES, "", false);
		$profileInfo = $profleCls->getMemberInfoForWhole();
		$_SESSION['VERIFIED'] = $profileInfo['verified'];

		STemplate::assign('profileInfo', $profileInfo);

		$mypageCls = new my_page_class($_SESSION['USERID'] ,$_REQUEST, false);
		$orderCnt = $mypageCls->getOrderCnt("buy");
		$sellCnt = $mypageCls->getSellCnt("sell");
		$myFund = $mypageCls->getMyFund();
		$msgCnt = $mypageCls->getMsgCnt("0");
		$bookmarkCnt = $mypageCls->getBookmarkCnt();
		$mygigCnt = $mypageCls->getMyGigCnt();
		$mygigCntAll = $mypageCls->getMyGigCntAll();
		$alertCnt = $mypageCls->getMembersAlertCnt();
		$alertList = $mypageCls->getMembersAlertList();

		STemplate::assign('myFund', $myFund);
		STemplate::assign('orderCnt', $orderCnt);
		STemplate::assign('sellCnt', $sellCnt);
		STemplate::assign('msgCnt', $msgCnt);
		STemplate::assign('bookmarkCnt', $bookmarkCnt);
		STemplate::assign('mygigCnt', $mygigCnt);
		STemplate::assign('mygigCntAll', $mygigCntAll);
		STemplate::assign('alerts', $alertList);
		STemplate::assign('alertCnt', $alertCnt);

		// 전화번호 공개에 따른 판매자 동의 여부 확인 쿼리
		if ($mygigCnt > 0){
		    $query = "select count(*) as cnt from agree_open_mobile where USERID = ?";
		    $cnt = $conn->execute($query,array($_SESSION['USERID']))->fields['cnt'];

		    if($cnt < 1){
		        STemplate::assign('need_agree_open_mobile', '1');
		    }


            //판매자 인증 쿼리
            $query = "select seller_auth, seller_type from members where userid = ? and seller_type is not null;";
            $seller_type = $conn->execute($query,array($_SESSION['USERID']))->fields['seller_type'];


            STemplate::assign('seller_auth', 0);
            if($seller_type){
                STemplate::assign('seller_auth', 1);
            }
		}

		// 해당 사용자의 카테고리 양식 수정하지 않는 재능 가져오기
		$query = "select count(*) as cnt from posts where USERID = ? and active = 1";
		$gigs_cnt =	$conn->execute($query,array($_SESSION['USERID']))->fields['cnt'];
		if ($gigs_cnt > 0 ){
			$query = "select count(*) as cnt from (
                      select distinct PID from posts_cat1
                      union
                      select distinct PID from posts_cat2
                      ) t
                      where t.PID in (select PID from posts where USERID = ? and active = '1')";
            $cnt = $conn->execute($query,array($_SESSION['USERID']))->fields['cnt'];

            if($cnt != $gigs_cnt){
            	 STemplate::assign('need_edit_my_gigs', '1');
		  	}else {
			  	 STemplate::assign('need_edit_my_gigs', '0');
		  	}
		}else {
			STemplate::assign('need_edit_my_gigs', '0');
		}

	}
}
// 상단 마이페이지 드롭다운 끝



//사용자 행위 추적 정보 저장
//$config['mongodbUrl'] = "mongodb://54.249.121.200:27017";
//require_once($config['basedir'] .'/include/dao/user_trace_record.class.php');
//$traceCls = new user_trace_record_class($_SESSION['USERID'], $_REQUEST, false);
//$traceCls->insertTrace();

if ( $_SESSION['LASTLOGIN'] < 1405653581 ) {
	// session_destroy();
	// destroy_slrememberme($_SESSION['USERNAME']);
    if(isset($_COOKIE['slrememberme'])) {
      unset($_COOKIE['slrememberme']);
      setcookie('slrememberme', '', time() - 3600); // empty value and old timestamp
    }
}