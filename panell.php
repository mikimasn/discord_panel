<?php
error_reporting (1);
echo file_get_contents('panel.html');
require_once 'auth.php';
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

for($i=0;$i<count($guilds);$i++)
{
    
    if($guilds[$i]["permissions"]&0x20)
    {
        
        $g_name=$guilds[$i]["name"];
        if(strlen($g_name)>35)
        {
            $g_name = substr($g_name,0,32)." ...";
        }
        $g_icon=$guilds[$i]["icon"];
        $g_id = $guilds[$i]["id"];
        
        if($g_icon==null)
        {
            echo '
            <script>
            var s = document.getElementById("servers");
            s.innerHTML +='."'".'<div class="server-list"><br><div class="io_server"><p>'.htmlspecialchars($g_name,ENT_QUOTES).'</p><a href="guild/'.$g_id.'" id="'.$g_id.'-h" style="display:none;"><input type="button" value="$g_id" id="'.$g_id.'"></a></div></div>'."'".'
            ids.push("'.$g_id.'");
            </script>
            ';
        }
        else
        {
            echo '
            <script>
            var s = document.getElementById("servers");
            s.innerHTML +='."'".'<div class="server-list"><div class="server-profile" style="background: url(https://cdn.discordapp.com/icons/'.$guilds[$i]["id"].'/'.$guilds[$i]["icon"].'.webp?size=256) 0% 0% / 64px no-repeat;"></div><br><div class="io_server"><p>'.htmlspecialchars($g_name,ENT_QUOTES).'</p><a href="guild/'.$g_id.'" id="'.$g_id.'-h" style="display:none;"><input type="button" value="xd" id="'.$g_id.'"></a></div></div>'."'".'
            ids.push("'.$g_id.'");
            </script>
            ';
            
        }

    }
}
echo '
<script>
load=true;
</script>
'
?>