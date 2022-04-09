<?php
error_reporting(1);
$code=$_GET['code'];
$method = 'POST'; // Create a DELETE request
$url = "https://discord.com/api/v8/oauth2/token";
$ch = curl_init($url);
curl_setopt_array($ch, array(
    CURLOPT_HTTPHEADER  => array('Content-Type: application/x-www-form-urlencoded'),
    CURLOPT_POSTFIELDS => http_build_query(array('client_id'=>'812759298354446366','client_secret'=>'wWeequJjbEzOJbK24sDpyFJriC483Yvg','grant_type'=>'authorization_code','code'=>$code,'redirect_uri'=>'http://localhost/discord_panel/login.php/','scope'=>'identify email guilds')),
    CURLOPT_RETURNTRANSFER  =>true,
    CURLOPT_VERBOSE     => 1
));
$content = curl_exec($ch);
    curl_close($ch);
$content = json_decode($content,true);

if($content['access_token']!=null){
$scopes = explode(' ',$content['scope']);
$id = false;
$em = false;
$gu = false;
for($i=0;$i<count($scopes);$i++)
{
    if($scopes[$i]=="identify")
    {
        $id=true;
    }
    else if($scopes[$i]=="email")
    {
        $em = true;
    }
    else if($scopes[$i]=="guilds")
    {
        $gu=true;
    }
}
if($id&&$em&&$id)
{
    setcookie('ac_token',$content['access_token'],time()+$content['expires_in'],'/');
setcookie('token',$content['refresh_token'],time()+$content['expires_in']*999,'/');
echo "<script>window.close()</script>";
}
else
{
    echo file_get_contents('auth_error.html');
echo<<<_END
    <script>
    var text = document.getElementById("info_text")
    text.innerText = "Invalid Scope. Try again"
    </script>
_END;
}
}
else
{
    echo "wystąpił błąd podczas autorryzacji spróbuj ponownie za chwilę";
}
?>