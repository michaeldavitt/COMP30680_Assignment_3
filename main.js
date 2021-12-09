 function create_buttons(php){
    // Get the sales rep table
    var rep_table = document.getElementById("sales_rep_table");
    var rep_rows = rep_table.getElementsByTagName("tr");
    
    // Iterate through the rows
    for (var i=0; i < rep_rows.length; i++) {
    
        // Get the table data within each row
        var rep_data = rep_rows[i].getElementsByTagName("td");
    
        // Iterate through the data
        for (var j = 0; j < rep_data.length; j++) {
    
            // Isolate the first data item
            if (j==0) {
    
                // Replace the first data item with a button that calls a function to display certain rows in the product table
                var data_name = rep_data[j].innerHTML
                rep_data[j].innerHTML = "<td><form method=\"post\" action=\'" + php + "\'><input type=\"submit\" name=\"submit\" value=\"" + data_name + "\"></form></td>";
            }
        }
    }
}
    
function total_sales(){

    // Get the customers table
    var customer_table = document.getElementById("customers")
    var customer_rows = customer_table.getElementsByTagName("tr")
    
    // Create a variable to keep track of total sales
    var cumulative_sales = 0;
    
    // Iterate through the rows
    for (var i=0; i < customer_rows.length; i++) {
    
        // Get the table data within each row
        var customer_data = customer_rows[i].getElementsByTagName("td");
    
        // Iterate through the data
        for (var j = 0; j < customer_data.length; j++) {

            // Isolate Credit Limit to add dollar sign
            if (j==2) {
                converted_credit_limit = "$" + customer_data[j].innerHTML
                customer_data[j].innerHTML = converted_credit_limit 
            }
    
            // Isolate the total payments to add dollar sign, convert to integer and add to cumulative sales figure
            if (j==3) {

                // Add the total payments to the total sales cumulative figure
                converted_total_payment = parseFloat(customer_data[j].innerHTML)
                cumulative_sales += converted_total_payment
                customer_data[j].innerHTML = "$" + converted_total_payment

            }
        }
    }
    
    document.getElementById("total-sales").innerHTML = cumulative_sales.toFixed(2);
}
