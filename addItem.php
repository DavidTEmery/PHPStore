<?php
//  This is where the work of adding an item is done.  

require_once "include/Session.php";
$session = new Session();
$params = (object) $_REQUEST;
require_once "include/DB.php";
$props = DB::init();

// variable for filename
$name = "";

//$files = array((object) $_FILES);


$item = R::dispense('item');
$item->name = $params->name;
$item->category = $params->category;
$item->price = number_format($params->price, 2);

// http://www.sitepoint.com/file-uploads-with-php/ 
define("IMAGE_DIR", "C:\wamp\www\CSC417_2014_wiOznur\PhpStore\images\items\\");
//if(isset($params->imageFile)) {
    if (!empty($_FILES["imageFile"])) {
        $imageFile = $_FILES["imageFile"];
        if ($imageFile["error"] !== UPLOAD_ERR_OK) {
            echo "<p>An error occurred.</p>";
            exit;
        }
        // Check the filename
        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $imageFile["name"]);
        // don't overwrite an existing file
        $i = 0;
        $parts = pathinfo($name);
        while (file_exists(IMAGE_DIR . $name)) {
            $i++;
            $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
        }


        
        $item->image = $name;
        R::store($item);
        


        // preserve file from temporary directory
        $success = move_uploaded_file($imageFile["tmp_name"],
            IMAGE_DIR . $name);
        if (!$success) { 
            echo "<p>Unable to save file.</p>";
            exit;
        }
        // set proper permissions on the new file
        chmod(IMAGE_DIR . $name, 0644);
    
    
    } else echo "_FILES[ params->imageFile] not set ";
//} else echo " params->imageFile not set ";


//else 
//    header("location: addItemPage.php?error=1");
    

header("location: index.php");