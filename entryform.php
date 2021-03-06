
<?php
require('connectdb.php');
require('entry-db.php');



$user_id = $_POST['current_user'];



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$list_of_entries = getAllEntriesForUser($user_id);
$entry_to_update = null;
$entry_to_edit = null;
$entryID = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {

      addEntry($user_id, $_POST['month'], $_POST['year']);
      $list_of_entries = getAllEntriesForUser($user_id);
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {

      $entry_to_update = getEntry_byName($_POST['entry_to_update']);

    }
  
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Edit Expenses")
  {

    $entry_to_edit = getEntry_byName($_POST['entry_to_edit']);
    $entryID = $entry_to_edit['entryID'];

  }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete")
    {
      deleteEntry($_POST['entry_to_delete']);
      $list_of_entries = getAllEntriesForUser($user_id);
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update")
    {
      updateEntry($_POST['entry_to_update'], $user_id, $_POST['month'], $_POST['year']);
      $list_of_entries = getAllEntriesForUser($user_id);
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
       <form method="POST" action="summaryform.php">
  <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Go to account"/>
  </form>
</head>

<body>
<div class="container">
  <h1>Create an Entry</h1>  

  <form name="mainForm" action="entryform.php" method="post">   
  <div class="row mb-3 mx-3">
    UserID:
    <input type="number" class="form-control" name="current_user" required 
        value= "<?php echo $user_id ?>"
    />
  </div>   
  <div class="row mb-3 mx-3">
    Month:
    <input type="number" class="form-control" name="month" required 
            value="<?php if ($entry_to_update!=null) echo $entry_to_update['month'] ?>"
    />  
  </div>  
  <div class="row mb-3 mx-3">
    Year:
    <input type="number" class="form-control" name="year" required 
            value="<?php if ($entry_to_update!=null) echo $entry_to_update['year'] ?>"
    />
  </div>
  <input type="submit" value="Add" name="btnAction" class="btn btn-dark" 
        title="insert an entry" /> 
  <input type="submit" value="Confirm update" name="btnAction" class="btn btn-dark" 
        title="confirm update an entry" />  
  <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
  <input type="text" value="<?= $entry_to_update['entryID']?>" style="display:none" name="entry_to_update" />

</form>    

<hr/>
<h2>List of Entries</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Month</th>        
    <th width="18%">Year</th>
    <th width="18%">UserID</th>
    <th width="10%">Update</th>
    <th width="10%">Delete</th> 
    <th width="10%">Edit Expenses</th> 

  </tr>
  </thead>
  <?php foreach ($list_of_entries as $entry): ?>
 <tr>
    <td><?php echo $entry['month']; ?></td>
    <td><?php echo $entry['year']; ?></td>
    <td><?php echo $entry['UserID']; ?></td>
    <td>

      <form action="entryform.php" method="post">
        <input type="submit" value="Update" name="btnAction" class="btn btn-primary" />
        <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
        <input type="hidden" name="entry_to_update" value="<?php echo $entry['entryID'] ?>" />      
      </form>
    </td>
    <td>
    <form action="entryform.php" method="post">
        <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" />
        <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
        <input type="hidden" name="entry_to_delete" value="<?php echo $entry['entryID'] ?>" />      
      </form>
    </td> 
    <td>
    <form action="entryform.php" method="post">
        <input type="submit" value="Edit Expenses" name="btnAction" class="btn btn-secondary" />
        <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
        <input type="hidden" name="entry_to_edit" value="<?php echo $entry['entryID'] ?>" />      
      </form>
    </td> 
  </tr>
  <?php endforeach; ?>

  
  </table>







  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>

<?php





$expense_to_update = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Submit Expenses And Income")
  {  
    addExpense($_POST['rent'], $_POST['bills'], $_POST['transportation'], $_POST['leisure'], $_POST['foodBeverage'], $_POST['entryID']);
    addPayment($_POST['wagesAndSalary'], $_POST['NonWageIncome'], $_POST['entryID']);
    addRent($_POST['utilities'], $_POST['baseRent'], $_POST['power'], $_POST['entryID']);
    addBills($_POST['insurance'], $_POST['phone'], $_POST['subscriptions'], $_POST['entryID']);
    addTransportation($_POST['carPayment'], $_POST['gas'], $_POST['publicTransportation'], $_POST['airplaneFees'], $_POST['rideshare'], $_POST['entryID']);
    addLeisure($_POST['gym'], $_POST['clothes'], $_POST['beauty'], $_POST['vacation'], $_POST['entryID']);
    addFoodBeverage($_POST['eatingOut'], $_POST['groceries'], $_POST['beverages'], $_POST['entryID']);
    addWagesAndSalary($_POST['wage'], $_POST['tips'], $_POST['monthlySalary'], $_POST['entryID']);
    addNonWageIncome($_POST['investmentsTotal'], $_POST['allowanceTotal'], $_POST['giftsTotal'], $_POST['scholarshipsTotal'], $_POST['entryID']);

  }

    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update Expense")
    {  
     
      $expense_to_update = getExpense_byEntryID($expense_to_update['entryID']);

    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete Expense")
    {
      deleteExpense($_POST['expense_to_delete']);
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update expense")
    {
      updateExpense($_POST['rent'], $_POST['bills'], $_POST['transportation'], $_POST['foodBeverage'], $_POST['leisure'], $entryID);
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
  <h1>Enter Expense Totals for <?php if($entry_to_edit != null) : echo $entry_to_edit['month'], "/", $entry_to_edit['year']?> <?php endif; ?> </h1>  

  <form name="mainForm" action="entryform.php" method="post">   
  <div class="row mb-3 mx-3">
    Rent:
    <input type="number" class="form-control" name="rent" required 
            value="0"
    />    
  </div>  
  <div class="row mb-3 mx-3">
    Bills:
    <input type="number" class="form-control" name="bills" required 
            value="0"
    />  
  </div>  
  <div class="row mb-3 mx-3">
    Transportation:
    <input type="number" class="form-control" name="transportation" required 
            value="0"
    />  
  </div>  
  <div class="row mb-3 mx-3">
    Leisure:
    <input type="number" class="form-control" name="leisure" required 
            value="0"
    />  
  </div> 
  <div class="row mb-3 mx-3">
    Food/Beverage:
    <input type="number" class="form-control" name="foodBeverage" required 
            value="0"
    />  
  </div>  
  <div class="row mb-3 mx-3">
    EntryID:
    <input type="number" class="form-control" name="entryID" required 
            value="<?php echo $entry_to_edit['entryID'] ?>"
    />  
  </div>   
 

  <h1>Enter Payment Totals for <?php if($entry_to_edit != null) : echo $entry_to_edit['month'], "/", $entry_to_edit['year']?> <?php endif; ?> </h1>  

  <div class="row mb-3 mx-3">
    Wages and Salary:
    <input type="number" class="form-control" name="wagesAndSalary" value = "0" required     />    
  </div>  
  <div class="row mb-3 mx-3">
    Non-Wage Income:
    <input type="number" class="form-control" name="NonWageIncome" value = "0" required     />  
  </div>   
  <div class="row mb-3 mx-3">
    EntryID:
    <input type="number" class="form-control" name="entryID"  required 
            value="<?php echo $entry_to_edit['entryID']?>"
    />  
  </div>   
 


<hr/>

<!-- </div>   -->

  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>




<!-- template found at https://bootsnipp.com/snippets/PEx --> 

<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container" style="width:60%">
  <h1>Expense and Income Breakdown</h1>
  <table class="table">
    <thead>
      <tr>
        <th>
          <h3>Expenses</h3>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Rent</td>
        <td>Utilities</td>
        <td>
          <input type="number" class="form-control" name="utilities" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Base Rent</td>
        <td>
          <input type="number" class="form-control" name="baseRent" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Power</td>
        <td>
          <input type="number" class="form-control" name="power" style="width: 45px; padding: 1px" value="0"> 
        </td>
      </tr>
      <tr>
        <td>Bills</td>
        <td>Insurance</td>
        <td>
          <input type="number" class="form-control" name="insurance" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Phone</td>
        <td>
          <input type="number" class="form-control" name="phone" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Subscriptions</td>
        <td>
          <input type="number" class="form-control" name="subscriptions" style="width: 45px; padding: 1px" value="0"> 
        </td>
      </tr>
      <tr>
        <td>Transportation</td>
        <td>Car Payment</td>
        <td>
          <input type="number" class="form-control" name="carPayment" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Gas</td>
        <td>
          <input type="number" class="form-control" name="gas" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Public Transportation</td>
        <td>
          <input type="number" class="form-control" name="publicTransportation" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Airplane Fees</td>
        <td>
          <input type="number" class="form-control" name="airplaneFees" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Rideshare</td>
        <td>
          <input type="number" class="form-control" name="rideshare" style="width: 45px; padding: 1px" value="0"> 
        </td>
      </tr>
      <tr>
        <td>Leisure</td>
        <td>Gym</td>
        <td>
          <input type="number" class="form-control" name="gym" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Clothes</td>
        <td>
          <input type="number" class="form-control" name="clothes" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Beauty</td>
        <td>
          <input type="number" class="form-control" name="beauty" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Vacation</td>
        <td>
          <input type="number" class="form-control" name="vacation" style="width: 45px; padding: 1px" value="0"> 
        </td>
      </tr>
      <tr>
        <td>Food/Beverage</td>
        <td>Eating Out</td>
        <td>
          <input type="number" class="form-control" name="eatingOut" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Groceries</td>
        <td>
          <input type="number" class="form-control" name="groceries" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Beverages</td>
        <td>
          <input type="number" class="form-control" name="beverages" style="width: 45px; padding: 1px" value="0"> 
        </td>
      </tr>
    </tbody>
  </table>
  <table class="table">
    <thead>
      <tr>
        <th>
          <h3>Income</h3>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Wages and Salary</td>
        <td>Wage</td>
        <td>
          <input type="number" class="form-control" name="wage" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Tips</td>
        <td>
          <input type="number" class="form-control" name="tips" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Monthly Salary</td>
        <td>
          <input type="number" class="form-control" name="monthlySalary" style="width: 45px; padding: 1px" value="0"> 
        </td>
      </tr>
      <tr>
        <td>Non-Wage Income</td>
        <td>Investments</td>
        <td>
          <input type="number" class="form-control" name="investmentsTotal" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Allowance</td>
        <td>
          <input type="number" class="form-control" name="allowanceTotal" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Gifts</td>
        <td>
          <input type="number" class="form-control" name="giftsTotal" style="width: 45px; padding: 1px" value="0"> 
        </td>
        <td>Scholarships</td>
        <td>
          <input type="number" class="form-control" name="scholarshipsTotal" style="width: 45px; padding: 1px" value="0"> 
        </td>
      </tr>
    </tbody>
  </table>
  
  <input type="submit" value="Submit Expenses And Income" name="btnAction" class="btn btn-block btn-success btn-large" />
  <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
</div>


</form>  
