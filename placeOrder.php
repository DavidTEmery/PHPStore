<?php
require_once "include/Session.php";
$session = new Session();
require_once "include/DB.php";
DB::init();

// https://github.com/gabordemooij/redbean/issues/197
R::setStrictTyping( false );

date_default_timezone_set('America/New_York');

$order = R::dispense('order');
$order->user_id = $session->user->id;
$order->created_at = time();
$orderId = R::store($order);

$item_order = R::dispense('item_order');
foreach($session->cart as $item_id => $quantity) {
    $item = R::findOne('item', $item_id);
    
    $item_order->item_id = $item_id;
    $item_order->order_id = $orderId;
    $item_order->quantity = $quantity;
    $item_order->price = $item->price;
    R::store($item_order);
}

// clear the cart
unset($session->cart);

header("location: myOrders.php");