<?php
require('connectdb.php');
require('user-db.php');
require('entry-db.php');




ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$list_of_users = getAllUsers();


$user_id = $_POST['current_user'];
$list_of_expenses = getAllExpenses($user_id);
$list_of_payments = getAllPayments($user_id);
$list_of_net = getAllIncome($user_id);
$list_of_entries = getAllEntriesForUser($user_id);
$expenses_payments = $list_of_expenses + $list_of_payments;


?>


<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">

  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--
  Bootstrap is designed to be responsive to mobile.
  Mobile-first styles are part of the core framework.

  width=device-width sets the width of the page to follow the screen-width
  initial-scale=1 sets the initial zoom level when the page is first loaded
  -->

  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>Expense Tracker</title>

  <!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- you may also use W3's formats -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <!--
  Use a link tag to link an external resource.
  A rel (relationship) specifies relationship between the current document and the linked resource.
  -->

  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

  <!-- if you choose to download bootstrap and host it locally -->
  <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> -->

  <!-- include your CSS -->
  <!-- <link rel="stylesheet" href="custom.css" />  -->

</head>

<body>
<div class="container">
  <h1><?php
    echo 'Welcome ';
?> </h1>
<form method="POST" action="simpleform.php">
  <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Log out"/>
  </form>
  <form name="mainForm" action="simpleform.php" method="get">


</form>

<hr/>

<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered " style="float:left; width:25%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Month</th>
    <th width="25%">Year</th>

  </tr>
  </thead>

    <?php foreach ($list_of_entries as $entry): ?>
    <tr>
    <td><?php echo $entry['month']; ?></td>
    <td><?php echo $entry['year']; ?></td>
    </tr>
    <?php endforeach; ?>
      </table>
    <table class="w3-table w3-bordered " style="float:left; width:25%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Total expenses</th>


  </tr>
  </thead>

    <?php foreach ($list_of_expenses as $expense): ?>
    <tr>
    <td><?php echo $expense['rent'] + $expense['bills'] + $expense['transportation'] + $expense['leisure'] + $expense['foodBeverage']; ?></td>
    </tr>
    <?php endforeach; ?>


  </table>
  <table class="w3-table w3-bordered " style="float:left; width:25%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Total income</th>


  </tr>
  </thead>

    <?php foreach ($list_of_payments as $payment): ?>
    <tr>
    <td><?php echo $payment['wagesAndSalary'] + $payment['NonWageIncome']; ?></td>
    </tr>
    <?php endforeach; ?>


  </table>
  <table class="w3-table w3-bordered " style="width:25%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Net income</th>


  </tr>
  </thead>

    <?php foreach ($list_of_net as $net): ?>
    <tr>
    <td><?php echo $net['wagesAndSalary'] + $net['NonWageIncome'] - $net['rent'] - $net['bills'] - $net['transportation'] - $net['leisure'] - $net['foodBeverage'] ; ?></td>
    </tr>
    <?php endforeach; ?>


  </table>

<!-- </div>   -->


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->


    <body>
  <form method="POST" action="entryform.php">
  <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Create Entry"/>
  </form>
</body>


  </tr>







  </table>



</div>






</body>
</html>