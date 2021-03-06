<?php
require_once('database.php');

// Get IDs
$_SESSION['record_id'] = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$_SESSION['model_id'] = filter_input(INPUT_POST, 'model_id', FILTER_VALIDATE_INT);
$_SESSION['fuel_id'] = filter_input(INPUT_POST, 'fuel_id', FILTER_VALIDATE_INT);
// Delete the product from the database
if ($_SESSION['record_id'] != false && $_SESSION['model_id'] != false && $_SESSION['fuel_id'] != false) {
    $query = "DELETE FROM records
              WHERE recordID = :record_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':record_id', $_SESSION['record_id']);
    $statement->execute();
    $statement->closeCursor();
}

// display the Product List page
include('index.php');
?>