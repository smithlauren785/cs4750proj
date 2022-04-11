<?php
require('connectdb.php');
require('user-db.php');




ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$list_of_users = getAllUsers();

$current_user = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {
      // If the button is clicked and its value is "Add" then call addUser() function

      addUser($_POST['FirstName'], $_POST['LastName'], $_POST['Email'], $_POST['Passwrd']);
      $list_of_users = getAllUsers();
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Choose User")
    {


      $current_user = getUser_byUserID($_POST['current_user']);

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
  <h1>Create a User</h1>  

  <form name="mainForm" action="simpleform.php" method="post">   
  <div class="row mb-3 mx-3">
    First Name:
    <input type="text" class="form-control" name="FirstName" required 
            value="<?php if ($current_user!=null) echo $current_user['FirstName'] ?>"
    />        
  </div>  
  <div class="row mb-3 mx-3">
    Last Name:
    <input type="text" class="form-control" name="LastName" 
            value="<?php if ($current_user!=null) echo $current_user['LastName'] ?>"
    /> 
  </div>  
  <div class="row mb-3 mx-3">
    Email:
    <input type="text" class="form-control" name="Email" required 
            value="<?php if ($current_user!=null) echo $current_user['Email'] ?>"
    />
  </div>
    <div class="row mb-3 mx-3">
    Password:
    <input type="text" class="form-control" name="Passwrd" required 
            value="<?php if ($current_user!=null) echo $current_user['Passwrd'] ?>"
    />
  </div>  
  <input type="submit" value="Add" name="btnAction" class="btn btn-dark" 
        title="insert a user" />  

</form>    

<hr/>
<h2>Or Choose Current User</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">First Name</th>        
    <th width="25%">Last Name</th>        
    <th width="20%">Email</th>
    <th width="20%">UserID</th>
    <th width="12%">Choose</th>
  </tr>
  </thead>
  <?php foreach ($list_of_users as $user): ?>
  <tr>
    <td><?php echo $user['FirstName']; ?></td>
    <td><?php echo $user['LastName']; ?></td>
    <td><?php echo $user['Email']; ?></td>
    <td><?php echo $user['UserID']; ?></td> 
    <td>
      <form action="passwordform.php" method="post">
        <input type="submit" value="Choose User" name="btnAction" class="btn btn-primary" />
        <input type="hidden" name="current_user" value="<?php echo $user['UserID'] ?>" />      
      </form>
    </td>
  
  </tr>
  <?php endforeach; ?>




  
  </table>
<!-- </div>   -->


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>   






</body>
</html>