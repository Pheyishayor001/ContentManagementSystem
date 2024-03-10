<?php

// connection to the database
include "includes/config.php"; //session start
include "includes/database.php"; //database connection
include "includes/functions.php";
secure(); //secures the dashboard page from being accessed without logging in.

include "includes/header.php";

//Want to select current users
if ($stm = $conn->prepare('SELECT * FROM user')) {
    $stm->execute();


    $result = $stm->get_result();
    // $user = $result->fetch_assoc(); //fetch user where parameter is true.
    // var_dump($result);


    if ($result->num_rows > 0) {

        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1 class="display-2">User's Management</h1>
                    <table class="table table-stripped table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th>Edit | Delete</th>
                        </tr>

                        <!-- Using the while loop to call data/users from the DB. The forEach loop doesn't work well.-->
                        <?php while ($record = mysqli_fetch_assoc($result)) { //loops over individual data of users ?>
                            <tr>
                                <td>
                                    <?php echo $record['id'] ?>
                                </td>
                                <td>
                                    <?php echo $record['username'] ?>
                                </td>
                                <td>
                                    <?php echo $record['email'] ?>
                                </td>
                                <td>
                                    <?php echo $record['active'] ? 'Active' : 'Inactive' ?>
                                </td>
                                <td><a href="users_edit.php?id=<?php echo $record['id']; ?>">Edit</a>

                                    <a href="users.php?delete=<?php echo $record['id']; ?>">Delete</a>
                                </td>
                            </tr>

                        <?php } ?>
                    </table>

                    <a href="users_add.php">Add new user</a>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo 'No users found';
    }
    $stm->close();
} else {
    echo 'Could not prepare statement';
}

include "includes/footer.php";
?>