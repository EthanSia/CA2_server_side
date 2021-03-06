<?php

// Get the record data
$_SESSION['record_id'] = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$_SESSION['model_id'] = filter_input(INPUT_POST, 'model_id', FILTER_VALIDATE_INT);
$_SESSION['fuel_id'] = filter_input(INPUT_POST, 'fuel_id', FILTER_VALIDATE_INT);
$_SESSION['name'] = filter_input(INPUT_POST, 'name');
$_SESSION['model'] = filter_input(INPUT_POST, 'model');
$_SESSION['description'] = filter_input(INPUT_POST, 'description');
$_SESSION['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$_SESSION['typeOfFuel'] = filter_input(INPUT_POST, 'typeOfFuel');
// Validate inputs
if ($_SESSION['record_id'] == NULL || $_SESSION['record_id'] == FALSE || $_SESSION['model_id'] == NULL ||
$_SESSION['model_id'] == FALSE || $_SESSION['fuel_id'] == NULL || $_SESSION['fuel_id'] == FALSE || empty($_SESSION['name']) || empty($_SESSION['name']) || empty($_SESSION['model']) || empty($_SESSION['description']) ||
$_SESSION['price'] == NULL || $_SESSION['price'] == FALSE empty($_SESSION['typeOfFuel'])) {
$error = "Invalid record data. Check all fields and try again.";
include('error.php');
} else {

/**************************** Image upload ****************************/

$imgFile = $_FILES['image']['name'];
$tmp_dir = $_FILES['image']['tmp_name'];
$imgSize = $_FILES['image']['size'];
$original_image = filter_input(INPUT_POST, 'original_image');

if ($imgFile) {
$upload_dir = 'image_uploads/'; // upload directory	
$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
$image = rand(1000, 1000000) . "." . $imgExt;
if (in_array($imgExt, $valid_extensions)) {
if ($imgSize < 5000000) {
if (filter_input(INPUT_POST, 'original_image') !== "") {
unlink($upload_dir . $original_image);                    
}
move_uploaded_file($tmp_dir, $upload_dir . $image);
} else {
$errMSG = "Sorry, your file is too large it should be less then 5MB";
}
} else {
$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
}
} else {
// if no image selected the old image remain as it is.
$image = $original_image; // old image from database
}

/************************** End Image upload **************************/

// If valid, update the record in the database
require_once('database.php');

$query = 'UPDATE records
SET modelID = :model_id,
SET fuelID = :fuel_id,
name = :name,
model = :model,
description = :description,
price = :price,
image = :image
WHERE recordID = :record_id';
$statement = $db->prepare($query);
$statement->bindValue(':model_id', $_SESSION['model_id']);
$statement->bindValue(':fuel_id', $_SESSION['fuel_id']);
$statement->bindValue(':name', $_SESSION['name']);
$statement->bindValue(':model', $_SESSION['model']);
$statement->bindValue(':description', $_SESSION['description']);
$statement->bindValue(':price', $_SESSION['price']);
$statement->bindValue(':typeOfFuel', $_SESSION['typeOfFuel']);
$statement->bindValue(':image', $image);
$statement->bindValue(':record_id', $_SESSION['record_id']);
$statement->execute();
$statement->closeCursor();

// Display the Product List page
include('index.php');
}
?>