<?php
// Get ID
$fuel_id = filter_input(INPUT_POST, 'fuel_id', FILTER_VALIDATE_INT);

// Validate inputs
if ($fuel_id == null || $fuel_id == false) {
    $error = "Invalid fuel ID.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the product to the database  
    $query = 'DELETE FROM fuel 
              WHERE fuelID = :fuel_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':fuel_id', $fuel_id);
    $statement->execute();
    $statement->closeCursor();

    // Display the Fuel List page
    include('fuel_list.php');
}
?>
