# Introduction
This website is split into two pages. On the first page, index.php, the user can view information about products being offered by the company and can filter out certain products by interacting with a form in the page. On the second page, reps.php, the user can view information about sales reps who work for the company, and have the option to view more detailed information about customers associated with particular sales reps. 


# Index
Each time the page is loaded, a block of PHP code is run which manages the variables that store the user input. The first variable is an array that stores the product lines requested by the user. Only the products from the product lines in this array will be shown on the page. The second variable is used in the ORDER BY clause to control the ordering of products by stock availability. By default, the products are ordered by product line, however, the user can select the products to also be ordered by stock availability (high - low or low - high). Here, the ordering by product line takes precedence (products will first be ordered by product line, then will be ordered by stock availability if this is requested by the user). The final variable determines the stock quantity limit. When the user specifies a number in the limit field, this value is stored in the limit variable, and products with a quantity of stock greater than the limit will not be shown. 

By default, the user is greeted with all available products, ordered by product line. They are also greeted with a form which provides them with some optionality regarding the products shown on the site. The first part of the form is for filtering the products by product line. The user has the option to select all, none, or some of the product lines via clicking on checkboxes, and only products from these product lines will be displayed when the user presses submit. The second part of the form is for ordering the products by stock availability. This is a dropdown menu where the user can either opt to sort by stock availability high to low, low to high, or they can select the blank option. If they select the blank option, the products will not be sorted by stock availability. The final part of the form controls the stock quantity limit. The user is required to select an integer greater than or equal to 1 (otherwise an error is returned). This is enforced through the use of an input with type = number and min = 1. Once they have selected a limit, products with a quantity of stock value below that limit will be shown. The user has the option to leave this field blank, in which case no limit will be applied. 

Another block of PHP code is used to control the data that is displayed to the user. First, an attempt is made to connect with the remote server where the data is stored. The credentials for accessing the database are read in from a separate PHP file. If the connection fails, an error message is displayed informing the user that the data is not available. Once a connection to the database has been established, a series of tests are performed using if/elseif/else statements to determine which SQL query should be used to extract data from the database. The SQL query used will depend on whether the user has specified an order by and a limit. The extracted data is then presented in tabular format.


# Reps
Each time the page is loaded, a block of PHP code is run which manages the variable which stores the full name of the sales rep selected by the user. This variable will be blank when the page is first loaded, as the user has not selected a sales rep yet. Once the user selects a sales rep, their name is stored in this variable and will be displayed when the table containing information about the sales rep's customers is displayed. A sales rep table is also generated via a similar approach to the table generation in the index page. In the sales rep table, a single query is used to read in information pertaining to all sales reps (no if/elseif/else statements are used). After the table has been created, a JavaScript file main.js is loaded. This script contains a function called create_buttons(), which is called with the argument $php, which holds the name of the reps.php file. The create_buttons() function is used to iterate through each row in the sales rep table and convert the sales rep's name to a form with a submit button. When the user presses a submit button, information pertaining to the sales rep's customers is displayed as a pop-up. This information is extracted and presented in tabular format in the same manner as the previous tables. The total_sales() function from the main.js file is also executed to calculate the total sales associated with the sales rep. This function iterates through each row in the sales rep's table, adds the value in the customer payment column in each row, and returns the accumulated customer payments to the reps.php page, where it is displayed as a dollar amount beside the sales rep's name in their table. 


# Both Pages
Both pages read in separate PHP files for code reusability purposes. The files are read in using the require_once expression. The PHP files used are as follows: Header.php - used to generate the website header, which includes the company logo and the navigation bar. Footer.php - used to generate the website footer. dbconfig.php - used to read in the credentials required to connect to the MySQL database. TableRows.php - used to read in the class used to present data in tabular format. There is also a styles.php file which is used to style the website. A JavaScript file main.js is also used to provide some interactivity to the website.


# Error Handling
Custom error messages are displayed to the user in the following scenarios: The connection to the database fails, there is an error in the SQL query. I opted not to include error handling for the user-submitted form values as the input types that I used restricted the users from entering something invalid. For instance, in the limit field, instead of having the type = text, I set the type = number with a minimum value of 1. This way, the user can only input positive integers, implying that the value they submit will be valid and will not result in a security breach (can't submit any javascript code).


# References
https://stackoverflow.com/questions/20203063/mysql-where-id-is-in-array - Working with arrays in PHP

https://stackoverflow.com/questions/25870365/troubles-with-keeping-footer-below-content - Getting the footer to stay below all other page content

https://www.youtube.com/watch?v=iE_6pQ3RlZU - Popup design

https://stackoverflow.com/questions/13201451/how-to-use-css-style-in-php/19403636 - Using CSS with PHP

https://www.youtube.com/watch?v=GxwHXxumdQk - Header design

https://stackoverflow.com/questions/8233746/concatenate-with-null-values-in-sql - Managing addresses with NULL values

https://www.sqlservercentral.com/forums/topic/how-to-replace-uncounted-multiple-commas-into-one-comma - Replacing multiple commas with single columns in SQL

https://www.w3schools.com/php/php_exception.asp - Exception handling in PHP

Lecture 18 files - form_final - Form design/implementation and management of variables provided with values from the form.

Practical 8 - Connecting to a SQL database, converting extracted data into tabular form using the TableRows class