<?php
require('connectdb.php');
#require('simpleform.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$user_id = $_POST['current_user'];

function chooseUser($user_id, $Passwrd)
{
	global $db;
	$query = "select * from User where UserID = :UserID and Passwrd = :Passwrd";
	
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


<html>
<body>


<form action="passwordform.php" method="post">
 <p>Enter password for UserID:  <?php echo $user_id ?></p>
 <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
 <p>Password: <input type="text" name="Passwrd" /></p>
 <p><input type="submit" value="Enter Password" name="btnAction" class="btn btn-primary"/></p>
</form>


<?php if($verified_user != null) : ?>
	<html>
<body>
  <form method="POST" action="entryform.php">
  <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
    <input type="submit" value="Create Entry"/>
  </form>
</body>
</html><?php endif; ?>




</body>
</html>
