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

    usort($list_of_net, function ($item1, $item2) {
        return (intval($item1['year'].$item1['month'])) > (intval($item1['year'].$item2['month']));
    });

    $dataPoints = array();
    $dataPoints2 = array();
    foreach ($list_of_net as $net):
        $dataPoints[] = array( "label" => $net['month'].'/'.$net['year'], "y" =>$net['wagesAndSalary'] + $net['NonWageIncome']);
        $dataPoints2[] = array( "label" => $net['month'].'/'.$net['year'], "y" =>$net['rent'] + $net['bills'] + $net['transportation'] + $net['leisure'] + $net['foodBeverage']);
    endforeach;

    //$net['month'].'/'.$net['year']
    // $dataPoints = array(
    //     array("y"=> 41),
    //     array("y"=> 35),
    //     array("y"=> 50),
    //     array("y"=> 45),
    //     array("y"=> 52),
    //     array("y"=> 68),
    //     array("y"=> 38),
    //     array("y"=> 71),
    //     array("y"=> 52),
    //     array("y"=> 60),
    //     array("y"=> 36),
    //     array("y"=> 49),
    //     array("y"=> 41)
    // );

?>

<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer1", {            
            title:{
                text: "Summary"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "First Quarter",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Second Quarter", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }
            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            var chart2 = new CanvasJS.Chart("chartContainer2", {            
            title:{
                text: "Not a summary"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "First Quarter",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Second Quarter", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }
            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            chart.render();
            chart2.render();
        }
    </script>
</head>

<body>
    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
