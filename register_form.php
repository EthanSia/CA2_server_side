<?php

//register.php

/**
 * Start the session.
 */
session_start();

/**
 * Include ircmaxell's password_compat library.
 */
require 'libary-folder/password.php';

/**
 * Include our MySQL connection.
 */
require 'login_connect.php';
?>

<?php

// initializing variables
$username = "";
$email    = "";
$errors = array(); 
$error = ""; 


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'car_shop');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required");  }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (!preg_match('/[^@]+@[^@]+\.[a-zA-Z]{2,6}/', $email)) {
    array_push($errors, "Please enter a valid email like abc@gmail.com");
    }
  if (empty($password_1) ){ array_push($errors, "Password is required"); }
  if (!preg_match('/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[£!#€$%^&*]).{10,}/', $password_1)) {
    array_push($errors, "Password must be 10 digits which include at least one lowercase letter, one uppercase letter, one digit and one of the following characters (£!#€$%^&*) ");
    }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = password_hash($password_1, PASSWORD_BCRYPT, array("cost" => 12));//hash the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}


?>





<!-- the head section -->
 <div class="container">
<?php
include('includes/header.php');
?>

<h2>Register</h2> 
  <form method="post" action="register_form.php">
  	<div class="input-group">
  	  <label>Username</label>
  	  <input class="errors" type="text" name="username" title = "<?php echo $error; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" title = "<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1" title = "<?php echo $errors ?>">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2" title = "<?php echo $errors ?>">
  	</div>
    <?php
    include('errors.php');
    ?>
    <input type="submit" name="reg_user" value="Register">
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
<?php
include('includes/footer.php');
?>
