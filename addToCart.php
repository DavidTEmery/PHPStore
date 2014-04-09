<!-- PHP Store 4/8/14 -->

<?php
require_once "include/Session.php";
$session = new Session();

$params = (object) $_REQUEST;

$session->cart[$params->id] += $params->quantity;

header("location: cart.php");
