<?php
//  This is where the work of adding an item is done.  
require_once "include/Session.php";
$session = new Session();
$params = (object) $_REQUEST;
require_once "include/DB.php";
$props = DB::init();

$item = R::dispense('item');
$item->name = $params->name;
$item->category = $params->category;
$item->price = $params->price;

$id = R::store($item);

header("location: index.php");