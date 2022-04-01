<?php

function addFriend($entryID, $UserID ,$month, $year)
{
	// db handler
	global $db;

	// write sql
	// insert into friends values('someone', 'cs', 4)";
	$query = "insert into entry values(:entryID, :UserID, :month, :year)";

    // execute the sql

	//$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query);
    $statement->bindValue(':entryID', $entryID);
    $statement->bindValue(':UserID', $UserID);
    $statement->bindValue(':month', $month);
    $statement->bindValue(':year', $year);

    $statement->execute();
    //$statement->closeCursor();
	// release; free the connection to the server so other sql statements may be issued
	//$statement->close
}

function getAllFriends(){
    global $db;
    $query = "select * from entry";
    //$statement = $db->query($query);
    $statement = $db->prepare($query);
    $statement->execute();

    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
}

function getFriend_byName($entryID){
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

function updateFriend($entryID, $UserID, $month, $year){
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

function deleteFriend($entryID){
    global $db;
    $query = "delete from entry where entryID=:entryID";
    $statement = $db->prepare($query);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}

?>