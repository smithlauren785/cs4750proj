
<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function addEntry($entryID,  $UserID, $month, $year)
{
	// db handler
	global $db;
	
	$query = "insert into entry values(:entryID, :UserID, :month, :year)";

	// execute the sql

	$statement = $db->prepare($query);

	$statement->bindValue(':entryID', $entryID);
	$statement->bindValue(':month', $month);
	$statement->bindValue(':UserID', $UserID);
	$statement->bindValue(':year', $year);


	$statement->execute();

	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
}


function getAllEntriesForUser($UserID)
{
	global $db;
	$query = "select * from entry where UserID=:UserID";


// good: use a prepared stement 
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
    $statement->bindValue(':UserID', $UserID);
	$statement->execute();

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function getEntry_byEntryID($entryID)
{
	global $db;
	$query = "select * from entry where entryID = :entryID";

	$statement = $db->prepare($query);
	$statement->bindValue(':entryID', $entryID);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}

function updateEntry($entryID,$UserID, $month, $year)
{
	global $db;
	$query = "update entry set UserID=:UserID, month=:month, year=:year where entryID=:entryID";
	$statement = $db->prepare($query); 
	$statement->bindValue(':entryID', $entryID);
    $statement->bindValue(':UserID', $UserID);
	$statement->bindValue(':month', $month);
	$statement->bindValue(':year', $year);
	$statement->execute();
	$statement->closeCursor();
}

function deleteEntry($entryID)
{
	global $db;
	$query = "delete from entry where entryID=:entryID";
	$statement = $db->prepare($query); 
	$statement->bindValue(':entryID', $entryID);
	$statement->execute();
	$statement->closeCursor();
}
?>