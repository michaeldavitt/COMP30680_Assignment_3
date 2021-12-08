<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="styles.php" media="screen">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Content wrapper -->
    <div id="container">

        <!-- Header -->
        <?php
            require_once "Header.php";
        ?>

        <!-- Manange variables for the SQL query -->
        <!-- Reference: Lecture 18 files - form_final -->
        <?php
            // Initialise product line array with all products
            $productLines = array("Classic Cars", "Motorcycles", "Planes", "Ships", "Trains", "Trucks and Buses", "Vintage Cars");
            $order = $limit = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // Remove a product from the array if it has not been selected by the user
                if (empty($_POST["ClassicCars"])) {
                    $productLines = array_diff($productLines, array("Classic Cars"));
                } 
                
                if (empty($_POST["Motorcycles"])) {
                    $productLines = array_diff($productLines, array("Motorcycles"));
                } 
                    
                if (empty($_POST["Planes"])) {
                    $productLines = array_diff($productLines, array("Planes"));
                } 

                if (empty($_POST["Ships"])) {
                    $productLines = array_diff($productLines, array("Ships"));
                } 

                if (empty($_POST["Trains"])) {
                    $productLines = array_diff($productLines, array("Trains"));
                } 

                if (empty($_POST["TrucksandBuses"])) {
                    $productLines = array_diff($productLines, array("Trucks and Buses"));
                } 

                if (empty($_POST["VintageCars"])) {
                    $productLines = array_diff($productLines, array("Vintage Cars"));
                } 

                // Check if the user has selected an order by
                if (isset($_POST["Order"])) {

                    // Set the order by to descending, ascending, or empty depending on the user's selection
                    if ($_POST["Order"] == "Decreasing") {
                        $order = "DESC";
                    } 
                    
                    elseif ($_POST["Order"] == "Increasing") {
                        $order = "ASC";
                    }

                    else {
                        $order = "";
                    }
                } 

                // If the limit has been set, test the input and assign the user's value to the limit variable
                if (!empty($_POST["Limit"])) {
                    $limit = $_POST["Limit"];
                }
            }

            // Convert the product lines array to a string for the SQL query
            // Reference: https://stackoverflow.com/questions/20203063/mysql-where-id-is-in-array
            $productLines = implode( "','", $productLines);

        ?>

        <!-- Main content wrapper -->
        <div id="body">

            <h2>Products</h2>

            <!-- Form which allows users to select the products that they are interested in -->
            <!-- Reference: Lecture 18 - form_final -->
            <div class="form-wrapper">
                <form id="product-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-section">
                        <h3>Filter by Product Line</h3>
                        <script>

                            function toggle(source) {
                                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                                for (var i = 0; i < checkboxes.length; i++) {
                                    if (checkboxes[i] != source)
                                        checkboxes[i].checked = source.checked;
                                }
                            }

                        </script>
                        <label for="All"> Select All </label><input type="checkbox" id="All" name="All" onclick="toggle(this)" <?php if (isset($_POST["All"])) echo "checked";?> value="All">
                        <label for="ClassicCars"> Classic Cars </label><input type="checkbox" id="ClassicCars" name="ClassicCars" <?php if (isset($_POST["ClassicCars"])) echo "checked";?> value="Classic Cars">
                        <label for="Motorcycles"> Motorcycles </label><input type="checkbox" id="Motorcycles" name="Motorcycles" <?php if (isset($_POST["Motorcycles"])) echo "checked";?> value="Motorcycles">
                        <label for="Planes"> Planes </label><input type="checkbox" id="Planes" name="Planes" <?php if (isset($_POST["Planes"])) echo "checked";?> value="Planes">
                        <label for="Ships"> Ships </label><input type="checkbox" id="Ships" name="Ships" <?php if (isset($_POST["Ships"])) echo "checked";?> value="Ships">
                        <label for="Trains"> Trains </label><input type="checkbox" id="Trains" name="Trains" <?php if (isset($_POST["Trains"])) echo "checked";?> value="Trains">
                        <label for="TrucksandBuses"> Trucks and Buses </label><input type="checkbox" id="TrucksandBuses" name="TrucksandBuses" <?php if (isset($_POST["TrucksandBuses"])) echo "checked";?> value="Trucks and Buses">
                        <label for="VintageCars"> Vintage Cars </label><input type="checkbox" id="VintageCars" name="VintageCars"  <?php if (isset($_POST["VintageCars"])) echo "checked";?> value="Vintage Cars">
                    </div>
                    
                    <div class="form-section">
                        <h3>Sort by Stock Availability</h3>
                        <label for="Order"> Sort by: </label>
                        <select id="Order" name="Order">
                            <option value="none">No Sort</option>
                            <option value="Decreasing" <?php if (isset($order) && $order=="DESC") echo "selected=\"selected\"";?>>Stock (high to low)</option>
                            <option value="Increasing" <?php if (isset($order) && $order=="ASC") echo "selected=\"selected\"";?>>Stock (low to high)</option>  
                        </select>
                    </div>
                    
                    <div class="form-section">
                        <h3>Set Stock Quantity Limit (products with quantity in stock above this limit will not be shown)</h3>
                        <label for="Limit"> Limit: </label><input type="number" id="Limit" name="Limit" min="1" <?php if (isset($limit)) echo "value=\"$limit\"";?>>
                    </div>

                    <div class="form-section">
                        <input type="submit" name="submit" value="Get Products">
                    </div>
                    
                </form>
            </div>

            <!-- Product Table -->
            <div class="table-wrapper">
                <table id="product_table">
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Quantity in Stock</th>
                        <th>MSRP</th>
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

                            // Create if/elseif/else which executes specific queries depending on user input

                            // Query for when the user has specified an order by and a limit
                            if (!empty($order) && !empty($limit)) {
                                $stmt = $conn->prepare("SELECT productName, productCode, productDescription, quantityInStock, 
                                MSRP FROM products WHERE productLine IN ('" . $productLines . "') AND quantityInStock < $limit 
                                ORDER BY productLine, quantityInStock $order");
                            } 
                                
                            // Query for when the user has specified an order by, but not a limit
                            elseif (!empty($order)) {
                                $stmt = $conn->prepare("SELECT productName, productCode, productDescription, quantityInStock, 
                                MSRP FROM products WHERE productLine IN ('" . $productLines . "') ORDER BY productLine, quantityInStock $order");
                            } 
                                
                            // Query for when the user has specified a limit, but not an order by 
                            elseif (!empty($limit)) {
                                $stmt = $conn->prepare("SELECT productName, productCode, productDescription, quantityInStock, 
                                MSRP FROM products WHERE productLine IN ('" . $productLines . "') AND quantityInStock < $limit 
                                ORDER BY productLine");
                            } 
                                
                            // Query for when the user has not specified either an order by or a limit
                            else {
                                $stmt = $conn->prepare("SELECT productName, productCode, productDescription, quantityInStock, 
                                MSRP FROM products WHERE productLine IN ('" . $productLines . "') ORDER BY productLine");
                            }
                                
                            $stmt->execute();

                            // set the resulting array to associative
                            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                
                            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                                echo $v;
                            }

                        } 
                        
                        // Exception handling for when we can't connect to the database or if the query fails
                        catch(PDOException $e) {
                            echo "<p class=\"error-message\">Message: " . $e->getMessage() . "</p>";
                        }
                        
                        // Remove connection to the database when we have all the required data.
                        $conn = null;
                    ?>

                </table>
            </div>

        </div>

        <!-- Footer -->
        <?php
            require_once "Footer.php";
        ?>

    </div>

</body>
</html>