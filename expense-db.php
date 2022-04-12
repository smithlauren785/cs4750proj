<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



function addExpense($rent, $bills, $transportation, $leisure, $foodBeverage, $entryID)
{
	// db handler
	global $db;

	$query = "insert into Expenses values( :rent, :bills, :transportation, :leisure, :foodBeverage, :entryID)";

	// execute the sql

	$statement = $db->prepare($query);


	$statement->bindValue(':rent', $rent);
	$statement->bindValue(':bills', $bills);
	$statement->bindValue(':transportation', $transportation);
	$statement->bindValue(':leisure', $leisure);
	$statement->bindValue(':foodBeverage', $foodBeverage);
	$statement->bindValue(':entryID', $entryID);




	$statement->execute();

	// release; free the connection to the server so other sql statements may be issued
	$statement->closeCursor();
}



?>