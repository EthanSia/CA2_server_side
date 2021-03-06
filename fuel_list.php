<?php
    require_once('database.php');

    // Get all fuels$_SESSION['fuels']
    $query = 'SELECT * FROM fuel
              ORDER BY fuelID';
    $statement = $db->prepare($query);
    $statement->execute();
    $_SESSION['fuels'] = $statement->fetchAll();
    $statement->closeCursor();
?>
<!-- the head section -->
<div class="container">
<?php
include('includes/header.php');
?>
    <h1>Fuel List</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($_SESSION['fuels'] as $fuel) : ?>
        <tr>
            <td><?php echo $fuel['fuelName']; ?></td>
            <td>
                <form action="delete_fuel.php" method="post"
                      id="delete_product_form">
                    <input type="hidden" name="fuel_id"
                           value="<?php echo $fuel['fuelID']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>

    <h2>Add Fuel Type</h2>
    <form action="add_fuel.php" method="post"
          id="add_fuel_form">

        <label>Name:</label>
        <input type="input" name="name">
        <input id="add_fuel_button" type="submit" value="Add">
    </form>
    <br>
    <p><a href="index.php">Homepage</a></p>

    <?php
include('includes/footer.php');
?>