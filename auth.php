<?php
if(isset($_COOKIE['ac_token']))
{
    $token = $_COOKIE['ac_token'];
}
else if(isset($_COOKIE['token']))
{
    $url = "https://discord.com/api/oauth2/token";
    $ch = curl_init($url);
    $code = $_COOKIE['token'];
    curl_setopt_array($ch, array(
        CURLOPT_HTTPHEADER  => array('Content-Type: application/x-www-form-urlencoded'),
        CURLOPT_POSTFIELDS => http_build_query(array('client_id'=>'812759298354446366','client_secret'=>'wWeequJjbEzOJbK24sDpyFJriC483Yvg','grant_type'=>'refresh_token','refresh_token'=>$code,'redirect_uri'=>'http://localhost/discord_panel/login.php/','scope'=>'identify email guilds')),
        CURLOPT_RETURNTRANSFER  =>true,
        CURLOPT_VERBOSE     => 1
    ));
$content = curl_exec($ch);
curl_close($ch);
$content = json_decode($content,true);
setcookie('ac_token',$content['access_token'],time()+$content['expires_in'],'/');
setcookie('token',$content['refresh_token'],time()+$content['expires_in']*999,'/');
$token = $content['access_token'];
}
else
{
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/');
	exit;
}
$url = "https://discord.com/api/users/@me";
$ch = curl_init($url);
curl_setopt_array($ch, array(
    CURLOPT_HTTPHEADER  => array('Authorization: Bearer '.$token),
    CURLOPT_RETURNTRANSFER  =>true,
    CURLOPT_VERBOSE     => 1
));

$content = curl_exec($ch);
    curl_close($ch);
$user_info = json_decode($content,true);
if($user_info['message']!=null)
{
    die("błąd autoryzacji");
}
?>