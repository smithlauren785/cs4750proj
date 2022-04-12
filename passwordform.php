<?php
require('connectdb.php');
#require('simpleform.php');


# Login form template from:
#https://www.w3docs.com/learn-html/html-form-templates.html


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



<!DOCTYPE html>
<html>
  <head>
    <title>Simple login form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
      html, body {
      display: flex;
      justify-content: center;
      font-family: Roboto, Arial, sans-serif;
      font-size: 15px;
      }
      form {
      border: 5px solid #f1f1f1;
      }
      input[type=text], input[type=password] {
      width: 100%;
      padding: 16px 8px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
      }
      button {
      background-color: #8ebf42;
      color: white;
      padding: 14px 0;
      margin: 10px 0;
      border: none;
      cursor: grabbing;
      width: 100%;
      }
      h1 {
      text-align:center;
      fone-size:18;
      }
      button:hover {
      opacity: 0.8;
      }
      .formcontainer {
      text-align: left;
      margin: 24px 50px 12px;
      }
      .container {
      padding: 16px 0;
      text-align:left;
      }
      span.psw {
      float: right;
      padding-top: 0;
      padding-right: 15px;
      }
      /* Change styles for span on extra small screens */
      @media screen and (max-width: 300px) {
      span.psw {
      display: block;
      float: none;
      }
    </style>
  </head>
  <body>
    <form action="passwordform.php" method="post">
      <h1>Login</h1>
      <div class="formcontainer">
      
      <div class="container">
	  <p>Enter password for UserID:  <?php echo $user_id ?></p>
		<input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
 		<p>Password: <input type="text" name="Passwrd" /></p>
 		<p><input type="submit" value="Enter Password" name="btnAction" class="btn btn-primary"/></p>      </div>

      </div>
    </form>

	<?php if($verified_user != null) : ?>

  <form method="POST" action="summaryform.php">
  <div class="container">
  <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
  <button type="submit">Go to Account</button>
	</div>
  </form>




  </body>
</html><?php endif; ?>




	




