<?php

/**
 * Start the session.
 */
session_start();

/**
 * Check if the user is logged in.
 */
if(!isset($_SESSION['user_id'])==1 || !isset($_SESSION['logged_in'])){
    //User not logged in. Redirect them back to the login.php page.
    header('Location: login.php');
    exit;
}


/**
 * Print out something that only logged in users can see.
 */

echo 'Congratulations! You are logged in!';

    require_once('database.php');

    // Get all users$users
    $query = 'SELECT * FROM users
              ORDER BY id';
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
?>
<!-- the head section -->
<div class="container">
<?php
include('includes/header.php');
?>
    <h1>User List</h1>
    <table>
        <tr>
            <th>User Name</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($users as $user) : ?>
        <tr>
            <td><?php echo $user['username']; ?></td>
            <td>
                <form action="delete_users.php" method="post"
                      id="delete_product_form">
                    <input type="hidden" name="user_id"
                           value="<?php echo $user['id']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>

    <br>
    <p><a href="index.php">Homepage</a></p>

    <?php
include('includes/footer.php');
?>