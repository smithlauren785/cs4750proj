<?php
require('connectdb.php');
require('user-db.php');
#require('simpleform.php');


# Login form template from:
#https://www.w3docs.com/learn-html/html-form-templates.html


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$current_user = getUser_byUserID($_POST['current_user']);
$user_id = $_POST['current_user'];

function chooseUser($user_id, $Passwrd)
{
	global $db;
	$query = "select * from User where UserID = :UserID and Passwrd = PASSWORD(:Passwrd)";
	
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':UserID', $user_id);
	$statement->bindValue(':Passwrd', $Passwrd);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}


$verified_user = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Enter Password")
    {
      $verified_user = chooseUser($_POST['current_user'],$_POST['Passwrd']);
	  
    }

}
?>



<!DOCTYPE html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  </head>
<html>
  <body>
    <form action="passwordform.php" method="post">
<figure class="text-center">
      <h1>Login</h1>

      <div class="formcontainer">
      
      <div class="container">
      <h5>Enter password for :  <?php echo $current_user[1] ." ". $current_user[2]?></h5>
        <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
         <h5>Password: <input type="password" name="Passwrd" /></h5>
         <p><input type="submit" value="Enter Password" name="btnAction" class="btn btn-primary"/></p>      </div>

      </div>
    </form>

    <?php if($verified_user != null) : ?>

  <form method="POST" action="summaryform.php">
  <div class="container">
  <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
  <p><input type="submit" value="Go to Account" name="btnAction" class="btn btn-primary"/></p>
    </div>
  </form>

</figure>


  </body>
</html><?php endif; ?>






	




