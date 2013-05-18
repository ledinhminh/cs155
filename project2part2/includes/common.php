<?php
// txt-db-api library: http://www.c-worker.ch/txtdbapi/index_eng.php
require_once("txt-db-api/txt-db-api.php");
require_once("login.php");
require_once("auth.php");
require_once("navigation.php");

// Allow users to use the back button without reposting data
header ("Cache-Control: private");

// Init global variables
$db = new Database("zoobar");
$user = new User($db);

function _sanitize($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function applyTags($str){
    //Allow a subset of styling tags
    $markup = array(
        "/\[b\](.*?)\[\/b\]/",
        "/\[i\](.*?)\[\/i\]/",
        "/\[red\](.*?)\[\/red\]/",
        "/\[h(\d+)\](.*?)\[\/h(\d+)\]/",
        "/\[p\](.*?)\[\/p\]/",    
    );

    $tags= array(
        '<span style="font-weight:bold;">\\1</span>',
        '<span style="font-style:italic;">\\1</span>',
        '<span style="color:#ff0000;">\\1</span>',
        '<h\\1>\\2</h\\3>',
        '<p>\\1</p>',
    );

    $taggedStr= preg_replace($markup, $tags, $str);
    return $taggedStr;
}

// Check for logout and maybe display login page
if($_GET['action'] == 'logout') { 
    $user->_logout();
    display_login();
    exit();
}

// Validate user and maybe display login page
if(!validate_user($user)) {
    display_login();
    exit();
}

?>
