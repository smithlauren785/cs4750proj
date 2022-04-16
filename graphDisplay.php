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

    function cmp($item1, $item2){
        if (intval($item1['year'])>intval($item2['year'])){
            return 1;
        }elseif(intval($item1['year'])==intval($item2['year']) and intval($item1['month'])>intval($item2['month'])){
            return 1;
        }else{
            return 0;
        }
    }

    //Monthly summary data
    usort($list_of_net, "cmp");

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
    usort($list_of_expenses, "cmp");

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
    usort($list_of_incomes, "cmp");

    $salary = array();
    $otherIncome = array();

    if(empty($list_of_incomes)){
        $list_of_incomes[] = array('month' => 'No Data yet :', 'year' => '', 'wagesAndSalary' => 0, 'nonWageIncome' =>0);
    }

    foreach ($list_of_incomes as $income):
        $salary[] = array( "label" => $income['month'].'/'.$income['year'], "y" => $income['wagesAndSalary']);
        $otherIncome[] = array( "label" => $income['month'].'/'.$income['year'], "y" => $income['NonWageIncome']);
    endforeach;

    //Rent Breakdown
    usort($list_of_rents, "cmp");

    $utilities = array();
    $base = array();
    $power = array();


    if(empty($list_of_rents)){
        $list_of_rents[] = array('month' => 'No Data yet :', 'year' => '', 'utilities' => 0, 'baseRent' =>0, 'power' => 0);
    }

    foreach ($list_of_rents as $rent):
        $utilities[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['utilities']);
        $base[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['baseRent']);
        $power[] = array(  "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['power']);
    endforeach;

    //Bills Breakdown
    usort($list_of_bills, "cmp");

    $insurance = array();
    $phone = array();
    $subscriptions = array();


    if(empty($list_of_bills)){
        $list_of_bills[] = array('month' => 'No Data yet :', 'year' => '', 'insurance' => 0, 'phone' =>0, 'subscriptions' => 0);
    }

    foreach ($list_of_bills as $rent):
        $insurance[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['insurance']);
        $phone[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['phone']);
        $subscriptions[] = array(  "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['subscriptions']);
    endforeach;

    //Transportation breakdown
    usort($list_of_transportations, "cmp");

    $carPayment = array();
    $gas = array();
    $publicTransportation = array();
    $airplaneFees = array();
    $rideshare = array();

    if(empty($list_of_transportations)){
        $list_of_expenses[] = array('month' => 'No Data yet :', 'year' => '', 'carPayment' => 0, 'gas' =>0, 'publicTransportation' => 0, 'airplaneFees'=>0, 'rideshare' => 0);
    }

    foreach ($list_of_transportations as $expense):
        $carPayment[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['carPayment']);
        $gas[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['gas']);
        $publicTransportation[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['publicTransportation']);
        $airplaneFees[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['airplaneFees']);
        $rideshare[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['rideshare']);
    endforeach;

    //Leisure breakdown
    usort($list_of_leisures, "cmp");

    $gym = array();
    $clothes = array();
    $beauty = array();
    $vacation = array();

    if(empty($list_of_leisures)){
        $list_of_leisures[] = array('month' => 'No Data yet :', 'year' => '', 'gym' => 0, 'gas' =>0, 'clothes' => 0, 'beauty'=>0, 'vacation' => 0);
    }

    foreach ($list_of_leisures as $expense):
        $gym[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['gym']);
        $clothes[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['clothes']);
        $beauty[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['beauty']);
        $vacation[] = array( "label" => $expense['month'].'/'.$expense['year'], "y" => $expense['vacation']);
    endforeach;

    //food Breakdown
    usort($list_of_foodBeverage, "cmp");

    $eatingOut = array();
    $groceries = array();
    $beverages = array();


    if(empty($list_of_foodBeverage)){
        $list_of_foodBeverage[] = array('month' => 'No Data yet :', 'year' => '', 'eatingOut' => 0, 'groceries' =>0, 'beverages' => 0);
    }

    foreach ($list_of_foodBeverage as $rent):
        $eatingOut[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['eatingOut']);
        $groceries[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['groceries']);
        $beverages[] = array(  "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['beverages']);
    endforeach;

    //wage/salary Breakdown
    usort($list_of_wagesAndSalary, "cmp");

    $wage = array();
    $tips = array();
    $salary = array();


    if(empty($list_of_wagesAndSalary)){
        $list_of_foodBeverage[] = array('month' => 'No Data yet :', 'year' => '', 'wage' => 0, 'tips' =>0, 'monthlySalary' => 0);
    }

    foreach ($list_of_wagesAndSalary as $rent):
        $wage[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['wage']);
        $tips[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['tips']);
        $salary[] = array(  "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['monthlySalary']);
    endforeach;
    
    //non wage Breakdown
    usort($list_of_nonWageIncome, "cmp");

    $investments = array();
    $allowance = array();
    $gifts = array();
    $scholarship = array();


    if(empty($list_of_nonWageIncome)){
        $list_of_nonWageIncome[] = array('month' => 'No Data yet :', 'year' => '', 'investmentsTotal' => 0, 'allowanceTotal' =>0, 'giftsTotal' => 0, 'scholarshipTotal' => 0);
    }

    foreach ($list_of_nonWageIncome as $rent):
        $investments[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['investmentsTotal']);
        $allowance[] = array( "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['allowanceTotal']);
        $gifts[] = array(  "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['giftsTotal']);
        $scholarship[] = array(  "label" => $rent['month'].'/'.$rent['year'], "y" => $rent['scholarshipsTotal']);
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

            var rent = new CanvasJS.Chart("rentContainer", {            
            title:{
                text: "Rent Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Utilities",
            showInLegend: true,
            dataPoints: <?php echo json_encode($utilities, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Base Rent", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($base, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Power", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($power, JSON_NUMERIC_CHECK); ?>
            }
            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            var bills = new CanvasJS.Chart("billsContainer", {            
            title:{
                text: "Bills Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Insurance",
            showInLegend: true,
            dataPoints: <?php echo json_encode($insurance, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Phone", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($phone, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Subscriptions", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($subscriptions, JSON_NUMERIC_CHECK); ?>
            }
            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            var transportation = new CanvasJS.Chart("transportation", {            
            title:{
                text: "Transportation Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Car Payment",
            showInLegend: true,
            dataPoints: <?php echo json_encode($carPayment, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Gas", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($gas, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Public Transportation", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($publicTransportation, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Airfare", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($airplaneFees, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Rideshare", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($rideshare, JSON_NUMERIC_CHECK); ?>
            }

            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });


            var leisure = new CanvasJS.Chart("leisure", {            
            title:{
                text: "Leisure Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Gym",
            showInLegend: true,
            dataPoints: <?php echo json_encode($gym, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Clothes", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($clothes, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Beauty", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($beauty, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Vacation", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($vacation, JSON_NUMERIC_CHECK); ?>
            }

            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });


            var food = new CanvasJS.Chart("foodContainer", {            
            title:{
                text: "Food and Beverage Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Eating Out",
            showInLegend: true,
            dataPoints: <?php echo json_encode($eatingOut, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Groceries", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($groceries, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Beverages", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($beverages, JSON_NUMERIC_CHECK); ?>
            }
            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            var salary = new CanvasJS.Chart("salaryContainer", {            
            title:{
                text: "Wage and Salay Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Wage",
            showInLegend: true,
            dataPoints: <?php echo json_encode($wage, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Tips", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($tips, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Monthly Salary", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($salary, JSON_NUMERIC_CHECK); ?>
            }
            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            var nonWage = new CanvasJS.Chart("nonWageContainer", {            
            title:{
                text: "Non-Wage Income Breakdown"              
            },

            data:[  //array of dataSeries     
            { //dataSeries - first quarter
            /*** Change type "column" to "bar", "area", "line" or "pie"***/        
            type: "column",
            name: "Investments",
            showInLegend: true,
            dataPoints: <?php echo json_encode($investments, JSON_NUMERIC_CHECK); ?>
            },

            { //dataSeries - second quarter

            type: "column",
            name: "Allowance", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($allowance, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Gifts", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($gifts, JSON_NUMERIC_CHECK); ?>
            },
            { //dataSeries - second quarter
            type: "column",
            name: "Scholarship", 
            showInLegend: true,               
            dataPoints: <?php echo json_encode($scholarship, JSON_NUMERIC_CHECK); ?>
            }
            ],
            /** Set axisY properties here*/
                axisY:{
                prefix: "$",
                }    
            });

            monthlySummary.render();
            expenses.render();
            income.render();
            rent.render();
            bills.render();
            transportation.render()
            leisure.render();
            food.render();
            salary.render();
            nonWage.render();
        }
    </script>
</head>

<body>

    <form method="POST" action="summaryform.php">
        <input type="text" value="<?= $_POST['current_user']?>" style="display:none" name="current_user" />
        <input type="submit" value="Back to Summary" class="btn btn-block btn-success btn-large"/>
    </form>

    <div id="summaryContainer" style="height: 370px; width: 100%;"></div>
    <div id="expenses" style="height: 370px; width: 100%;"></div>
    <div id="income" style="height: 370px; width: 100%;"></div>
    <div id="rentContainer" style="height: 370px; width: 100%;"></div>
    <div id="billsContainer" style="height: 370px; width: 100%;"></div>
    <div id="transportation" style="height: 370px; width: 100%;"></div>
    <div id="leisure" style="height: 370px; width: 100%;"></div>
    <div id="foodContainer" style="height: 370px; width: 100%;"></div>
    <div id="salaryContainer" style="height: 370px; width: 100%;"></div>
    <div id="nonWageContainer" style="height: 370px; width: 100%;"></div>
    
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
