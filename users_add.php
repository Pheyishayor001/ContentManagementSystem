<?php

// connection to the database
include "includes/config.php"; //session start
include "includes/database.php"; //database connection
include "includes/functions.php";
secure(); //secures the dashboard page from being accessed without logging in.

include "includes/header.php";

if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $active = $_POST["active"];

    // prepared statement
    if ($stm = $conn->prepare('INSERT INTO user(username, email, password, active) VALUE(?, ?, ?, ?)')) {
        // hash password for security reasons
        $hashed_password = SHA1($password); //encoded on the DB as SHA1 decoded from the UI as SHA1.

        // bind statement
        $stm->bind_param(
            'ssss',
            $username,
            $email,
            $hashed_password,
            $active
        );
        $stm->execute();

        set_message("A new user " . $_SESSION['username'] . " has been added.");
        header('location: users.php');
        $stm->close();
        die();




        // $conn->close();
    } else {
        // DEV PURPOSE
        // The echo message should not be here, but as it is written above.
        // echo 'Could not find user';
    }

}


?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-2">Add User</h1>

            <form method="post">
                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">Username</label>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Active Select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select class="form-select" name="active" id="active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>


                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add user</button>
            </form>

        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>