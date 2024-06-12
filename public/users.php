<?php

// connection to the database
include "includes/config.php"; //session start
include "includes/database.php"; //database connection
include "includes/functions.php";
secure(); //secures the dashboard page from being accessed without logging in.

include "includes/header.php";

if (isset($_GET['delete'])) {

    // prepared statement
    if ($stm = $conn->prepare('DELETE FROM user WHERE id = ?')) {

        // bind statement
        $stm->bind_param(
            'i',
            $_GET['delete']
        );
        $stm->execute();

        set_message("A user " . $_GET['delete'] . " has been deleted.");
        header('location: users.php');
        $stm->close();
        die();





    } else {
        echo 'Could not prepare statement';
    }
    header('location: users.php');


}

//Want to select current users
if ($stm = $conn->prepare('SELECT * FROM user')) {
    $stm->execute();


    $result = $stm->get_result();



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



                                    <a href="users.php?delete=<?php echo $record['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this user?');">
                                        Delete
                                    </a>
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