<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

$method = $_SERVER['REQUEST_METHOD'];
//echo $method;

$request_uri = $_SERVER['REQUEST_URI'];
//echo $request_uri;

$tables = ['post'];
$url = rtrim($request_uri,'/');
$url = filter_var($request_uri, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$tableName = (string) $url[3];

if($url[4] != null){
    $id = (int) $url[4];
}else{
    $id = null;
}

if(in_array($tableName, $tables)){
    //echo 'We have something';
    include_once './classes/Database.php';
    include_once './api/post.php';


} else {
   echo 'Table does not exist';
}
//print_r($tableName);
