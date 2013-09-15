<?php

$_GET['max'] = 1; 

ob_start(); 
require(dirname(__FILE__) . '/full-text-rss/makefulltextfeed.php'); 
$xml_string = ob_get_clean(); 


$xml = simplexml_load_string($xml_string);
$content = $xml->channel->item->description;
$title = $xml->channel->item->title;

// Remove html comments because they make wordpress 
// publish in a wrong format
$content = preg_replace('/<!--(.|\n|\r)*?-->/', '', $content);

require_once(dirname(__FILE__) . '/../../../wp-load.php');
if (strlen($title) > 0) {
    $url_string = $_GET['url'];
    if (strlen($url_string) >= 80)
        $url_string = substr($url_string, 0, 40) . '...';
    $info = 
        '<blockquote class="lr-info">' . 
        __('This article is reposted from', 'link-reposter') . 
        ': <a href=' . $_GET['url'] . '>' . $url_string . '</a>' .
        '</blockquote>';
    $content = $info . $content;

    require(dirname(__FILE__) . '/lr-edit.php');
}
else {
    $error_message = 
        __( 'Cannot extract content from the following link. ', 'link-reposter') . 
        '<br/>'. $_GET['url'] . '<br/>' .
        __('Please try again or check your link. ', 'link-reposter' );
	wp_die($error_message );
}


?>
