<?php 

  session_start();
  if (!isset($_SESSION['userid'])) { //if the session var has not been set redirect to login
    header("Location: index.php");
  } else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Collection Tracker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
      <ul class="nav navbar-nav">
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="resources/php/logout.php";><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-sm-12 text-justify">
      <h1 class="text-center">Welcome</h1>
      <p class="text-center">This is a collection tracking application that allows you to create a collection of items and create a database that stores the information.</p>     
    </div>

    <div id="listGen" class="listGen generator">
      <h3>Click me to create a new list</h3>
    </div>

    <div id="trashCan" class="ui-widget-header droppable">
      <h3>Drop object here to delete it</h3>
    </div>
    <form action="resources/php/store.php" method="post" id="mainContainer">
      <input type="submit" name="submit" value="Store to DB" />
    </form>
  </div>
</div>

<footer class="container-fluid text-center">
  <!-- <p>Footer Text</p> -->
</footer>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="resources/js/main_page.js"></script>
</body>
</html>

<?php } ?>

