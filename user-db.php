<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function addUser($FirstName, $LastName, $Email, $Passwrd)
{
	
	// db handler
	global $db;
	
	$query = "insert into User (FirstName, LastName, Email, Passwrd) values(:FirstName, :LastName, :Email, :Passwrd)";

	// hash password
	//$hash = password_hash($Passwrd, PASSWORD_DEFAULT);

	// execute the sql

	$statement = $db->prepare($query);

	$statement->bindValue(':FirstName', $FirstName);
	$statement->bindValue(':LastName', $LastName);
	$statement->bindValue(':Email', $Email);
	$statement->bindValue(':Passwrd', $Passwrd);


	$statement->execute();

	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
}

function getAllUsers()
{
	global $db;
	$query = "select * from User";


// good: use a prepared stement 
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->execute();

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function getUser_byUserID($UserID)
{
	global $db;
	$query = "select * from User where UserID = :UserID";
	// "select * from friends where UserID = $UserID";
	
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':UserID', $UserID);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}


function deleteUser($UserID)
{
	global $db;
	$query = "delete from User where UserID=:UserID";
	$statement = $db->prepare($query); 
	$statement->bindValue(':UserID', $UserID);
	$statement->execute();
	$statement->closeCursor();
}

?>