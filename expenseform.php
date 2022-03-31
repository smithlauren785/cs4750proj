<?php
require('connectdb.php');
require('expense-db.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);





$entryID = $_POST['entryID'];




$list_of_expenses = getAllExpenses();
$expense_to_update = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {  
      // If the button is clicked and its value is "Add" then call addUser() function

      addExpense($_POST['rent'], $_POST['bills'], $_POST['transportation'], $_POST['foodBeverage'], $_POST['leisure'], $entryID);
      $list_of_expenses = getAllExpenses();
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {  
     
       
      $expense_to_update = getExpense_byEntryID($_POST['expense_to_update']);

    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete")
    {
      deleteExpense($_POST['expense_to_delete']);
      $list_of_expenses = getAllExpenses();
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update")
    {
      updateExpense($_POST['rent'], $_POST['bills'], $_POST['transportation'], $_POST['foodBeverage'], $_POST['leisure'], $entryID);
      $list_of_expenses = getAllExpenses();
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
  <h1>Enter Expense Totals</h1>  

  <form name="mainForm" action="expenseform.php" method="post">   
  <div class="row mb-3 mx-3">
    Rent:
    <input type="number" class="form-control" name="rent" required 
            value="<?php if ($expense_to_update!=null) echo $expense_to_update['rent'] ?>"
    />    
  </div>  
  <div class="row mb-3 mx-3">
    Bills:
    <input type="number" class="form-control" name="bills" required 
            value="<?php if ($expense_to_update!=null) echo $expense_to_update['bills'] ?>"
    />  
  </div>  
  <div class="row mb-3 mx-3">
    Transportation:
    <input type="number" class="form-control" name="transportation" required 
            value="<?php if ($expense_to_update!=null) echo $expense_to_update['transportation'] ?>"
    />  
  </div>  
  <div class="row mb-3 mx-3">
    Leisure:
    <input type="number" class="form-control" name="leisure" required 
            value="<?php if ($expense_to_update!=null) echo $expense_to_update['leisure'] ?>"
    />  
  </div> 
  <div class="row mb-3 mx-3">
    Food/Beverage:
    <input type="number" class="form-control" name="foodBeverage" required 
            value="<?php if ($expense_to_update!=null) echo $expense_to_update['foodBeverage'] ?>"
    />  
  </div>  
  <div class="row mb-3 mx-3">
    EntryID:
    <input type="number" class="form-control" name="entryID" required 
            value="<?php echo $expense_to_update['entryID'] ?>"
    />  
  </div>   
  <input type="submit" value="Add" name="btnAction" class="btn btn-dark" 
        title="insert an expense" />  
  <input type="submit" value="Confirm update" name="btnAction" class="btn btn-dark" 
        title="confirm update an expense" />  
</form>    

<hr/>
<h2>List of Expenses</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">EntryID</th>        
    <th width="10%">Bills</th>        
    <th width="10%">Food/Beverage</th>
    <th width="10%">Leisure</th>
    <th width="10%">Rent</th>
    <th width="10%">Transportation</th>
    <th width="10%">Update ?</th>
    <th width="10">Delete ?</th> 
  </tr>
  </thead>
  <?php foreach ($list_of_expenses as $expense): ?>
  <tr>
    <td><?php echo $expense['entryID']; ?></td>
    <td><?php echo $expense['bills']; ?></td>
    <td><?php echo $expense['foodBeverage']; ?></td>
    <td><?php echo $expense['leisure']; ?></td> 
    <td><?php echo $expense['rent']; ?></td> 
    <td><?php echo $expense['transportation']; ?></td> 
    <td>
      <form action="expenseform.php" method="post">
        <input type="submit" value="Update" name="btnAction" class="btn btn-primary" />
        <input type="hidden" name="expense_to_update" value="<?php echo $expense['entryID'] ?>" />      
      </form>
    </td>
    <td>
    <form action="expenseform.php" method="post">
        <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" />
        <input type="hidden" name="expense_to_delete" value="<?php echo $expense['entryID'] ?>" />      
      </form>
    </td> 
  </tr>
  <?php endforeach; ?>
<!-- </div>   -->


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>