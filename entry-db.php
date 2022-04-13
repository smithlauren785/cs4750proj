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
    $query = "select entry.month, entry.year, Expenses.rent, Expenses.bills, Expenses.transportation, Expenses.leisure, Expenses.foodBeverage FROM entry RIGHT OUTER JOIN Expenses ON Expenses.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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



function getAllIncome($UserID)
{
    global $db;
    $query = "select * FROM Expenses RIGHT OUTER JOIN Payment ON Expenses.entryID = Payment.entryID RIGHT OUTER JOIN entry on Expenses.entryID = entry.entryID where Expenses.entryID in (select entryID from entry where UserID = :UserID)";

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

function getAllIncomeByMonth($UserID)
{
    global $db;
    $query = "select * FROM Expenses RIGHT OUTER JOIN Payment ON Expenses.entryID = Payment.entryID RIGHT OUTER JOIN entry on Expenses.entryID = entry.entryID where Expenses.entryID in (select entryID from entry where UserID = :UserID)  ORDER BY entry.month";

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
function getAllIncomeByYear($UserID)
{
    global $db;
    $query = "select * FROM Expenses RIGHT OUTER JOIN Payment ON Expenses.entryID = Payment.entryID RIGHT OUTER JOIN entry on Expenses.entryID = entry.entryID where Expenses.entryID in (select entryID from entry where UserID = :UserID)  ORDER BY entry.year";

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

function getAllIncomeByIncome($UserID)
{
    global $db;
    $query = "select * FROM Expenses RIGHT OUTER JOIN Payment ON Expenses.entryID = Payment.entryID RIGHT OUTER JOIN entry on Expenses.entryID = entry.entryID where Expenses.entryID in (select entryID from entry where UserID = :UserID)  ORDER BY (Payment.wagesAndSalary + Payment.NonWageIncome)";

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

function getAllIncomeByExpenses($UserID)
{
    global $db;
    $query = "select * FROM Expenses RIGHT OUTER JOIN Payment ON Expenses.entryID = Payment.entryID RIGHT OUTER JOIN entry on Expenses.entryID = entry.entryID where Expenses.entryID in (select entryID from entry where UserID = :UserID)  ORDER BY (Expenses.rent + Expenses.bills + Expenses.transportation + Expenses.foodBeverage + Expenses.leisure)";

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

function getAllIncomeByNet($UserID)
{
    global $db;
    $query = "select * FROM Expenses RIGHT OUTER JOIN Payment ON Expenses.entryID = Payment.entryID RIGHT OUTER JOIN entry on Expenses.entryID = entry.entryID where Expenses.entryID in (select entryID from entry where UserID = :UserID)  ORDER BY ((Payment.wagesAndSalary + Payment.NonWageIncome) - (Expenses.rent + Expenses.bills + Expenses.transportation + Expenses.foodBeverage + Expenses.leisure))";

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

function getAllPayments($UserID)
{
    global $db;
    $query = "select entry.month, entry.year, Payment.wagesAndSalary, Payment.NonWageIncome FROM entry RIGHT OUTER JOIN Payment ON Payment.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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

function addRent($utilities, $baseRent, $power, $entryID)
{
    global $db;
    $query = "insert into Rent (utilities, baseRent, power, entryID) values(:utilities, :baseRent, :power, :entryID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':utilities', $utilities);
    $statement->bindValue(':baseRent', $baseRent);
    $statement->bindValue(':power', $power);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}

function getAllRents($UserID)
{
    global $db;
    $query = "select entry.month, entry.year, Rent.utilities, Rent.baseRent, Rent.power FROM entry RIGHT OUTER JOIN Rent ON Rent.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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

# functions for adding, selecting, updating and deleting bills

function addBills($insurance, $phone, $subscriptions, $entryID)
{
    global $db;
    $query = "insert into Bills (insurance, phone, subscriptions, entryID) values(:insurance, :phone, :subscriptions, :entryID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':insurance', $insurance);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':subscriptions', $subscriptions);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}

function getAllBills($UserID)
{
    global $db;
    $query = "select entry.month, entry.year, Bills.insurance, Bills.phone, Bills.subscriptions FROM entry RIGHT OUTER JOIN Bills ON Bills.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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

# functions for adding, selecting, updating and deleting transportation

function addTransportation($carPayment, $gas, $publicTransportation, $airplaneFees, $rideshare, $entryID)
{
    global $db;
    $query = "insert into Transportation (carPayment, gas, publicTransportation, airplaneFees, rideshare, entryID) values(:carPayment, :gas, :publicTransportation, :airplaneFees, :rideshare, :entryID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':carPayment', $carPayment);
    $statement->bindValue(':gas', $gas);
    $statement->bindValue(':publicTransportation', $publicTransportation);
    $statement->bindValue(':airplaneFees', $airplaneFees);
    $statement->bindValue(':rideshare', $rideshare);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}

function getAllTransportations($UserID)
{
    global $db;
    $query = "select entry.month, entry.year, Transportation.carPayment, Transportation.gas, Transportation.publicTransportation, Transportation.airplaneFees, Transportation.rideshare FROM entry RIGHT OUTER JOIN Transportation ON Transportation.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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

# functions for adding, selecting, updating and deleting leisure

function addLeisure($gym, $clothes, $beauty, $vacation, $entryID)
{
    global $db;
    $query = "insert into Leisure (gym, clothes, beauty, vacation, entryID) values(:gym, :clothes, :beauty, :vacation, :entryID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':gym', $gym);
    $statement->bindValue(':clothes', $clothes);
    $statement->bindValue(':beauty', $beauty);
    $statement->bindValue(':vacation', $vacation);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}

function getAllLeisures($UserID)
{
    global $db;
    $query = "select entry.month, entry.year, Leisure.gym, Leisure.clothes, Leisure.beauty, Leisure.vacation FROM entry RIGHT OUTER JOIN Leisure ON Leisure.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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


# functions for adding, selecting, updating and deleting foodBeverage
function addFoodBeverage($eatingOut, $groceries, $beverages, $entryID)
{
    global $db;
    $query = "insert into FoodBeverage (eatingOut, groceries, beverages, entryID) values(:eatingOut, :groceries, :beverages, :entryID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':eatingOut', $eatingOut);
    $statement->bindValue(':groceries', $groceries);
    $statement->bindValue(':beverages', $beverages);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}


function getAllFoodBeverage($UserID)
{
    global $db;
    $query = "select entry.month, entry.year, FoodBeverage.eatingOut, FoodBeverage.groceries, FoodBeverage.beverages FROM entry RIGHT OUTER JOIN FoodBeverage ON FoodBeverage.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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

# functions for adding, selecting, updating and deleting wagesAndSalary

function addWagesAndSalary($wage, $tips, $monthlySalary, $entryID)
{
    global $db;
    $query = "insert into WagesAndSalary (wage, tips, monthlySalary, entryID) values(:wage, :tips, :monthlySalary, :entryID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':wage', $wage);
    $statement->bindValue(':tips', $tips);
    $statement->bindValue(':monthlySalary', $monthlySalary);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}

function getAllWagesAndSalary($UserID)
{
    global $db;
    $query = "select entry.month, entry.year, WagesAndSalary.wage, WagesAndSalary.tips, WagesAndSalary.monthlySalary FROM entry RIGHT OUTER JOIN WagesAndSalary ON WagesAndSalary.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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

# functions for adding, selecting, updating and deleting NonWageIncome

function addNonWageIncome($investmentsTotal, $allowanceTotal, $giftsTotal, $scholarshipsTotal, $entryID)
{
    global $db;
    $query = "insert into NonWageIncome (investmentsTotal, allowanceTotal, giftsTotal, scholarshipsTotal, entryID) values(:investmentsTotal, :allowanceTotal, :giftsTotal, :scholarshipsTotal, :entryID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':investmentsTotal', $investmentsTotal);
    $statement->bindValue(':allowanceTotal', $allowanceTotal);
    $statement->bindValue(':giftsTotal', $giftsTotal);
    $statement->bindValue(':scholarshipsTotal', $scholarshipsTotal);
    $statement->bindValue(':entryID', $entryID);
    $statement->execute();
    $statement->closeCursor();
}

function getAllNonWageIncome($UserID)
{
    global $db;
    $query = "select entry.month, entry.year, NonWageIncome.investmentsTotal, NonWageIncome.allowanceTotal, NonWageIncome.giftsTotal, NonWageIncome.scholarshipsTotal FROM entry RIGHT OUTER JOIN NonWageIncome ON NonWageIncome.entryID = entry.entryID where entry.entryID in (select entryID from entry where UserID = :UserID)";

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
?>
