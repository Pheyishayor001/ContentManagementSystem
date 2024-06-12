<?php

// connection to the database
include "includes/config.php"; //session start
include "includes/database.php"; //database connection
include "includes/functions.php";
secure(); //secures the dashboard page from being accessed without logging in.

include "includes/header.php";

if (isset($_GET['delete'])) {


    // prepared statement
    if ($stm = $conn->prepare('DELETE FROM posts WHERE id = ?')) {

        // bind statement
        $stm->bind_param(
            'i',
            $_GET['delete']
        );
        $stm->execute();

        set_message("A post, ID " . $_GET['delete'] . ", has been deleted.");
        header('location: posts.php');
        $stm->close();
        die();





    } else {
        echo 'Could not prepare statement';
    }
    header('location: posts.php');


}

//Want to select current posts
if ($stm = $conn->prepare('SELECT * FROM posts')) {
    $stm->execute();


    $result = $stm->get_result();



    if ($result->num_rows > 0) {

        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1 class="display-2">Posts Management</h1>
                    <table class="table table-stripped table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Author's ID</th>
                            <th>Content</th>
                            <th>Date</th>
                            <th>Edit | Delete</th>
                        </tr>

                        <!-- Using the while loop to call data/users from the DB. The forEach loop doesn't work well.-->
                        <?php while ($record = mysqli_fetch_assoc($result)) { //loops over individual data of users which is in form of an array ?>
                            <tr>
                                <td>
                                    <?php echo $record['id'] ?>
                                </td>
                                <td>
                                    <?php echo $record['title'] ?>
                                </td>
                                <td>
                                    <?php echo $record['author'] ?>
                                </td>
                                <td>
                                    <?php echo $record['content'] ?>
                                </td>
                                <td>
                                    <?php echo $record['date'] ?>
                                </td>
                                <td><a href="posts_edit.php?id=<?php echo $record['id']; ?>">Edit</a>

                                    <a href="posts.php?delete=<?php echo $record['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this post?');">
                                        Delete
                                    </a>

                                </td>
                            </tr>

                        <?php } ?>
                    </table>

                    <a href="posts_add.php">Add new Post</a>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo 'No posts found';
    }
    $stm->close();
} else {
    echo 'Could not prepare statement';
}

include "includes/footer.php";
?>