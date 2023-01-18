<?php
    define('ROOT_PATH',str_replace('mvc_php/public', '', $_SERVER["DOCUMENT_ROOT"]));
    $parse = parse_url($_SERVER["REQUEST_URI"]);
    if(mb_substr($parse['path'],-1) === '/') {
        $parse['path'] .= $_SERVER["SCRIPT_NAME"];
    }
    require_once(ROOT_PATH.'mvc_php/Views'.$parse['path']); // Players/register.php
?>