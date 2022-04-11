<?php

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



?>