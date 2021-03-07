<?php
require('database.php');

$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$query = 'SELECT *
          FROM records
          WHERE recordID = :record_id';
$statement = $db->prepare($query);
$statement->bindValue(':record_id', $record_id);
$statement->execute();
$records = $statement->fetch(PDO::FETCH_ASSOC);
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
        <h1>Edit Product</h1>
        <form action="edit_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">
            <input type="hidden" name="original_image" value="<?php echo $records['image']; ?>" />
            <input type="hidden" name="record_id"
                   value="<?php echo $records['recordID']; ?>">
       
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
                   value="<?php echo $records['name']; ?>">
            <br>


            <label>Description:</label>
            <input type="input" name="description"
                   value="<?php echo $records['description']; ?>">
            <br>
            

            <label>List Price:</label>
            <input type="input" name="price"
                   value="<?php echo $records['price']; ?>">
            <br>

         

            <label>Image:</label>
            <input type="file" name="image" accept="image/*" />
            <br>            
            <?php if ($records['image'] != "") { ?>
            <p><img src="image_uploads/<?php echo $records['image']; ?>" height="150" /></p>
            <?php } ?>
            
            <label>&nbsp;</label>
            <input type="submit" value="Save Changes">
            <br>
        </form>
        <p><a href="index.php">View Homepage</a></p>
    <?php
include('includes/footer.php');
?>