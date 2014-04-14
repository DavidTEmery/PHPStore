<?php
// My Orders
require_once "include/Session.php";
$session = new Session();
require_once "include/DB.php";
DB::init();

// fetch all orders: 
$myOrders = R::find('order');
$orderTotal = null;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>All Orders</title>

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

                <h2>All Orders</h2>

                <?php if ($myOrders): ?>
                    <table border="1" cellpadding="2">
                        <!-- Ierate through the collection of orders -->
                        <?php foreach ($myOrders as $order): ?>
                        
                       <?php $item_orders = R::findAll('item_order', 'order_id=?', array($order->id));
                        foreach ($item_orders as $item_order){
                        $orderTotal += $item_order->price * $item_order->quantity; }?>
                        
                            <tr><td><a href="showOrder.php?orderid=<?php echo $order->id ?>">
                                        <?php echo $order->id ?> </a></td>
                                <td><a href="showOrder.php?orderid=<?php echo $order->id ?>">
                                    <?php echo date("M j, Y H:j:s" ,$order->created_at) ?></a></td>
                                <td>Order Total:  <?php echo $orderTotal; $orderTotal=0 ?> </td>

                                <?php if ($session->user->level == 1): ?>
                                <td>
                                <form action="fulfillOrder.php" method="post" >
                                    <input type="submit" value="Fulfill Order" />
                                    <input type="hidden" value=<?php echo $order->id ?> name='orderId' />
                                </form>
                                </td>
                            </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    </table>
                <?php else: // if cart is unset:   ?>
                    You have no orders. 
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
