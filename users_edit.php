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
    $active = $_POST["active"];
    $id = $_GET['id'];

    // prepared statement
    if ($stm = $conn->prepare('UPDATE  user SET username = ?, email = ?, active = ?  WHERE id = ?')) {
        // bind statement
        $stm->bind_param(
            'sssi',
            $username,
            $email,
            $active,
            $id
        );
        $stm->execute();

        set_message("A User " . $_SESSION['username'] . " has been updated.");
        header('location: users.php');
        $stm->close();
        die();


    } else {
        echo 'Could not prepare statement';
    }

}


if (isset($_GET['id'])) {
    // prepared statement

    if ($stm = $conn->prepare('SELECT * FROM user WHERE id= ?')) {

        // bind statement
        $stm->bind_param(
            'i',
            $_GET['id']
        );
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc(); //fetch user where parameter is true.

        if ($user) {

            ?>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-2">Edit User</h1>

                        <form method="post">
                            <!-- Username input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="username" name="username" class="form-control active"
                                    value="<?php echo $user['username']; ?>" />
                                <label class="form-label" for="username">Username</label>
                            </div>

                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control active"
                                    value="<?php echo $user['email']; ?>" />
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
                                    <option <?php echo ($user['active']) ? 'selected' : ''; ?> value="1">Active</option>
                                    <option <?php echo ($user['active']) ? '' : 'selected'; ?> value="0">Inactive</option>
                                </select>
                            </div>


                            <!-- Submit button -->
                            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Update user</button>
                        </form>

                    </div>
                </div>
            </div>

            <?php
            die();
        } else {

            echo "This User was not found";

        }
        $stm->close();


    } else {
        echo 'Could not prepare statement';
    }
} else {
    echo "No User selected";
    die();
}

include "includes/footer.php";
?>