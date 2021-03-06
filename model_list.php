<?php
    require_once('database.php');

    // Get all models
    $query = 'SELECT * FROM models
              ORDER BY modelID';
    $statement = $db->prepare($query);
    $statement->execute();
    $models = $statement->fetchAll();
    $statement->closeCursor();
?>
<!-- the head section -->
<div class="container">
<?php
include('includes/header.php');
?>
    <h1>model List</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($models as $model) : ?>
        <tr>
            <td><?php echo $model['modelName']; ?></td>
            <td>
                <form action="delete_model.php" method="post"
                      id="delete_product_form">
                    <input type="hidden" name="model_id"
                           value="<?php echo $model['modelID']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>

    <h2>Add model</h2>
    <form action="add_model.php" method="post"
          id="add_model_form">

        <label>Name:</label>
        <input type="input" name="name">
        <input id="add_model_button" type="submit" value="Add">
    </form>
    <br>
    <p><a href="index.php">Homepage</a></p>

    <?php
include('includes/footer.php');
?>