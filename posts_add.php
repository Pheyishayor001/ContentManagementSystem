<?php

// connection to the database
include "includes/config.php"; //session start
include "includes/database.php"; //database connection
include "includes/functions.php";
secure(); //secures the dashboard page from being accessed without logging in.

include "includes/header.php";


if (isset($_POST["title"])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $author = $_SESSION['id'];
    $date = $_POST["date"];

    // prepared statement
    if ($stm = $conn->prepare('INSERT INTO posts(title, content, author, date) VALUE(?, ?, ?, ?)')) {
        // bind statement
        $stm->bind_param(
            'ssis',
            $title,
            $content,
            $author,
            $date
        );
        $stm->execute();

        set_message("A new post has been added by" . $_SESSION['username'] . ".");
        header('location: posts.php');
        $stm->close();
        die();

    } else {
        echo 'Could not prepare statement';
    }

}


?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="display-2">Add Post</h1>

            <form method="post">
                <!-- Title input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="message" id="title" name="title" class="form-control" />
                    <label class="form-label" for="title">Title</label>
                </div>


                <!-- Content input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea name="content" id="content"></textarea>
                </div>

                <!-- Date Select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="date" id="date" name="date" class="form-control" />
                    <label class="form-label" for="date">Date</label>
                </div>


                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add Post</button>
            </form>


        </div>

    </div>
</div>

<!-- include tinymce script -->
<script src="js/tinymce/tinymce.min.js"></script>
<!-- Run the tinymce script -->
<script>
    tinymce.init({
        selector: "#content"
    });
</script>

<?php
include "includes/footer.php";
?>