<?php
require_once "include/Session.php";
$session = new Session();

require_once "include/DB.php";
DB::init();

$params = (object) $_REQUEST;

$item = R::load('item',$params->item_id);

if(isset($params->name)) {
    $item->name = $params->name;
    R::store($item);
}
if(isset($params->price)) {
    $item->price = $params->price;
    R::store($item);
}
if(isset($params->for_sale)) {
    $item->for_sale = $params->for_sale;
    R::store($item);
}
// Delete an item upon request: 
if(isset($params->delete)) {
    R::trash($item);
    header("location: index.php");
}

if ($item->for_sale == 1)
    $disabled = ""; //Not Disabled
else
    $disabled = "disabled";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Item Features</title>
<link rel="stylesheet" type="text/css" href="css/superfish.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/table-display.css" />
<style type="text/css">
  .block {
    display: inline-block;
    vertical-align: top;
  }
  .item-descrip {
    max-width: 375px;
    margin: 2px 5px;
  }
  .item-descrip {
    margin: 2px 5px;
  }
  .item-descrip header {
    font-weight: bold;
    margin: 2px 0 5px 0;
 }
  .item-image img {
    max-width: 300px;
    margin-top: 5px;
  }
  .item-features {
    margin-right: 40px;
    max-width: 400px;
  }
  .item-cart {
    margin: 5px;
    padding: 5px 10px;
    border: solid 2px  red;
    border-radius: 4px;
  }
  .item-modify {
      margin: 7px;
      padding: 5px 10px;
      border: solid 3px  green;
      border-radius: 4px;
  }
</style>
</head>

<body>
<div class="container">
<div class="header"><?php require_once "include/header.php" ?></div>
<div class="navigation"><?php require_once "include/navigation.php" ?></div>
<div class="content"><!-- content -->

<h2>Item Features</h2>

<div class="block item-features">
    <table>
      <tr> <th>id:</th> <td><?php echo $item->id ?></td> </tr>
      <tr> <th>name:</th> <td><?php echo htmlspecialchars($item->name) ?></td> </tr>
      <tr> <th>category:</th> <td><?php echo $item->category ?></td> </tr>
      <tr> <th>price:</th> <td>$<?php echo number_format($item->price, 2) ?></td> </tr>
      <tr> <th>For Sale:</th> <td><?php
              if ($item->for_sale == 1) echo "Yes";
              else echo "No" ?></td> </tr>
    </table>
</div>



<?php if (isset($session->user) && $session->user->level == 1): ?>
    <div class="block item-modify">
        <b>Modify - Admin Only</b>
        
        <form method="post" action="">
            <input type="submit" name="delete" value="delete"/>
        </form>
        
        <form action="" method="post">
            <br />
            <input type="hidden" name="id" value="<?php echo $item->id ?>" />
            Name:
            <input type="text" name="name" value="<?php echo htmlspecialchars($item->name) ?>" />
            <br />
            Price: $
            <input type="text" name="price" value="<?php echo number_format($item->price, 2) ?>" />
            <br />
            <?php if ($item->for_sale == 1):?>
                <button type="submit" name="for_sale" value=0 >Take Off Market</button>
            <?php else: ?>
                <button type="submit" name="for_sale" value=1 >Put On Market</button>
            <?php endif ?>
        </form>
    </div>
<?php endif ?>

<div class="block item-cart">
  <form action="addToCart.php" method="post">
    <b>Purchase</b>
    <br />
    <input type="hidden" name="id" value="<?php echo $item->id ?>" />
    quantity:
    <input type="text" size="5" name="quantity" value="1" />
    <br />
    <input <?php echo $disabled ?> type="submit" name="doit" value="Add To Cart"/>
  </form>
</div>


<br />
<div class="block item-descrip">
  <header>description: </header>
  <?php if (empty($item->description)): ?>
  <strong>Not Available</strong>
  <?php else: ?>
  <?php echo $item->description ?>
  <?php endif ?>
</div>
<div class="block item-image">
  <img src="images/items/<?php echo $item->image ?>" />
</div>

</div><!-- content -->
</div><!-- container -->

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/superfish.min.js"></script>
<script type="text/javascript" src="js/init.js"></script>
<script type="text/javascript">
</script>

</body>
</html>
