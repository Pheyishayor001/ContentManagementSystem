<?php
$serverName = "mysql.db.mdbgo.com";
$serverUsername = "feyisayo_cms1";
$serverPassword = "NexusPrime2#";
$db = 'feyisayo_cms1';


// create connection to server
$conn = new mysqli($serverName, $serverUsername, $serverPassword, $db);

// check if connection successful. With a tenary operator.
$conn->connect_error ? die("Connection failed: " . $conn->connect_error . "<br>") : " ";





