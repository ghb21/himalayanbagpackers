<?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $db = "himalayanbagpackers";
    
   // Connection
   $con = mysqli_connect($servername, $username, $password,$db);
    
   // Check if connection is 
   // Successful or not
   if (!$con) {
     die("Connection failed: "
         . mysqli_connect_error());
   }
   
?>