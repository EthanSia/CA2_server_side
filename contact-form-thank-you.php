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
?>
<div class="container">
<?php
include('includes/header.php');
?>
<h1>Thank you!</h1>
Thank you for submitting the form. We will contact you soon!
<?php
include('includes/footer.php');
?>
