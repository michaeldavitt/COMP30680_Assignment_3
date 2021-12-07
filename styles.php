<?php
    /*** Set the content type header to CSS to make the CSS code work ***/
    header("Content-type: text/css");
?>

body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    list-style: none;
    background-color: #E6E6EA;
    text-align: center;
    box-sizing: border-box;
}

* {
    box-sizing: inherit;
}

#container {
    min-height: 100vh;
    position: relative;
}



/* Header Design */
/* Reference: https://www.youtube.com/watch?v=GxwHXxumdQk */
header {
    width: 100%;
    height: 70px;
    display: block;
    background-color: #333;
}

.inner-header {
    width: 90%;
    height: 100%;
    display: block;
    margin: 0 auto;
}

.logo-container {
    height: 100%;
    display: table;
    float: left;
}

.logo-container h1 {
    color: white;
    height: 100%;
    display: table-cell;
    vertical-align: middle;
    font-size: 32px;
    font-family: 'M PLUS 1 Code', sans-serif;
}

.logo-container h1 span {
    font-weight: 200;
}

.navigation {
    margin: 0;
    padding: 0;
    float: right;
    height: 100%;
}


.navigation li {
    height: 100%;
    display: table;
    float: left;
    padding: 0px 20px;
}



.navigation li a {
    display: table-cell;
    vertical-align: middle;
    height: 100%;
    color: white;
    font-size: 16px;
    text-decoration: none;
}

/* Page Header Design*/
h2 {
    font-size: 40px;
    font-weight: 700;
}

/* Form Design */


#product-form {
    border: 1px solid black;
    width: 90%;
    margin: 0 auto;
    margin-bottom: 20px;
    background-color: white;
    border-radius: 10px;
    padding-top: 20px;
    padding-left: 20px;
    text-align: left;
}


#product-form input {
    margin: 10px;
}




/* Table Design*/
.table-wrapper {
    overflow-x: auto;
    margin-bottom: 60px;
}

table {
    width: 90%;
    border: 2px solid black;
    margin: 0 auto;
}

td, th {
    border: 1px solid black;
    padding: 20px;
}

td {
    background-color: white;
}

th {
    background-color: grey;
    color: white
}

#body {
    padding-bottom: 120px;
}

button {
    width: 100px;
    height: 60px;
}

/* Error Message */
.error-message {
    color: red;
    font-size: 20px;
    font-weight: 600;
}

/* Footer Design*/
footer {
    background-color: #111;
    color: white;
    position: absolute;
    bottom: 0;
    margin-top: 200px;
    padding: 20px;
    width: 100%;
    overflow: hidden;
}


/* Pop-up design */
#popup .overlay {
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100vw;
    height: 100vh;
    background: #B2B2B2;
    opacity: 0.5;
    z-index: 1;
}

#popup .content {
    position: absolute;
    top: 50vh;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    width: 80vw;
    height: 80vh;
    z-index: 2;
    text-align: center;
    padding: 20px;
    box-sizing: border-box;
    overflow: auto;
}

#popup .close-btn {
    cursor: pointer;
    position: absolute;
    right: 20px;
    top: 20px;
    width: 30px;
    height: 30px;
    background: #222;
    color: #fff;
    font-size: 25px;
    font-weight: 600;
    line-height: 30px;
    text-align: center;
    border-radius: 50%;
}
