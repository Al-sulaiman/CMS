<?php
ob_start();
//here we have used an API mysqli_connect() function
    $host = 'localhost:3307';
    $username1 = 'root';
    $password1 = '1234';
    $database = 'cms';
    
    $connection =   mysqli_connect($host, $username1, $password1, $database);
    
    if (!$connection ){
        die("Connection not established: " . mysqli_connect_error());
    }