<?php
require_once "include/Session.php";
$session = new Session();

unset($session->cart);

header( "location: cart.php" );