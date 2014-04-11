<?php
require_once "include/DB.php";
DB::init();
$params = (object) $_REQUEST;

if($params->orderId) {
    $order = R::findOne('order', 'id=?', array($params->orderId));
    R::trash($order);
}

header('location: myOrders.php');