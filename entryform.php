<?php
require('connectdb.php');
require('entry-db.php');




$user_id = $_POST['current_user'];


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$list_of_entries = getAllEntriesForUser($user_id);
$entry_to_update = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {  

      addEntry($_POST['entryID'], $user_id, $_POST['month'], $_POST['year']);
      $list_of_entries = getAllEntriesForUser($user_id);
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {  
     
       
      $entry_to_update = getEntry_byEntryID($_POST['entry_to_update']);

    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete")
    {
      deleteEntry($_POST['entry_to_delete']);
      $list_of_entries = getAllEntriesForUser($user_id);
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update")
    {
      updateEntry($_POST['entryID'], $user_id, $_POST['month'], $_POST['year']);
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
       
</head>

<body>
<div class="container">
  <h1>Create an Entry</h1>  

  <form name="mainForm" action="entryform.php" method="post">   
  <div class="row mb-3 mx-3">
    EntryID:
    <input type="number" class="form-control" name="entryID" required 
            value="<?php if ($entry_to_update!=null) echo $entry_to_update['entryID'] ?>"
    />    
  </div> 
  <div class="row mb-3 mx-3">
    UserID:
    <input type="number" class="form-control" name="UserID" required 
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
</form>    

<hr/>
<h2>List of Entries</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">EntryID</th>        
    <th width="25%">Month</th>        
    <th width="18%">Year</th>
    <th width="18%">UserID</th>
    <th width="10%">Update ?</th>
    <th width="10%">Delete ?</th> 
  </tr>
  </thead>
  <?php foreach ($list_of_entries as $entry): ?>
  <tr>
    <td><?php echo $entry['entryID']; ?></td>
    <td><?php echo $entry['month']; ?></td>
    <td><?php echo $entry['year']; ?></td>
    <td><?php echo $entry['UserID']; ?></td> 
    <td>
      <form action="entryform.php" method="post">
        <input type="submit" value="Update" name="btnAction" class="btn btn-primary" />
        <input type="hidden" name="entry_to_update" value="<?php echo $entry['EntryID'] ?>" />      
      </form>
    </td>
    <td>
    <form action="entryform.php" method="post">
        <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" />
        <input type="hidden" name="entry_to_delete" value="<?php echo $entry['EntryID'] ?>" />      
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