<?php
require('database.php');
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
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
        <h1>Add Record</h1>
        <form action="add_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">

            <label>Category:</label>
            <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
            </select>

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
            <input type="input" name="name" required>
            <br>

            <label>Description:</label>
            <input type="input" name="description" required>
            <br>

            <label>List Price:</label>
            <input type="input" name="price">
            <br>"Price must be double"<br>
            <br>    
            
            <label>Type of fuel:</label>
            <input type="input" name="typeOfFuel" required>
            <br>
            
            <label>Image:</label>
            <input type="file" name="image" accept="image/*" />
            <br>
            
            <label>&nbsp;</label>
            <input type="submit" value="Add Record">
            <br>
        </form>
        <p><a href="index.php">View Homepage</a></p>
    <?php
include('includes/footer.php');
?>