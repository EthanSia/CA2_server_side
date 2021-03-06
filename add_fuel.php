<?php

$_SESSION['name'] = filter_input(INPUT_POST, 'name');

// Validate inputs
if ($_SESSION['name']== null) {
    $error = "Invalid fuel data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the product to the database
    $query = "INSERT INTO fuel (fuelName)
              VALUES (:name)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $statement->closeCursor();

    // Display the fuel List page
    include('fuel_list.php');
}
?>