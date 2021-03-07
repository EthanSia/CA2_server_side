<?php
require_once('database.php');

// Get IDs
$car_id = filter_input(INPUT_POST, 'car_id', FILTER_VALIDATE_INT);
$model_id = filter_input(INPUT_POST, 'model_id', FILTER_VALIDATE_INT);
$fuel_id = filter_input(INPUT_POST, 'fuel_id', FILTER_VALIDATE_INT);
// Delete the product from the database
if ($car_id != false && $model_id != false && $fuel_id != false) {
    $query = "DELETE FROM cars
              WHERE carID = :car_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':car_id', $car_id);
    $statement->execute();
    $statement->closeCursor();
}

// display the Product List page
include('index.php');
?>