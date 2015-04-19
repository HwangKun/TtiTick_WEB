<?php
/**
 * 컨트롤러 유틸리티 함수
 * @author Aaron
 * @date 2014.01.21
 */
 
// Logger 생성
require_once($config['basedir'] . '/libraries/apache-log4php-2.3.0/Logger.php');
Logger::configure($config['basedir'] . '/libraries/apache-log4php-2.3.0/config.xml');
$traceLogger = Logger::getLogger("TraceLogger");


/**
 * 로그인한 사용자인지 검사
 * @param $USERID 세션의 사용자 ID($_SESSION['USERID'])
 */
function isLoggedIn($USERID) {
    if ( $USERID != "" && $USERID >= 0 && is_numeric($USERID) ) {
    	return true;
    } else {
    	return false;
    }
}

/**
 * $_REQUEST에서 $val 필드 값을 가져오며, 없는 경우 $default를 반환한다.
 */
function REQ_VAL($val, $default = "") {
    $var = isset( $_REQUEST[$val] ) ? $_REQUEST[$val] : $default;
    return $var;
}
?>