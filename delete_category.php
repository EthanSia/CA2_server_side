<?php
// Get ID
$model_id = filter_input(INPUT_POST, 'model_id', FILTER_VALIDATE_INT);

// Validate inputs
if ($model_id == null || $model_id == false) {
    $error = "Invalid model ID.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the product to the database  
    $query = 'DELETE FROM models 
              WHERE modelID = :model_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':model_id', $model_id);
    $statement->execute();
    $statement->closeCursor();

    // Display the model List page
    include('model_list.php');
}
?>
