<?php
error_reporting(1);
$sklad = explode('/',$_SERVER['REQUEST_URI']);
require_once '../auth.php';
echo file_get_contents('guild_panel.html');
$user_id = $user_info['id'];
$user_avatar = $user_info['avatar'];
if($user_avatar==null)
{
    $user_d = $user_info['discriminator'];
    $im_id = $user_d%5;
    $im_url = "https://cdn.discordapp.com/embed/avatars/".$im_id.".png";
}
else
{
$im_url = "https://cdn.discordapp.com/avatars/".$user_id."/".$user_avatar.".webp?size=256";
}
echo <<<_END
<script>
var profileph =document.getElementById("photo")
profileph.style="background: url($im_url) no-repeat;background-size: 32px;"
</script>

_END;
$url = "https://discord.com/api/users/@me/guilds";
$ch = curl_init($url);
curl_setopt_array($ch, array(
    CURLOPT_HTTPHEADER  => array('Authorization: Bearer '.$token),
    CURLOPT_RETURNTRANSFER  =>true,
    CURLOPT_VERBOSE     => 1
));

$content = curl_exec($ch);
    curl_close($ch);
$guilds = json_decode($content,true);
$find = false;
$server_num = 0;
if(count($sklad)>=3&&is_numeric($sklad[3]))
{
    for($i=0;$i<count($guilds);$i++)
    {
        if($guilds[$i]["id"]==$sklad[3])
        {
            $find=true;
            $server_num = $i;
            if($guilds[$i]["icon"]!=null)
            {
                echo '
                <script>
                var profilesr =document.getElementById("s_photo")
                profilesr.style="background: url(https://cdn.discordapp.com/icons/'.$guilds[$i]["id"].'/'.$guilds[$i]["icon"].'.webp?size=256) no-repeat;background-size: 32px;"
                var namesr =document.getElementById("server_name")
                namesr.innerHTML="'.htmlspecialchars($guilds[$i]["name"],ENT_QUOTES).'"
                </script>';
            }
            else
            {
                echo '
                <script>
                var namesr =document.getElementById("server_name")
                namesr.innerHTML="'.htmlspecialchars($guilds[$i]["name"],ENT_QUOTES).'"
                </script>';
            }

            break;
        }
    }
    if(!$find)
    {
        echo '
<script>
var profilesr =document.getElementById("s_photo")
profilesr.style="background: url(https://cdn.discordapp.com/embed/avatars/0.png) no-repeat;background-size: 32px;"
var namesr =document.getElementById("server_name")
namesr.innerText="Unkown Server"
var content = document.getElementById("content")
content.innerHTML ='."'".'<br><br><div class="auth_err"><img src="../lock.png" alt="kłudka" class="auth_err"><div id="ift"><p>Unauthorized</p><h1 id="info_text">'.htmlspecialchars("you don't have access to this site",ENT_QUOTES).'</h1></div></div>'."'".'
</script>';
    }
    else
    {
        if(($guilds[$server_num]["permissions"]&0x00000020)>0)
        {
            echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script><script src="guild.js"></script><input type="hidden" id="gid" value="'.$sklad[3].'"/>';
        }        
        else
        {
            echo '
            <script>
            var content = document.getElementById("content")
            content.innerHTML ='."'".'<br><br><div class="auth_err"><img src="../lock.png" alt="kłudka" class="auth_err"><div id="ift"><p>Unauthorized</p><h1 id="info_text">'.htmlspecialchars("you don't have access to this site",ENT_QUOTES).'</h1></div></div>'."'".'
            </script>
            ';
        }
    }
}
else
{
echo '
<script>
var profilesr =document.getElementById("s_photo")
profilesr.style="background: url(https://cdn.discordapp.com/embed/avatars/0.png) no-repeat;background-size: 32px;"
var namesr =document.getElementById("server_name")
namesr.innerText="Unkown Server"
var content = document.getElementById("content")
content.innerHTML ='."'".'<br><br><div class="auth_err"><img src="../lock.png" alt="kłudka" class="auth_err"><div id="ift"><p>Unauthorized</p><h1 id="info_text">'.htmlspecialchars("you don't have access to this site",ENT_QUOTES).'</h1></div></div>'."'".'
</script>
';    
}

?>