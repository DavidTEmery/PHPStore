<?php
require_once "include/Session.php";
$session = new Session();
$params = (object) $_REQUEST;
require_once "include/DB.php";
DB::init();

$keywords = array("%".$params->keywords."%");

$sortDirection = "asc";
//$sortDirection = $params->sortDirection;
//if ($sortDirection == "asc") {
//    $sortDirection = "desc";
//} elseif ($sortDirection == "desc") {
//    $sortDirection = "asc";
//} else {
//    $sortDirection = "asc";
//}

if(isset($params->orderField)) {
    $items = R::find('item', " name like ? order by $params->orderField $sortDirection", $keywords);
} else {
    $items = R::find('item', ' name like ? ', $keywords);
}
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

    </head>
    <body>
<div class="container">
<div class="header"><?php require_once "include/header.php" ?></div>
<div class="navigation"><?php require_once "include/navigation.php" ?></div>
<div class="content"><!-- content -->

<h2>Search Results</h2>
<h3> Your search for "<?php echo $params->keywords ?>" yielded <?php echo count($items) ?> results: </h3>

<!-- Main Display Table -->
<table>
  <tr> <!-- All of these links resend the keywords parameter. -->
    <th><a href="search.php?orderField=name&keywords=<?php echo $params->keywords ?>"?>Name</a></th>
    <th><a href="search.php?orderField=category&keywords=<?php echo $params->keywords ?>"?>Category</a></th>
    <th><a href="search.php?orderField=price&keywords=<?php echo $params->keywords ?>"?>Price</a></th>
    <th><a href="search.php?orderField=for_sale&keywords=<?php echo $params->keywords ?>"?>For Sale:</a></th>
  </tr>
  <?php foreach ($items as $item): ?>
    <tr>
      <td><a href="showItem.php?item_id=<?php echo $item->id ?>">
        <?php echo htmlspecialchars($item->name) ?></a>
      </td>
      <td><?php echo $item->category ?></td>
      <td>$<?php echo number_format($item->price,2) ?></td>
      <td><?php
              if ($item->for_sale == 1) echo "Yes";
              else echo "No"; ?></td>
    </tr>
  <?php endforeach ?>
</table>

</html>