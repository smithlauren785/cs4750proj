<?php
    require('connectdb.php');
    require('user-db.php');
    require('entry-db.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $list_of_users = getAllUsers();


    $user_id = $_POST['current_user'];
    $list_of_expenses = getAllExpenses($user_id);
    $list_of_payments = getAllPayments($user_id);
    $list_of_net = getAllIncome($user_id);
    $list_of_entries = getAllEntriesForUser($user_id);
    $list_of_incomes = getAllPayments($user_id);
    $list_of_rents = getAllRents($user_id);
    $list_of_bills = getAllBills($user_id);
    $list_of_transportations = getAllTransportations($user_id);
    $expenses_payments = $list_of_expenses + $list_of_payments;
    $list_of_leisures = getAllLeisures($user_id);
    $list_of_foodBeverage = getAllFoodBeverage($user_id);
    $list_of_wagesAndSalary = getAllWagesAndSalary($user_id);
    $list_of_nonWageIncome = getAllNonWageIncome($user_id);

    //Monthly summary data
    usort($list_of_net, function ($item1, $item2) {
        return (intval($item1['year'].$item1['month'])) > (intval($item1['year'].$item2['month']));
    });

    $total_income = array();
    $total_expenses = array();

    if(empty($list_of_net)){
        $list_of_net[] = array('month' => 'No Data yet :', 'year' => '', 'rent' => 0, 'bills' =>0, 'transportation' => 0, 'leisure'=>0, 'foodBeverage' => 0, 'wagesAndSalary' => 0, 'NonWageIncome' => 0);
    }

    foreach ($list_of_net as $net):
        $total_income[] = array( "label" => $net['month'].'/'.$net['year'], "y" =>$net['wagesAndSalary'] + $net['NonWageIncome']);
        $total_expenses[] = array( "label" => $net['month'].'/'.$net['year'], "y" =>$net['rent'] + $net['bills'] + $net['transportation'] + $net['leisure'] + $net['foodBeverage']);
    endforeach;

    //Expenses data
    usort($list_of_expenses, function ($item1, $item2) {
        return (intval($item1['year'].$item1['month'])) > (intval($item1['year'].$item2['month']));
    });

    $rent = array();
    $bills = array();
    $transportation = array();
    $leisure = array();
    $food = array();

    if(empty($list_of_expenses)){
        $list_of_expenses[] = array('month' => 'No Data yet :', 'year' => '', 'rent' => 0, 'bills' =>0, 'transportation' => 0, 'leisure'=>0, 'foodBeverage' => 0);
    }

    foreach ($list_of_expenses as $expense):
        $rent[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['rent']);
        $bills[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['bills']);
        $transportation[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['transportation']);
        $leisure[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['leisure']);
        $food[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['foodBeverage']);
    endforeach;


    //income data
    usort($list_of_incomes, function ($item1, $item2) {
        return (intval($item1['year'].$item1['month'])) > (intval($item1['year'].$item2['month']));
    });

    $salary = array();
    $otherIncome = array();

    if(empty($list_of_incomes)){
        $list_of_incomes[] = array('month' => 'No Data yet :', 'year' => '', 'wagesAndSalary' => 0, 'nonWageIncome' =>0);
    }

    foreach ($list_of_incomes as $income):
        $salary[] = array( "label" => $income['month'].'/'.$income['year'], "y" => $income['wagesAndSalary']);
        $otherIncome[] = array( "label" => $income['month'].'/'.$income['year'], "y" => $income['nonWageIncome']);
    endforeach;

?>

<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
        window.onload = function () {
            var monthlySummary = new CanvasJS.Chart("summaryContainer", {            
            title:{
                text: "Monthly Summary"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Income",
            showInLegend: true,
            dataPoints: <?php echo json_encode($total_income, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Expenses", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($total_expenses, JSON_NUMERIC_CHECK); ?>
            }
            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });


            var expenses = new CanvasJS.Chart("expenses", {            
            title:{
                text: "Expense Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Rent",
            showInLegend: true,
            dataPoints: <?php echo json_encode($rent, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Bills", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($bills, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Transportation", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($transportation, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Leisure", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($leisure, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Food and Beverage", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($food, JSON_NUMERIC_CHECK); ?>
            }

            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            var income = new CanvasJS.Chart("income", {            
            title:{
                text: "Income Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Salary",
            showInLegend: true,
            dataPoints: <?php echo json_encode($salary, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Other", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($otherIncome, JSON_NUMERIC_CHECK); ?>
            },

            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            monthlySummary.render();
            expenses.render();
            income.render();
        }
    </script>
</head>

<body>
    <div id="summaryContainer" style="height: 370px; width: 100%;"></div>
    <div id="expenses" style="height: 370px; width: 100%;"></div>
    <div id="income" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
