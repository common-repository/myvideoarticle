<?php
global $mva_server_url,$mva_mp4_url;
$mva_preview_url="http://preview.myvideoarticle.com/convert/?apikey=twetug41yuyg4uy";
$mva_mp4_url="mp4.myvideoarticle.com";
function mva_create_preview($post_id)
{
    global $mva_server_url;
    $post=get_post($post_id);
    $data=array("title"=>$post->post_title,"description"=>$post->post_content);
    return(mva_curl($mva_server_url,$data));
}
function mva_curl($url,$data,$method="post")
{
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$url); 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));		
    $result = curl_exec($ch); 
    curl_close($ch); 
    return $result;
    
}
?>
