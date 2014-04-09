<?php
require_once "include/Session.php";
$session = new Session();
?>
<li><a href=".">Home</a></li>
<li><a href="cart.php">My Cart</a></li>

<?php if (isset($session->user)): ?>
    <?php if ($session->user->level == 1): ?>
        <li><a href="addItemPage.php">Add Item</a></li>
    <?php endif ?>
<?php endif ?>

<li>
    <?php if (!isset($session->user)): ?>
        <a href="login.php">Login</a>
    <?php else: ?>
        <a href="logout.php">Logout</a>
    <?php endif ?>
</li>
<li><a href="help.php">Help</a></li>
