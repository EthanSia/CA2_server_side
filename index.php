<?php

/**
 * Start the session.
 */
session_start();

/**
 * Check if the user is logged in.
 */
if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
    //User not logged in. Redirect them back to the login.php page.
    header('Location: login.php');
    exit;
}


/**
 * Print out something that only logged in users can see.
 */

echo 'Congratulations! You are logged in!';

require_once('database.php');
$model_name = "";
$fuel_name ="";
// Get car ID
if (!isset($car_id)) {
    $car_id = filter_input(INPUT_GET, 'car_id', 
    FILTER_VALIDATE_INT);
    if ($car_id == NULL || $car_id == FALSE) {
    $car_id = 1;
    }
    }


// Get all cars
$queryAllcars = 'SELECT * FROM cars
ORDER BY modelID';
$statement1 = $db->prepare($queryAllcars);
$statement1->execute();
$cars = $statement1->fetchAll();
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


<h1>Car List</h1>

<!-- display a list of fuels -->
<form  method="post" action = " ">
<h1><a href="index.php">All Cars</a></h1>

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
<div id ="fuels_side">
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

     $querycars = "SELECT * FROM cars
     WHERE modelID = :model_id
     AND fuelID = :fuel_id
     ORDER BY carID";
     $statement4 = $db->prepare($querycars);
     $statement4->bindValue(':fuel_id', $sel_fuel_id);
     $statement4->bindValue(':model_id', $sel_model_id);
     $statement4->execute();
     $cars = $statement4->fetchAll();
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

        $querycars = "SELECT * FROM cars
        WHERE fuelID = :fuel_id
        ORDER BY carID";
        $statement3 = $db->prepare($querycars);
        $statement3->bindValue(':fuel_id', $selected_id);
        $statement3->execute();
        $cars = $statement3->fetchAll();
        $statement3->closeCursor();
      
    }
   
}

if(!empty($_POST['models']) && empty($_POST['fuels'])) 
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
        
        $querycars = "SELECT * FROM cars
        WHERE modelID = :model_id
        ORDER BY carID";
        $statement3 = $db->prepare($querycars);
        $statement3->bindValue(':model_id', $selected_model_id);
        $statement3->execute();
        $cars = $statement3->fetchAll();
        $statement3->closeCursor();
    }
   
}
?>
</ul>
<input type="submit" value="submit">
</nav> 
</div>         
</aside>

</form>



<section class="ftco-section">
<!-- display a table of cars -->
<h2><?php echo $model_name; ?></h2>
<h2><?php echo $fuel_name; ?></h2>
<table class= "table">
<thead class="thead-primary">
<tr>
<th>Image</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<?php
if(isset($_SESSION['user_id'])=== 1)
{
?>
<th>Delete</th>
<th>Edit</th>
<?php
}
?>

</tr>
<thead class="thead-primary">
<?php foreach ($cars as $car) : ?>
<tr class="alert" role="alert">
<td class="img"><img src="image_uploads/<?php echo $car['image']; ?>" width="100px" height="100px" /></td>
<td><?php echo $car['name']; ?></td>
<td class="email"><?php echo $car['description']; ?></td>
<td class="quantity"><?php echo $car['price']; ?></td>

<?php
if(isset($_SESSION['user_id'])=== 1)
{
?>
<td><form action="delete_car.php" method="post"
id="delete_car_form">
<input type="hidden" name="car_id"
value="<?php echo $car['carID']; ?>">
<input type="hidden" name="fuel_id"
value="<?php echo $car['fuelID']; ?>">
<input type="hidden" name="model_id"
value="<?php echo $car['modelID']; ?>">

<input type="submit" value="Delete">

</form></td>

<td><form action="edit_car_form.php" method="post"
id="delete_car_form">
<input type="hidden" name="car_id"
value="<?php echo $car['carID']; ?>">
<input type="hidden" name="fuel_id"
value="<?php echo $car['fuelID']; ?>">
<input type="hidden" name="model_id"
value="<?php echo $car['modelID']; ?>">

<input type="submit" value="Edit">
</form></td>
<?php
}
?>
</tr>
<?php endforeach; ?>
</table>
<?php
if(isset($_SESSION['user_id'])=== 0)
{
?>
<p><a href="add_car_form.php">Add Car</a></p>
<p><a href="model_list.php">Manage models</a></p>
<p><a href="fuel_list.php">Manage Fuels</a></p>
<?php
}
?>

</section>
<?php
include('includes/footer.php');
?>