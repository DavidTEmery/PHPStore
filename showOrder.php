<?php
require_once "include/Session.php";
require_once "include/DB.php";
$session = new Session();

DB::init();
R::setStrictTyping(false);

$params = (object) $_REQUEST;

$orderid = $params->orderid;

$item_orders = R::find('item_order', 'order_id=?', array($orderid));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>My Orders</title>

        <link rel="stylesheet" type="text/css" href="css/superfish.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <style type="text/css">
            /* local style rules */
        </style>

    </head>

    <body>
        <div class="container">
            <div class="header"><?php require_once "include/header.php" ?></div>
            <div class="navigation"><?php require_once "include/navigation.php" ?></div>
            <div class="content"><!-- content -->

                <h2>Order Details</h2>
                
                <button onclick="history.go(-1);"> Back </button>
                
                <?php if ($item_orders): ?>
                    <table border="1" cellpadding="2">
                        <!-- Ierate through the collection of orders -->
                        <?php foreach ($item_orders as $item_order): ?>
                        
                            <?php $item = R::findOne('item', 'id=?', array($item_order->item_id)); ?>
                            <tr><td><a href="showItem.php?item_id=<?php echo $item_order->item_id ?>">
                                        <?php echo $item->name ?> </a></td>
                                <td><?php echo $item_order->quantity?></td>
                            </tr>
                            
                        <?php endforeach ?>
                    </table>
                <?php else: // if cart is unset:   ?>
                    This order has no items. 
                <?php endif ?>
            </div><!-- content -->
        </div><!-- container -->

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/superfish.min.js"></script>
        <script type="text/javascript" src="js/init.js"></script>
        <script type="text/javascript">
            /* local JavaScript */
        </script>

    </body>
</html>
