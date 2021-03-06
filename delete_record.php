<?php
require_once('database.php');

// Get IDs
$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$model_id = filter_input(INPUT_POST, 'model_id', FILTER_VALIDATE_INT);

// Delete the product from the database
if ($record_id != false && $model_id != false) {
    $query = "DELETE FROM records
              WHERE recordID = :record_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':record_id', $record_id);
    $statement->execute();
    $statement->closeCursor();
}

// display the Product List page
include('index.php');
?>