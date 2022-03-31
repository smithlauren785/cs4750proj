<?php
require('connectdb.php');
#require('simpleform.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$user_id = $_POST['current_user'];

function chooseUser($Passwrd, $user_id)
{
	global $db;
	$query = "select * from User where UserID=:UserID and Passwrd:=Passwrd";
	$statement = $db->prepare($query);
	$statement->bindValue(':UserID', $user_id); 
	$statement->bindValue(':Passwrd', $Passwrd);
	$statement->execute();
	$statement->closeCursor();
}




if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Enter Password")
    {
      chooseUser($_POST['Passwrd'], $_POST['current_user']);
    }

}
?>


<html>
<body>


<form action="entryform.php" method="post">
 <p>Enter password for UserID:  <?php echo $user_id ?></p>
 <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
 <p>Password: <input type="text" name="Passwrd" /></p>
 <p><input type="submit" /></p>
</form>



</body>
</html>
