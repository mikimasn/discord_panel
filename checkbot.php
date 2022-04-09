<?php
error_reporting(0);
if(isset($_POST['id']))
{
    $id = $_POST['id'];
    if(isset($_POST['type']))
    {
        if(isset($_COOKIE['g_id']))
        {
             echo $_COOKIE['g_id'];
            setcookie('g_id','xd',time()-1,'/');
        }
        else
        {
            echo "0";
        }
    }

    else
    {
    
    $url = "https://discord.com/api/guilds/".strval($id);
$ch = curl_init($url);
curl_setopt_array($ch, array(
    CURLOPT_HTTPHEADER  => array('Authorization: Bot ODEyNzU5Mjk4MzU0NDQ2MzY2.YDFbFQ.mnYOQpQsKvAUJkqcO4L-O5CnKKY'),
    CURLOPT_RETURNTRANSFER  =>true,
));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 

$content = curl_exec($ch);
    curl_close($ch);
$guild_info = json_decode($content,true);
if($guild_info['message']!=null)
{
    echo "0";
}
else
{
    echo "1";
}
    }
}
else if(isset($_GET['guild_id']))
{
    setcookie('g_id',$_GET['guild_id'],time()+1000,'/');
    echo'
    <script>window.close()</script>
    ';
}
?>
