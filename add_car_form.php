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

require('database.php');
$query = 'SELECT *
          FROM models
          ORDER BY modelID';
$statement = $db->prepare($query);
$statement->execute();
$models = $statement->fetchAll();
$statement->closeCursor();
?>

<?php
require('database.php');
$query = 'SELECT *
          FROM fuel
          ORDER BY fuelID';
$statement = $db->prepare($query);
$statement->execute();
$fuels = $statement->fetchAll();
$statement->closeCursor();
?>

<!-- the head section -->
 <div class="container">
<?php
include('includes/header.php');
?>
        <h1>Add Car</h1>
        <form action="add_car.php" method="post" enctype="multipart/form-data"
              id="add_car_form">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
            <label>Model:</label>
            <select name="model_id">
            <?php foreach ($models as $model) : ?>
                <option value="<?php echo $model['modelID']; ?>">
                    <?php echo $model['modelName']; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <br>

            <label>Fuel:</label>
            <select name="fuel_id">
            <?php foreach ($fuels as $fuel) : ?>
                <option value="<?php echo $fuel['fuelID']; ?>">
                    <?php echo $fuel['fuelName']; ?>
                </option>
            <?php endforeach; ?>
            </select>

            <br>
            <label>Name:</label>
            <input type="input" name="name" pattern="[A-Z\s]+" title="All need to be uppercase character" required>
            <br>

            <label>Description:</label>
            <input type="input" name="description" class="description" required>
            <br>

            <label>List Price:</label>
            <input type="input" name="price"  pattern="^[1-9][1-9]*[.]?[1-9]{0,2}$" 
            title ="Please input the number  with only 2 decimal places" required>
            <br>    
            
            <label>Image:</label>
            <input type="file" name="image" accept="image/*" />
            <br>
            
            <label>&nbsp;</label>
            <input type="submit" value="Add car">
            <br>
            </form>
        </form>
        <p><a href="index.php">View Homepage</a></p>
    <?php
include('includes/footer.php');
?>