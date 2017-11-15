<?php
    include "function.inc.php";
/*
 Displays the list of employee names from Employees table
*/


    // TODO ge the name and do db call pull the name displaying on the regular list
    // var_dump($_POST['employeeName']);

    function checkForFilter() {
        if (!isset($_GET['employeeName']) && !isset($_GET['city'])) {
            //Output all Employees
            outputEmployeesByFilter(null, null);
        } else if (isset($_GET['employeeName']) && empty($_GET['employeeName']) && isset($_GET['city']) && !empty($_GET['city'])) {
            //Output employees by city name
            outputEmployeesByFilter(null, $_GET['city']);
        } else if (isset($_GET['employeeName']) && !empty($_GET['employeeName']) && isset($_GET['city']) && empty($_GET['city'])) {
            //Output employees by lastname
            outputEmployeesByFilter($_GET['employeeName'], null);
        } else if (isset($_GET['employeeName']) && !empty($_GET['employeeName']) && isset($_GET['city']) && !empty($_GET['city'])) {
            //Output the employee by both filters
            outputEmployeesByFilter($_GET['employeeName'], $_GET['city']);
        } else {
            echo "Please enter the employee name or select by city";
        }
        
    }

    function outputEmployeesByFilter($employeeName, $city) {
        $result = null;
        $both=null;
        $db = connectDB();
        $employee = new EmployeesGateway($db);
        if (isset($employeeName) && $city == null) {
            $result = $employee->findByLastName($employeeName);
        } elseif ($employeeName == null && isset($city)) {
            $result = $employee->findByCity($city);
        } elseif (!empty($employeeName) && !empty($city)) {
            $result = $employee->findByBothCityLastName($employeeName, $city);
        } else {
            $result = $employee->findAllSorted("LastName");
        }
        foreach($result as $key =>$value) {
            // echo '<a href="' . $SERVER["SCRIPT_NAME"] . '?employeeName=' . $result[$key]['FirstName'].$result[$key]['LastName']. '&city=' . $result[$key]['City'] . '" class="';
            echo '<a href="' . $SERVER["SCRIPT_NAME"] . '?employee=' . $result[$key]['EmployeeID']. '" class="';
                if (isset($_GET['employee']) && $_GET['employee'] == $result[$key]['EmployeeID']) echo 'active';
                echo 'item">';
                echo $result[$key]['FirstName'] . " " . $result[$key]["LastName"] . '</a><br/>';
        }
    }
    //Display all cities in the Employees table
    function outputCityDropdown() {
        $db = connectDB();
        $employee = new EmployeesGateway($db);
        $sql = $employee->getCities();
        $result = $employee->getStatement($sql);
        //var_dump($result);
        foreach ($result as $key => $value) {
            echo "<option value = '" . $value['City'] ."'";
            if ($_GET['city'] == $value['City']) echo ('selected="selected"');
            echo ">";
            echo $result[$key]['City'];
            echo "</option>";
        }
        
    }
?>
<main class="mdl-layout__content mdl-color--grey-50">
    <section class="page-content">
        <div class="mdl-grid">
           
            <div class="mdl-cell mdl-cell--12-col" >
                <div class = "mdl-card__title mdl-color--pink">
                    <h2 class="mdl-card__title-text">Browse Employees</h2>
                </div>
            </div>
            
            <!-- mdl-cell + mdl-card -->
             
            <div class="mdl-cell mdl-cell--12-col">
                <button id="filterbtn" class="button">Show Filter</button>
                <form id="employeesForm" action="browse-employees.php" method="get" class="filter hidden">
                    <!--<h3 class = "mdl-left-nav">Filter</h3>-->
                    <div class = "field">
                        <label>Employee name:</label><br>
                        <input name = "employeeName" type="text" placeholder = "Enter last name"><br>
                    </div>
                    <div class = "field">
                        <label>City:</label><br>
                        <select name = "city">
                        <option value = "0">Select city</option>
                        <?php  outputCityDropdown();?>
                        </select><br>
                    </div>
                    <input class="field" type="submit" value="Filter" id="Hide">
                        <!--<input class="button" type="submit" value="Filter">-->
                </form>
                <!--<input class="button" type="submit" value="Hide Filter" id="Hide">-->
            </div>
            <!-- mdl-cell + mdl-card -->
            <div class="mdl-cell mdl-cell--3-col card-lesson mdl-card  mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--pink">
                    <h2 class="mdl-card__title-text">Employees</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <ul class="demo-list-item mdl-list">
                        <?php  
                               /* programmatically loop though employees and display each
                                  name as <a> element. */
                                  checkForFilter();
                        ?> 
                    </ul>
                </div>
            </div>
        <!-- mdl-cell + mdl-card -->
         <?php //include 'employees-details.php';
         ?>
         <!--Display each employee's detail information-->
            <!--Such as Address, Todo something and Messages-->
            
            <div class="mdl-cell mdl-cell--9-col card-lesson mdl-card  mdl-shadow--2dp">
                <!--Title-->
                <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                    <h2 class="mdl-card__title-text">Employee Details</h2>
                </div>
                <!--Handle a missing and/or incorrect query string-->
                <?php
                    if(!isset($_GET['employee'])) {
                        echo "No employee found by request. Try clicking on an employee from list.";
                    } elseif (isset($_GET['employee']) && $_GET['employee'] < 1) {
                        echo "No employee found by request. Try clicking on an employee from list.";
                    } elseif ($_GET['employee'] >43 && $_GET['employee'] < 48) {
                        echo "No employee found by request. Try clicking on an employee from list.";
                    } elseif (isset($_GET['employee']) && $_GET['employee'] > 99) {
                        echo "No employee found by request. Try clicking on an employee from list.";
                    } else {
                        include_once ('employees-detail.php');
                    }
                ?>
            </div>
        </div>
    </section>
</main>