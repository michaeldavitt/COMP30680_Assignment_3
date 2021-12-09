<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Reps</title>
    <link rel="stylesheet" href="styles.php" media="screen">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code:wght@500&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Content wrapper -->
    <div id="container">

        <?php
            // Initialise variables
            $full_name = "";
            $php = htmlspecialchars($_SERVER["PHP_SELF"]);

            // Set the full_name variable to the name of the sales rep selected by the user
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["submit"])) {
                    $full_name = $_POST["submit"];
                }
            }
        ?>

        <!-- Header -->
        <?php
            require_once "Header.php";
        ?>

        <div id="body">

            <!-- Sales rep table -->
            <h2>Sales Reps</h2>
            <div class="table-wrapper">
                <table id="sales_rep_table">
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Office Address</th>
                        <th>Reports to</th>
                    </tr>
                    
                    <?php
                        // Reference: Practical 8
                        // Define the class for creating tables
                        require_once "TableRows.php";

                        // Read in the specifications for connecting to the database
                        require_once "dbconfig.php";

                        // Connect to the database
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            try{

                                $stmt = $conn->prepare("SELECT CONCAT(E1.firstName, \" \", E1.lastName), E1.email, 
                                REPLACE(REPLACE(CONCAT(O.addressLine1, \", \", COALESCE(O.addressLine2, \"\"), \", \", 
                                COALESCE(O.state, \"\"), \", \", O.country), \", , ,\", \",\"), \", ,\", \",\"), 
                                CONCAT(E2.firstName, \" \", E2.lastName) 
                                FROM employees AS E1, offices AS O, employees AS E2 
                                WHERE E1.jobTitle = \"Sales Rep\" AND E1.officeCode = O.officeCode AND E1.reportsTo = E2.employeeNumber");
                                $stmt->execute();
                                // set the resulting array to associative
                                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                
                                foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                                    echo $v;
                                }

                            }

                            catch(PDOException) {
                                echo "<p class=\"error-message\">Error: Data unavailable. Failed to extract data pertaining to sales reps. Please try again later</p>";
                            }

                        } 
                        
                        // Exception handling for when we can't connect to the database or if the query fails
                        catch(PDOException) {
                            echo "<p class=\"error-message\">Error: Data unavailable. Failed to connect to database. Please try again later</p>";
                        }

                    echo "</table>
                    </div>
                    ";

                    echo "<script src=main.js></script>";
                    echo "<script>create_buttons(\"" . $php . "\")</script>";
                    
                ?>
            

            <!-- For customers table -->
            <?php
                // Reference: Practical 8

                if (isset($_POST["submit"])) {
                    
                    echo "
                    <script>
                        function closePopup() {
                            document.getElementById(\"popup\").style.display = \"none\";
                        }
                    </script>

                    <div id=\"popup\">
                        <div class=\"overlay\" onclick=\"closePopup()\"></div>
                        <div class=\"content\">
                            <div class=\"close-btn\" onclick=\"closePopup()\">&times;</div>
                            <h2 id=\"employee-title\">
                            "; 
                            echo $full_name; 
                            echo " - Total Sales Value: $<span id=\"total-sales\"></span></h2>
                            <h3>Customer Details (<a href=\"#customer-order-header\">Click to view customer order log</a>)</h3>
                            <div class=\"table-wrapper\">
                                <table id=\"customers\">
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Credit Limit</th>
                                        <th>Total Payments</th>
                                    </tr>";


                                try {
                                    $stmt = $conn->prepare("SELECT C.customerName, 
                                    REPLACE(CONCAT(C.addressLine1, \", \", COALESCE(C.addressLine2, \"\"), \", \", C.city, \", \", 
                                    COALESCE(C.state, \"\"), \", \", C.country), \", ,\", \",\"), 
                                    C.creditLimit, ROUND(SUM(P.amount), 2)
                                    FROM customers AS C, employees AS E, payments AS P
                                    WHERE CONCAT(E.firstName, \" \", E.lastName) = \"$full_name\" AND E.employeeNumber = C.salesRepEmployeeNumber 
                                    AND C.customerNumber = P.customerNumber
                                    GROUP By C.customerNumber
                                    ORDER BY C.customerName");
                                    $stmt->execute();

                                    // set the resulting array to associative
                                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                                        echo $v;
                                    } 

                                    echo "<script src=main.js></script>";
                                    echo "<script>total_sales()</script>";
                                }

                                // Exception handling for when the SQL query fails
                                catch(PDOException) {
                                    echo "<p class=\"error-message\">Error: Data unavailable. Failed to extract data pertaining to customers. Please try again later</p>";
                                }

                                echo "
                                </table>
                            </div>

                            <h3 id=\"customer-order-header\">Order Log</h3>
                            <div class=\"table-wrapper\">
                                <table id=\"customer-orders\">
                                    <tr>
                                        <th>Name</th>
                                        <th>Order</th>
                                    </tr>";

                                try {
                                    $stmt = $conn->prepare("SELECT C.customerName, O.orderNumber
                                    FROM customers AS C, employees AS E, orders AS O
                                    WHERE CONCAT(E.firstName, \" \", E.lastName) = \"$full_name\" AND E.employeeNumber = C.salesRepEmployeeNumber 
                                    AND C.customerNumber = O.customerNumber
                                    ORDER BY C.customerName, O.orderNumber");
                                    $stmt->execute();

                                    // set the resulting array to associative
                                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                                        echo $v;
                                    } 
                                }

                                // Exception handling for when the SQL query fails
                                catch(PDOException) {
                                    echo "<p class=\"error-message\">Error: Data unavailable. Failed to extract data pertaining to customer orders. Please try again later</p>";
                                }
                                
                                // Remove connection to the database when we have all the required data.
                                $conn = null;

                                echo "
                                </table>
                            </div>
                        </div>
                    </div>";
                }

            ?>

        </div>

        <!-- Footer -->
        <?php
            require_once "Footer.php";
        ?>
    
    </div>


</body>
</html>