<?php

# functions for adding, selecting, updating and deleting entry


function deleteEntry($entryID){
    global $db;
    $query = "delete from entry where entryID=:entryID";
    $statement = $db->prepare($query);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}

function addEntry($UserID, $month, $year)
{
	// db handler
	global $db;


	$query = "insert into entry (UserID, month, year) values(:UserID, :month, :year)";

	$statement = $db->prepare($query);

	$statement->bindValue(':UserID', $UserID);
	$statement->bindValue(':month', $month);
	$statement->bindValue(':year', $year);

	$statement->execute();

	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
}

function getAllEntriesForUser($UserID){
    global $db;
    $query = "select * from entry where UserID=:UserID";
    //$statement = $db->query($query);
    $statement = $db->prepare($query);
    $statement->bindValue(':UserID', $UserID);
    $statement->execute();

    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
}

function getEntry_byName($entryID){
    global $db;
    $query = "select * from entry where entryID = :entryID";
    //$statement = $db->query($query);
    $statement = $db->prepare($query);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();

    $results = $statement->fetch();

    $statement->closeCursor();
    return $results;

}

function updateEntry($entryID, $UserID, $month, $year){
    global $db;
    $query = "update entry set UserID=:UserID, month=:month, year=:year where entryID=:entryID";
    $statement = $db->prepare($query);
    $statement->bindValue(':UserID', $UserID);
    $statement->bindValue(':month', $month);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}







# functions for adding, selecting, updating and deleting expenses

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

function getAllExpenses($UserID)
{
	global $db;
	$query = "select * from Expenses where entryID in (select entryID from entry where UserID = :UserID)";


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

function getAllIncome($UserID)
{
	global $db;
	$query = "select * FROM Expenses RIGHT OUTER JOIN Payment ON Expenses.entryID = Payment.entryID where Expenses.entryID in (select entryID from entry where UserID = :UserID)";


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
	$query = "update Expenses set  rent=:rent, bills=:bills, transportation=:transportation, leisure=:leisure, foodBeverage=:foodBeverage where entryID=:entryID";
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










# functions for adding, selecting, updating and deleting income

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

function getAllPayments($UserID)
{
	global $db;
	$query = "select * from Payment where entryID in (select entryID from entry where UserID = :UserID)";


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

# functions for adding, selecting, updating and deleting rent


# functions for adding, selecting, updating and deleting bills

# functions for adding, selecting, updating and deleting transportation

# functions for adding, selecting, updating and deleting leisure

# functions for adding, selecting, updating and deleting foodBeverage

# functions for adding, selecting, updating and deleting wagesAndSalary

# functions for adding, selecting, updating and deleting NonWageIncome










?>