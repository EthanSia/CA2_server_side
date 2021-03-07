<?php
require('database.php');

$car_id = filter_input(INPUT_POST, 'car_id', FILTER_VALIDATE_INT);
$query = 'SELECT *
          FROM cars
          WHERE carID = :car_id';
$statement = $db->prepare($query);
$statement->bindValue(':car_id', $car_id);
$statement->execute();
$cars = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();
?>
<?php
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
        <h1>Edit Car</h1>
        <form action="edit_car.php" method="post" enctype="multipart/form-data"
              id="add_car_form">
            <input type="hidden" name="original_image" value="<?php echo $cars['image']; ?>" />
            <input type="hidden" name="car_id"
                   value="<?php echo $cars['carID']; ?>">
       
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
            <input type="input" name="name"
                   value="<?php echo $cars['name']; ?>" required>
            <br>


            <label>Description:</label>
            <input type="input" name="description" class="description"
                   value="<?php echo $cars['description']; ?>" required>
            <br>
            

            <label>List Price:</label>
            <input type="input" name="price"
                   value="<?php echo $cars['price']; ?>" pattern="^[1-9][1-9]*[.]?[1-9]{0,2}$"  required>
            <br>

         

            <label>Image:</label>
            <input type="file" name="image" accept="image/*" />
            <br>            
            <?php if ($cars['image'] != "") { ?>
            <p><img src="image_uploads/<?php echo $cars['image']; ?>" height="150" /></p>
            <?php } ?>
            
            <label>&nbsp;</label>
            <input type="submit" value="Save Changes">
            <br>
        </form>
        <p><a href="index.php">View Homepage</a></p>
    <?php
include('includes/footer.php');

?>