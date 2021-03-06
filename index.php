<?php
require_once "include/DB.php";
DB::init();
$params = (object) $_REQUEST;
$orderField = "name";
if (isset($params->orderField)) {
  $orderField = $params->orderField;
}

//$items = R::findAll('item',"1 order by name asc");

// pagination: 

$items_per_page = 10;

$page = 1;
$nextPage = 2;
if (isset($params->page)) {
  $page = $params->page;
  $nextPage = $page + 1;
  $prevPage = $page - 1;
}
$offset = ($page-1) * $items_per_page;

$items = R::findAll('item',
   "1 order by $orderField asc limit $offset,$items_per_page");

$num_pages = ceil( R::count('item')/$items_per_page );

// we want to add the page parameter but maintain the ordering
//$paging_url = "{$_SERVER['PHP_SELF']}?orderField=$orderField";
$paging_url = "index.php?orderField=$orderField";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Home</title>
<link rel="stylesheet" type="text/css" href="css/superfish.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/table-display.css" />

<style type="text/css">
  #nav_bar {
    background: #000;
    color: #fff;
    margin-bottom: 15px;
    line-height: 25px;
    height: 25px;
    padding-left: 5px;
    cursor: pointer;
    border-radius: 6px;
  }
  #nav_bar a {
    color: #fff;
    font-weight: bold;
    padding: 0 5px;
    outline: none;
  }
  #nav_bar a:nth-child(<?php if ($page == 1) echo $page; else echo $page+1 ?>) {
    color: magenta;
  }
</style>


</head>

<body>
<div class="container">
<div class="header"><?php require_once "include/header.php" ?></div>
<div class="navigation"><?php require_once "include/navigation.php" ?></div>
<div class="content" align="center"><!-- content -->

<h2>Store Items: </h2> showing  
    <?php 
    if($page==1)
        echo " the first ";
    elseif($page==$num_pages)
        echo " the last ";
    echo count($items) ?> items


<div id="nav_bar">
    Pages:
    <?php if ($page > 1): ?>
        <a href="<?php echo "$paging_url&page=$prevPage" ?>"> <b> < </b> </a>
    <?php else: echo "<"; 
        endif?>

    <?php for ($num = 1; $num <= $num_pages; ++$num): ?>
        <a href="<?php echo "$paging_url&page=$num" ?>"><?php echo $num ?></a>
    <?php endfor ?>

    <?php if ($page < $num_pages): ?>
        <a href="<?php echo "$paging_url&page=$nextPage" ?>"> <b> > </b> </a>
    <?php endif ?>
</div>

<!-- Main Display Table -->
<table border="-10">
<!--  <tr>
    <th><a href="index.php?orderField=name">Name</a></th>
    <th><a href="index.php?orderField=category">Category</a></th>
    <th><a href="index.php?orderField=price">Price</a></th>
    <th><a href="index.php?orderField=for_sale"?>For Sale:</a></th>
  </tr>-->
  <?php foreach ($items as $item): ?>
    <tr>
        <td>
            <a href="showItem.php?item_id=<?php echo $item->id ?>">
                <img src="images/items/<?php echo $item->image ?>" height="25" />
            </a>
        </td>
      <td><a href="showItem.php?item_id=<?php echo $item->id ?>">
        <?php echo htmlspecialchars($item->name) ?></a>
          <br/>
        <?php echo $item->category." - "; if ($item->for_sale == 1) echo "For Sale";
              else echo "Not For Sale"; ?>
      </td>
      <td>$<?php echo number_format($item->price,2) ?></td>
      
    </tr>
  <?php endforeach ?>
</table>

<div id="nav_bar">
    Pages:
    <?php if ($page > 1): ?>
        <a href="<?php echo "$paging_url&page=$prevPage" ?>"> <b> < </b> </a>
    <?php else: echo "<"; 
        endif?>

    <?php for ($num = 1; $num <= $num_pages; ++$num): ?>
        <a href="<?php echo "$paging_url&page=$num" ?>"><?php echo $num ?></a>
    <?php endfor ?>

    <?php if ($page < $num_pages): ?>
        <a href="<?php echo "$paging_url&page=$nextPage" ?>"> <b> > </b> </a>
    <?php endif ?>
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