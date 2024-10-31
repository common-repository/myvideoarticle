<?php
/*
    Plugin Name: MyVideoArticle
    Plugin URI: http://MyVideoArticle.com/
    Description: Convert your articles into videos.
    Version: 0.1
    Author: ETechLogics
    Author URI: http://ETechLogics.com/
*/



add_filter('manage_posts_columns', 'MVA_posts_columns', 5);
add_action('manage_posts_custom_column', 'MVA_posts_custom_columns', 5, 2);

add_action('admin_head', 'MVA_Admin_Startup');
add_filter ( 'the_excerpt' , 'MVA_Content' , 10 ) ;
add_filter ( 'the_content' , 'MVA_Content' , 10 ) ;

function MVA_Admin_Startup()
{
    if($_REQUEST["MVA_Create"]!="")
    {
        include('mva_api.php');
        $response=mva_create_preview($_REQUEST["MVA_Create"]);
        $response=  simplexml_load_string($response);
        update_post_meta($_REQUEST["MVA_Create"],"_video_embed_code", urldecode($response->embed_code));
        ?>
        <div id="message" class="updated fade">
                <p><strong><?php echo __ ("Video Created") ; ?></strong></p>
        </div>
        <?php
    }
}
function MVA_posts_columns($defaults){
    $defaults['MVA_Column'] = __('Video');
    return $defaults;
}

function MVA_posts_custom_columns($column_name, $id){
	if($column_name === 'MVA_Column'){
        ?>
            <a href="?MVA_Create=<?php echo($id); ?>">Create</a>
        <?php
    }
}
function MVA_Content($content)
{
    $embed_code=get_post_meta($GLOBALS["post"]->ID,"_video_embed_code",true);
    if($embed_code!="")
    {
        $content=$embed_code.$content;
    }
    return($content);
}
?>
