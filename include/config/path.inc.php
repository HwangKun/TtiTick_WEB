<?php
/**
 * path 설정 정보 
 * @author Kun
 * @date 2015.04.19
 */

$http = 'http://';
$https = 'http://';
// End Configuration

$config['protocol'] = $http;

$config['baseurl'] = ""; // default root

$config['domain'] = 'localhost';

$config['relurl'] = "http://ttitick.com";
$config['sslurl'] = $https . $config['domain'];
$config['loginurl'] = $config['sslurl'] . '/login';

$config['imageurl'] = $config['relurl'] . '/images';

$config['fileurl'] = $config['baseurl'].'/files';

$config['adminurl'] = $config['sslurl'] . '/manager';

$config['whoau'] = $config['imageurl'] . '/whoau.gif';


//faceBook config - kun facebook app.
$config['app_id']  = "";
$config['app_secret']  = "";

?>
