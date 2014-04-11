<?php
//error_reporting(0);

require_once "include/Session.php";
$session = new Session();
require_once "include/DB.php";
DB::init();
$params = (object) $_SESSION;

$disabled = ""; // This variable will determine whether a cart item can be 
                // modified based on whether the item is for sale.  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>My Cart</title>

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

                <h2>My Cart</h2>

                <?php if (isset($session->cart)): 
                    $total = 0; ?>
                    <table border="1" cellpadding="2">
                        <tr><th align="left">Name:</th><th>Price:</th><th>Quantity:</th></tr>
                        <?php foreach ($session->cart as $item_id => $quantity): ?>
                            <?php
                                $item = R::load("item", $item_id);
                                if ($item->for_sale == 0) {
                                    $disabled = "disabled";
                                } else {
                                    $disabled = "";
                                }
                                ?>
                        <tr><td><a href="showItem.php?item_id=<?php echo $item->id ?>"> <?php echo $item->name ?> </a></td>
                                <td><?php echo "$".number_format($item->price, 2) ?></td>
                                <td>
                                    <form name="editQnty" method="post" action="editCart.php" > 
                                        <input type="text" size="3" name="quantity" value="<?php echo $quantity ?>" <?php echo $disabled ?> />
                                        <input type="hidden" name="id" value="<?php echo $item_id ?>" />
                                        <input type="submit" value="Submit" <?php echo $disabled ?> />
                                    </form>
                                </td>
                                <td color=red> <!-- Click to Remove from cart: -->
                                    <form name="remove" method="post" action="editCart.php"> 
                                        <input type="hidden" name="quantity" value="0" />
                                        <input type="hidden" name="id" value="<?php echo $item_id ?>" />
                                        <input type="submit" value="Remove From Cart"/>
                                    </form>
                                </td></tr>
                            <?php $total += $item->price * $quantity; ?>
                        <?php endforeach ?>
                    </table>
                    <br>
                    <b>Total: $<?php echo number_format($total, 2) ?></b>

                    <?php if ($session->user): ?>
                        <form action="placeOrder.php" method="post">
                            <input type="submit" value="Place Order" />
                            <input type="hidden" value=<?php $session->cart?> />
                        </form>
                    <?php endif ?>
                    
                    <!-- Clear Cart: -->
                        <form action="clearCart.php" method="post">
                            <input value="true" name="clearCart" type="hidden" />
                            <input type="submit" value="Clear Cart" />
                        </form>
                    
                <?php else: // if cart is unset:  ?>
                    Your Cart is Empty
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
