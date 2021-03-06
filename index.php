<?php
require_once('database.php');

// Get category ID
if (!isset($category_id)) {
$category_id = filter_input(INPUT_GET, 'category_id', 
FILTER_VALIDATE_INT);
if ($category_id == NULL || $category_id == FALSE) {
$category_id = 1;
}
}

// Get name for current category
$queryCategory = "SELECT * FROM categories
WHERE categoryID = :category_id";
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$statement1->closeCursor();
$category_name = $category['categoryName'];

// Get all categories
$queryAllCategories = 'SELECT * FROM categories
ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();

// Get records for selected category
$queryRecords = "SELECT * FROM records
WHERE categoryID = :category_id
ORDER BY recordID";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$records = $statement3->fetchAll();
$statement3->closeCursor();

// Get fuel ID
if (!isset($fuel_id)) {
    $fuel_id = filter_input(INPUT_GET, 'fuel_id', 
    FILTER_VALIDATE_INT);
    if ($fuel_id == NULL || $fuel_id == FALSE) {
    $fuel_id = 1;
    }
    }
    
    // Get name for current fuel
    $queryFuel = "SELECT * FROM fuel
    WHERE fuelID = :fuel_id";
    $statement1 = $db->prepare($queryFuel);
    $statement1->bindValue(':fuel_id', $fuel_id);
    $statement1->execute();
    $fuel = $statement1->fetch();
    $statement1->closeCursor();
    $fuel_name = $fuel['fuelName'];

// Get all fuels
$queryAllFuels = 'SELECT * FROM fuel
ORDER BY fuelID';
$statement2 = $db->prepare($queryAllFuels);
$statement2->execute();
$fuels = $statement2->fetchAll();
$statement2->closeCursor();



// Get records for selected fuel
$queryRecords = "SELECT * FROM records
WHERE fuelID = :fuel_id
ORDER BY recordID";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':fuel_id', $fuel_id);
$statement3->execute();
$records = $statement3->fetchAll();
$statement3->closeCursor();

?>
<div class="container">
<?php
include('includes/header.php');
?>


<h1>Record List</h1>

<aside>
<!-- display a list of categories -->
<h2>Categories</h2>
<nav>
<ul>
<?php foreach ($categories as $category) : ?>
<li><a href=".?category_id=<?php echo $category['categoryID']; ?>">
<?php echo $category['categoryName']; ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</nav>          
</aside>

<aside>
<!-- display a list of fuels -->
<h2>Fuels</h2>
<nav>
<ul>
<?php foreach ($fuels as $fuel) : ?>
<li><a href=".?fuel_id=<?php echo $fuel['fuelID']; ?>">
<?php echo $fuel['fuelName']; ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</nav>          
</aside>

<aside>
<!-- display a list of fuels -->
<form action = "filter_search.php" method="get">
<h2>Fuels</h2>
<nav>
<ul>
<?php foreach ($fuels as $fuel) : ?>
<li><input type ="checkbox" name="fuels[]"  value =".?fuel_id=<?php echo $fuel['fuelID']; ?>">
<?php echo $fuel['fuelName']; ?>
<?php endforeach; ?>

</ul>
<input type="submit" value="submit">
</nav>          
</aside>

</form>



<section>
<!-- display a table of records -->
<h2><?php echo $category_name; ?></h2>
<h2><?php echo $fuel_name; ?></h2>
<h1>This is a normal h1</h1>
<table>
<tr>
<th>Image</th>
<th>Name</th>
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
<td class="left"><?php echo $record['description']; ?></td>
<td class="right"><?php echo $record['price']; ?></td>
<td class="left"><?php echo $record['type_of_fuel']; ?></td>
<td><form action="delete_record.php" method="post"
id="delete_record_form">
<input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
<input type="hidden" name="fuel_id"
value="<?php echo $record['fuelID']; ?>">
<input type="hidden" name="category_id"
value="<?php echo $record['categoryID']; ?>">
<input type="submit" value="Delete">
</form></td>
<td><form action="edit_record_form.php" method="post"
id="delete_record_form">
<input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
<input type="hidden" name="fuel_id"
value="<?php echo $record['fuelID']; ?>">
<input type="hidden" name="category_id"
value="<?php echo $record['categoryID']; ?>">
<input type="submit" value="Edit">
</form></td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="add_record_form.php">Add Record</a></p>
<p><a href="category_list.php">Manage Categories</a></p>
<p><a href="fuel_list.php">Manage Fuels</a></p>
</section>
<?php
include('includes/footer.php');
?>