<?php

// connection to the database
include "includes/config.php"; //session start
include "includes/database.php"; //database connection
include "includes/functions.php";
secure(); //secures the dashboard page from being accessed without logging in.

include "includes/header.php";






?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

        </div>
    </div>
</div>


<?php
include "includes/footer.php";
?>