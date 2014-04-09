<?php
require_once "include/Session.php";
$session = new Session();
unset($session->user);

unset($session->cart);

header( "location: ." );
