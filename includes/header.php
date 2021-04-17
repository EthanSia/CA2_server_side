<!-- the head section -->

<head>
<title>Toyota</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css">
<script language="JavaScript" src="scripts/gen_validatorv31.js" type="text/javascript"></script>
</head>

<!-- the body section -->
<body>
<header><h1>Toyota</h1>
<div class="topnav">
  <a class="active" href="index.php">Home</a>

  <?php
  if(isset($_SESSION['user_id'])=== 1)
  {
  ?>
  <a href="add_car_form.php">Add Cars</a>
  <a href="model_list.php">Manage Models</a>
  <a href="fuel_list.php">Manage Fuels</a>
  <?php 
  }
  ?>

  <a href="contact.php">Contact</a>
  <?php
  if(isset($_SESSION['user_id']) > 0)
  {
  ?>
      <a href="logout.php">Log Out</a>
  <?php 
  }
  ?>
</div>
</header>