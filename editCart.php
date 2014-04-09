<!-- WebShop 4/8/14 -->

<?php
require_once "include/Session.php";
$session = new Session();

$params = (object) $_REQUEST;

if ($params->quantity == 0 && count($session->cart)==1)
    unset($session->cart);
elseif ($params->quantity == 0)
    unset($session->cart[$params->id]);
else
    $session->cart[$params->id] = $params->quantity;

header("location: cart.php");

