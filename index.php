<?php
require_once('database.php');
$model_name = "";
$fuel_name ="";
// Get model ID
if (!isset($record_id)) {
    $record_id = filter_input(INPUT_GET, 'record_id', 
    FILTER_VALIDATE_INT);
    if ($record_id == NULL || $record_id == FALSE) {
    $record_id = 1;
    }
    }


// Get all records
$queryAllRecords = 'SELECT * FROM records
ORDER BY modelID';
$statement1 = $db->prepare($queryAllRecords);
$statement1->execute();
$records = $statement1->fetchAll();
$statement1->closeCursor();

// Get model ID
if (!isset($model_id)) {
$model_id = filter_input(INPUT_GET, 'model_id', 
FILTER_VALIDATE_INT);
if ($model_id == NULL || $model_id == FALSE) {
$model_id = 1;
}
}


// Get all models
$queryAllmodels = 'SELECT * FROM models
ORDER BY modelID';
$statement1 = $db->prepare($queryAllmodels);
$statement1->execute();
$models = $statement1->fetchAll();
$statement1->closeCursor();



// Get fuel ID
if (!isset($fuel_id)) {
    $fuel_id = filter_input(INPUT_GET, 'fuel_id', 
    FILTER_VALIDATE_INT);
    if ($fuel_id == NULL || $fuel_id == FALSE) {
    $fuel_id = 1;
    }
    }


// Get all fuels
$queryAllFuels = 'SELECT * FROM fuel
ORDER BY fuelID';
$statement1 = $db->prepare($queryAllFuels);
$statement1->execute();
$fuels = $statement1->fetchAll();
$statement1->closeCursor();
?>
<div class="container">
<?php
include('includes/header.php');
?>


<h1>Record List</h1>

<!-- display a list of fuels -->
<form  method="post" action = " ">
<h2>Models</h2>
<nav>
<ul>
<?php foreach ($models as $model) : ?>
<li><input type ="checkbox" name="models[]"  value ="<?php echo $model['modelID']; ?>">
<?php echo $model['modelName']; ?>
</li>
<?php endforeach; ?>
</ul>
</nav>
<h2>Fuels</h2>
<nav>
<ul>
<?php foreach ($fuels as $fuel) : ?>
<li><input type ="checkbox" name="fuels[]"  value ="<?php echo $fuel['fuelID']; ?>">
<?php echo $fuel['fuelName']; ?>
<?php endforeach; ?>
<?php

if(!empty($_POST['models']) && !empty($_POST['fuels'])) 
{
    foreach($_POST['models'] as $selected_model_id)
     {       
        $sel_model_id = $selected_model_id;
     }
     foreach($_POST['fuels'] as $selected_fuel_id)
     {
        $sel_fuel_id = $selected_fuel_id;
     }

     echo  $sel_model_id;

     $queryFuel = "SELECT * FROM fuel
     WHERE fuelID = :fuel_id";
     $statement2 = $db->prepare($queryFuel);
     $statement2->bindValue(':fuel_id', $sel_fuel_id);
     $statement2->execute();
     $fuel = $statement2->fetch();
     $statement2->closeCursor();
     $fuel_name = $fuel['fuelName'];

     $querymodel = "SELECT * FROM models
        WHERE modelID = :model_id";
        $statement3 = $db->prepare($querymodel);
        $statement3->bindValue(':model_id', $sel_model_id);
        $statement3->execute();
        $model = $statement3->fetch();
        $statement3->closeCursor();
        $model_name = $model['modelName'];

     $queryRecords = "SELECT * FROM records
     WHERE modelID = :model_id
     AND fuelID = :fuel_id
     ORDER BY recordID";
     $statement4 = $db->prepare($queryRecords);
     $statement4->bindValue(':fuel_id', $sel_fuel_id);
     $statement4->bindValue(':model_id', $sel_model_id);
     $statement4->execute();
     $records = $statement4->fetchAll();
     $statement4->closeCursor();

    
   
}

if(!empty($_POST['fuels']) && empty($_POST['models'])) {
    foreach($_POST['fuels'] as $selected_id)
     {

    

          $queryFuel = "SELECT * FROM fuel
          WHERE fuelID = :fuel_id";
          $statement2 = $db->prepare($queryFuel);
          $statement2->bindValue(':fuel_id', $selected_id);
          $statement2->execute();
          $fuel = $statement2->fetch();
          $statement2->closeCursor();
          $fuel_name = $fuel['fuelName'];

        $queryRecords = "SELECT * FROM records
        WHERE fuelID = :fuel_id
        ORDER BY recordID";
        $statement3 = $db->prepare($queryRecords);
        $statement3->bindValue(':fuel_id', $selected_id);
        $statement3->execute();
        $records = $statement3->fetchAll();
        $statement3->closeCursor();
      
    }
   
}

if(!empty($_POST['models'])) 
{
    foreach($_POST['models'] as $selected_model_id)
     { 
        $querymodel = "SELECT * FROM models
        WHERE modelID = :model_id";
        $statement2 = $db->prepare($querymodel);
        $statement2->bindValue(':model_id', $selected_model_id);
        $statement2->execute();
        $model = $statement2->fetch();
        $statement2->closeCursor();
        $model_name = $model['modelName'];
        
        $queryRecords = "SELECT * FROM records
        WHERE modelID = :model_id
        ORDER BY recordID";
        $statement3 = $db->prepare($queryRecords);
        $statement3->bindValue(':model_id', $selected_model_id);
        $statement3->execute();
        $records = $statement3->fetchAll();
        $statement3->closeCursor();
    }
   
}
?>
</ul>
<input type="submit" value="submit">
</nav>          
</aside>

</form>



<section>
<!-- display a table of records -->
<h2><?php echo $model_name; ?></h2>
<h2><?php echo $fuel_name; ?></h2>
<h1>This is a normal h1</h1>
<table>
<tr>
<th>Image</th>
<th>Name</th>
<th>Model</th>
<th>Description</th>
<th>Price</th>
<th>Type of Fuel</th>
<th>Delete</th>
<th>Edit</th>
</tr>
<?php foreach ($records as $record) : ?>
<tr>
<td><img src="image_uploads/<?php echo $record['image']; ?>" width="100px" height="100px" /></td>
<td><?php echo $record['name']; ?></td>
<td class="left"><?php echo $record['model']; ?></td>
<td class="left"><?php echo $record['description']; ?></td>
<td class="right"><?php echo $record['price']; ?></td>
<td class="left"><?php echo $record['type_of_fuel']; ?></td>
<td><form action="delete_record.php" method="post"
id="delete_record_form">
<input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
<input type="hidden" name="fuel_id"
value="<?php echo $record['fuelID']; ?>">
<input type="hidden" name="model_id"
value="<?php echo $record['modelID']; ?>">
<input type="submit" value="Delete">
</form></td>
<td><form action="edit_record_form.php" method="post"
id="delete_record_form">
<input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
<input type="hidden" name="fuel_id"
value="<?php echo $record['fuelID']; ?>">
<input type="hidden" name="model_id"
value="<?php echo $record['modelID']; ?>">
<input type="submit" value="Edit">
</form></td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="add_record_form.php">Add Record</a></p>
<p><a href="model_list.php">Manage models</a></p>
<p><a href="fuel_list.php">Manage Fuels</a></p>
</section>
<?php
include('includes/footer.php');
?>