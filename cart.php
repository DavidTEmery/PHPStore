<?php
require_once "include/Session.php";
$session = new Session();

require_once "include/DB.php";
DB::init();

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

<?php if (isset($session->cart)): ?>
    <table border="1" cellpadding="2">
        <tr><th align="left">Name:</th><th>Price:</th><th>Quantity:</th></tr>
        <?php foreach ($session->cart as $item_id => $quantity): ?>
            <?php $item = R::load("item", $item_id) ?>
            <tr><td><?php echo $item->name ?></td>
                <td><?php echo $item->price ?></td>
                <td>
                    <form method="post" action="editCart.php"> 
                        <input type="text" name="quantity" value="<?php echo $quantity ?>" />
                        <input type="hidden" name="id" value="<?php echo $item_id ?>" />
                    </form>
                    </td></tr>
                    
                    
                   
        <?php endforeach ?>
    </table>
<?php else: // if cart is unset: ?>
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
