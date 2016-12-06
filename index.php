<?php

// The code in this file was provided by Richard Plotka

session_start();
include "resources/php/config.php";

// Connect to the database
try {
  $host = $config["DB_HOST"];
  $dbname = $config["DB_NAME"];
  $user = $config["DB_USERNAME"];
  $pass = $config["DB_PASSWORD"];
  $dbconn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);
}
catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

// Check login
if (isset($_POST['login']) && $_POST['login'] == 'Login') {

// check user with the salt
  $salt_stmt = $dbconn->prepare('SELECT salt FROM users WHERE username=:username');
  $salt_stmt->execute(array(':username' => $_POST['username']));
  $res = $salt_stmt->fetch();
  $salt = ($res) ? $res['salt'] : '';
  $salted = hash('sha256', $salt . $_POST['pass']);

//get user from the DB
  $login_stmt = $dbconn->prepare('Select username, userid FROM users WHERE username=:username AND password=:pass');
  $login_stmt->execute(array(':username' => $_POST['username'], ':pass' => $salted));

  if ($user = $login_stmt->fetch()) { //set session variables
    $_SESSION['username'] = $user['username'];
    $_SESSION['userid'] = $user['userid'];
  } else {
    $err = 'Incorrect username or password.';
  }
}

?>

<!doctype html>
<html>
<head>
  <title>Login</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="resources/css/main.css">
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Collection Tracker</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    </div>
  </div>
</nav>

  <?php 
    if (isset($_SESSION['username'])){ //if the sesion has already been set navigate to the main page
      header("Location: main_page.php");
      exit;
    } else { //otherwise display form
  ?>
  <div id=login class="text-center">
    <h1>Login</h1>
    <?php if (isset($err)) echo "<p>$err</p>" ?>
    <form method="post" action="index.php">
      <label for="username">Username: </label>
      <input type="text" name="username" />
      <label for="pass">Password: </label>
      <input type="password" name="pass" /><br><br>
      <input name="login" type="submit" value="Login" />
    </form>
    <p>Dont have an account? Register <a href="register.php">here</a>.</p>
    <?php } ?>
  </div>

  <footer class="container-fluid text-center">
    <!-- <p>Footer Text</p> -->
  </footer>
</body>
</html>
