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
$list_of_incomes = getAllPayments($user_id);
$list_of_rents = getAllRents($user_id);
$list_of_bills = getAllBills($user_id);
$list_of_transportations = getAllTransportations($user_id);
$expenses_payments = $list_of_expenses + $list_of_payments;
$list_of_leisures = getAllLeisures($user_id);
$list_of_foodBeverage = getAllFoodBeverage($user_id);
$list_of_wagesAndSalary = getAllWagesAndSalary($user_id);
$list_of_nonWageIncome = getAllNonWageIncome($user_id);



if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update Expense")
    {  
     
       
      $expense_to_update = getExpense_byEntryID($_POST['expense_to_update']);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Month")
    {
      $list_of_net = getAllIncomeByMonth($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Year")
    {
      $list_of_net = getAllIncomeByYear($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Income")
    {
      $list_of_net = getAllIncomeByIncome($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Expenses")
    {
      $list_of_net = getAllIncomeByExpenses($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Net Income")
    {
      $list_of_net = getAllIncomeByNet($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Month (desc)")
    {
      $list_of_net = getAllIncomeByMonthDesc($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Year (desc)")
    {
      $list_of_net = getAllIncomeByYearDesc($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Income (desc)")
    {
      $list_of_net = getAllIncomeByIncomeDesc($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Expenses (desc)")
    {
      $list_of_net = getAllIncomeByExpensesDesc($user_id);

    }else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Net Income (desc)")
    {
      $list_of_net = getAllIncomeByNetDesc($user_id);

    }

  }
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


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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







  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="20%">Month
    </th>
    <th width="20%">Year
    </th>
    <th width="20%">Total income
    </th>
    <th width="20%">Total expenses
    </th>
    <th width="20%">Net income
    </th>


  </tr>
  </thead>
<h1> Summary by Month</h1>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Sort by:
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Month" name="btnAction"/>
    </form>
    </body></button>
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Year" name="btnAction"/>
    </form>
    </body></button>
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Income" name="btnAction"/>
    </form>
    </body></button>
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Expenses" name="btnAction"/>
    </form>
    </body></button>
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Net Income" name="btnAction"/>
    </form>
    </body> </button>
    </button>

    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Month (desc)" name="btnAction"/>
    </form>
    </body></button>
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Year (desc)" name="btnAction"/>
    </form>
    </body></button>
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Income (desc)" name="btnAction"/>
    </form>
    </body></button>
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Expenses (desc)" name="btnAction"/>
    </form>
    </body></button>
    <button class="dropdown-item" type="button"><body>
    <form method="POST" action="summaryform.php">
    <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Net Income (desc)" name="btnAction"/>
    </form>
    </body> </button>

</div>

    <?php foreach ($list_of_net as $net): ?>
    <tr>
    <td><?php echo $net['month']; ?></td>
    <td><?php echo $net['year']; ?></td>
    <td><?php echo $net['wagesAndSalary'] + $net['NonWageIncome']; ?></td>
    <td><?php echo $net['rent'] + $net['bills'] + $net['transportation'] + $net['leisure'] + $net['foodBeverage']; ?></td>
    <td><?php echo $net['wagesAndSalary'] + $net['NonWageIncome'] - $net['rent'] - $net['bills'] - $net['transportation'] - $net['leisure'] - $net['foodBeverage'] ; ?></td>
    </tr>
    <?php endforeach; ?>


  </table>


  
  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="12%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Rent</th>
    <th width="12%">Bills</th>
    <th width="12%">Transportation</th>
    <th width="12%">Leisure</th>
    <th width="12%">Food and Beverage</th>



  </tr>

  <hr>
  <h1> Expenses by Month </h1>
  <?php foreach ($list_of_expenses as $expense): ?>

  <tr>
    <td><?php echo $expense['month']; ?></td>
    <td><?php echo $expense['year']; ?></td>
    <td><?php echo $expense['rent']; ?></td>
    <td><?php echo $expense['bills']; ?></td>
    <td><?php echo $expense['transportation']; ?></td>
    <td><?php echo $expense['leisure']; ?></td>
    <td><?php echo $expense['foodBeverage']; ?></td>
  
    <?php endforeach; ?>

    </tr>
  </table>

  </hr>

  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="12%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Wages and Salary</th>
    <th width="12%">Non-Wage Income</th>



  </tr>
  <hr>
  <h1> Income by Month </h1>
  <?php foreach ($list_of_incomes as $income): ?>

  <tr>
    <td><?php echo $income['month']; ?></td>
    <td><?php echo $income['year']; ?></td>
    <td><?php echo $income['wagesAndSalary']; ?></td>
    <td><?php echo $income['NonWageIncome']; ?></td>

    <?php endforeach; ?>

    </tr>
  </table>

  </hr>

  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Utilities</th>
    <th width="12%">Base Rent</th>
    <th width="12%">Power</th>



  </tr>
  <hr>
  <h1> Rent Breakdown by Month </h1>
  <?php foreach ($list_of_rents as $rent): ?>

  <tr>
    <td><?php echo $rent['month']; ?></td>
    <td><?php echo $rent['year']; ?></td>
    <td><?php echo $rent['utilities']; ?></td>
    <td><?php echo $rent['baseRent']; ?></td>
    <td><?php echo $rent['power']; ?></td>

    <?php endforeach; ?>

    </tr>
  </table>

  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Insurance</th>
    <th width="12%">Phone</th>
    <th width="12%">Subscriptions</th>



  </tr>
  <hr>
  <h1> Bills Breakdown by Month </h1>
  <?php foreach ($list_of_bills as $bill): ?>

  <tr>
    <td><?php echo $bill['month']; ?></td>
    <td><?php echo $bill['year']; ?></td>
    <td><?php echo $bill['insurance']; ?></td>
    <td><?php echo $bill['phone']; ?></td>
    <td><?php echo $bill['subscriptions']; ?></td>

    <?php endforeach; ?>

    </tr>
  </table>

  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Insurance</th>
    <th width="12%">Phone</th>
    <th width="12%">Subscriptions</th>



  </tr>
  <hr>
  <h1> Transportation Breakdown by Month </h1>
  <?php foreach ($list_of_transportations as $transportation): ?>

  <tr>
    <td><?php echo $transportation['month']; ?></td>
    <td><?php echo $transportation['year']; ?></td>
    <td><?php echo $transportation['carPayment']; ?></td>
    <td><?php echo $transportation['gas']; ?></td>
    <td><?php echo $transportation['publicTransportation']; ?></td>

    <?php endforeach; ?>

    </tr>
  </table>

  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Gym</th>
    <th width="12%">Clothes</th>
    <th width="12%">Beauty</th>
    <th width="12%">Vacation</th>



  </tr>
  <hr>
  <h1> Leisure Breakdown by Month </h1>
  <?php foreach ($list_of_leisures as $leisure): ?>

  <tr>
    <td><?php echo $leisure['month']; ?></td>
    <td><?php echo $leisure['year']; ?></td>
    <td><?php echo $leisure['gym']; ?></td>
    <td><?php echo $leisure['clothes']; ?></td>
    <td><?php echo $leisure['beauty']; ?></td>
    <td><?php echo $leisure['vacation']; ?></td>

    <?php endforeach; ?>

    </tr>
  </table>

  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Eating Out</th>
    <th width="12%">Groceries</th>
    <th width="12%">Beverages</th>



  </tr>
  <hr>
  <h1> Food/Beverage Breakdown by Month </h1>
  <?php foreach ($list_of_foodBeverage as $foodBeverage): ?>

  <tr>
    <td><?php echo $foodBeverage['month']; ?></td>
    <td><?php echo $foodBeverage['year']; ?></td>
    <td><?php echo $foodBeverage['eatingOut']; ?></td>
    <td><?php echo $foodBeverage['groceries']; ?></td>
    <td><?php echo $foodBeverage['beverages']; ?></td>

    <?php endforeach; ?>

    </tr>
  </table>

  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Wage</th>
    <th width="12%">Tips</th>
    <th width="12%">Monthly Salary</th>



  </tr>
  <hr>
  <h1> Wages and Salary Breakdown by Month </h1>
  <?php foreach ($list_of_wagesAndSalary as $wagesAndSalary): ?>

  <tr>
    <td><?php echo $wagesAndSalary['month']; ?></td>
    <td><?php echo $wagesAndSalary['year']; ?></td>
    <td><?php echo $wagesAndSalary['wage']; ?></td>
    <td><?php echo $wagesAndSalary['tips']; ?></td>
    <td><?php echo $wagesAndSalary['monthlySalary']; ?></td>

    <?php endforeach; ?>

    </tr>
  </table>

  <table class="w3-table w3-bordered " style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">

    <th width="%">Month</th>
    <th width="12%">Year</th>
    <th width="12%">Investments</th>
    <th width="12%">Allowance</th>
    <th width="12%">Gifts</th>
    <th width="12%">Scholarships</th>



  </tr>
  <hr>
  <h1> Non-Wage Income Breakdown by Month </h1>
  <?php foreach ($list_of_nonWageIncome as $nonWageIncome): ?>

  <tr>
    <td><?php echo $nonWageIncome['month']; ?></td>
    <td><?php echo $nonWageIncome['year']; ?></td>
    <td><?php echo $nonWageIncome['investmentsTotal']; ?></td>
    <td><?php echo $nonWageIncome['allowanceTotal']; ?></td>
    <td><?php echo $nonWageIncome['giftsTotal']; ?></td>
    <td><?php echo $nonWageIncome['scholarshipsTotal']; ?></td>

    <?php endforeach; ?>

    </tr>
  </table>

  </hr>

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

 






  </table>


</div>

</body>
</html>
