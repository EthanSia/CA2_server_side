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

<?php
// define variables and set to empty values
$nameErr = $modelErr = $descriptionErr = $priceErr =$type_of_fuelErr = $imageErr= "";
$name = $model = $description = $price = $type_of_fuel = $image = "";
$rexSafety = "/^[^<,\"@/{}()*$%?=>:|;#]*$/i";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["model"])) {
    $modelErr = "Model is required";
  } else {
    $model = test_input($_POST["model"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["website"])) {
    $website = "";
  } else {
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL";
    }
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!-- the head section -->
 <div class="container">
<?php
include('includes/header.php');
?>
        <h1>Add Record</h1>
        <form action="add_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>model:</label>
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
            <input type="input" name="name" required>
            <br>

            
            <br>
            <label>Model:</label>
            <input type="input" name="model" required>
            <br>

            <label>Description:</label>
            <input type="input" name="description" required>
            <br>

            <label>List Price:</label>
            <input type="input" name="price">
            <br>"Price must be double"<br>
            <br>    
            
            <label>Type of fuel:</label>
            <input type="input" name="type_of_fuel" required>
            <br>
            
            <label>Image:</label>
            <input type="file" name="image" accept="image/*" />
            <br>
            
            <label>&nbsp;</label>
            <input type="submit" value="Add Record">
            <br>
            </form>
        </form>
        <p><a href="index.php">View Homepage</a></p>
    <?php
include('includes/footer.php');
?>