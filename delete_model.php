<?php
// Get ID
$model_id = filter_input(INPUT_POST, 'model_id', FILTER_VALIDATE_INT);

// Validate inputs
if ($model_id == null || $model_id == false) {
    $error = "Invalid model ID.";
    include('error.php');
} else {
    require_once('database.php');

    $query = 'DELETE FROM models 
              WHERE modelID = :model_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':model_id', $model_id);
    $statement->execute();
    $statement->closeCursor();

    $query = 'DELETE FROM cars 
    WHERE modelID = :model_id';
    $statement1 = $db->prepare($query);
    $statement1->bindValue(':model_id', $model_id);
    $statement1->execute();
    $statement1->closeCursor();



    include('model_list.php');
}
?>
