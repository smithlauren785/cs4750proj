<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



function addExpense($rent, $bills, $transportation, $leisure, $foodBeverage, $entryID)
{
	// db handler
	global $db;

	$query = "insert into Expenses (rent, bills, transportation, leisure, foodBeverage, entryID) values(:rent, :bills, :transportation, :leisure, :foodBeverage, :entryID)";

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


function getAllExpenses($entryID)
{
	global $db;
	$query = "select * from Expenses where entryID=:entryID";


// good: use a prepared stement
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':entryID', $entryID);
	$statement->execute();

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();

	$statement->closeCursor();

	return $results;
}

function getExpense_byEntryID($entryID)
{
	global $db;
	$query = "select * from Expenses where entryID = :entryID";

	$statement = $db->prepare($query);
	$statement->bindValue(':entryID', $entryID);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();

	$statement->closeCursor();

	return $results;
}

function updateExpense($rent, $bills, $transportation, $leisure, $foodBeverage, $entryID)
{
	global $db;
	$query = "update Expenses set rent=:rent, bills=:bills, transportation=:transportation, leisure=:leisure, foodBeverage=:foodBeverage where entryID=:entryID";
	$statement = $db->prepare($query);
	$statement->bindValue(':rent', $rent);
	$statement->bindValue(':bills', $bills);
	$statement->bindValue(':transportation', $transportation);
	$statement->bindValue(':leisure', $leisure);
	$statement->bindValue(':foodBeverage', $foodBeverage);
	$statement->bindValue(':entryID', $entryID);
	$statement->execute();
	$statement->closeCursor();
}

function deleteExpense($entryID)
{
	global $db;
	$query = "delete from Expenses where entryID=:entryID";
	$statement = $db->prepare($query);
	$statement->bindValue(':entryID', $entryID);
	$statement->execute();
	$statement->closeCursor();
}

function addPayment($wagesAndSalary, $NonWageIncome, $entryID)
{
	// db handler
	global $db;

	$query = "insert into Payment (wagesAndSalary, NonWageIncome, entryID) values(:wagesAndSalary, :NonWageIncome, :entryID)";

	// execute the sql

	$statement = $db->prepare($query);


	$statement->bindValue(':wagesAndSalary', $wagesAndSalary);
	$statement->bindValue(':NonWageIncome', $NonWageIncome);
	$statement->bindValue(':entryID', $entryID);




	$statement->execute();

	// release; free the connection to the server so other sql statements may be issued
	$statement->closeCursor();
}

?>