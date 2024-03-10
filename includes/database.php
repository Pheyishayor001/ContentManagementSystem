<?php

$serverName = "localhost";
$serverUsername = "root";
$serverPassword = "";
$db = 'contentManagementSystemDB';


// create connection to server
$conn = new mysqli($serverName, $serverUsername, $serverPassword, $db);

// check if connection successful.
$conn->connect_error ? die("Connection failed: " . $conn->connect_error . "<br>") : " ";

// Create DB
$sql = "CREATE DATABASE $db";

// $conn->query($sql) ? "Ddatabase created successfully <br>" : die("Error creating database: " . $conn->error) . "<br>";

$sql_table = "CREATE TABLE USER(id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, active BOOLEAN, added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

// Created the USER Table.
// echo $conn->query($sql_table) ? "Table created successfully" : "Error creating table: " . $conn->error

// 
$sql_table_two = "CREATE TABLE posts (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    author INT(11) NOT NULL,
    date DATE NOT NULL,
    added DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
)";



// created table_two for posts
// echo $conn->query($sql_table_two) ? "Table for posts created successfully" : "Connection error: " . $conn->error . "<br>";


