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
    $author = $_SESSION["id"];
    $date = $_POST["date"];
    $id = $_GET['id'];

    // prepared statement
    if ($stm = $conn->prepare('UPDATE  posts SET title = ?, content = ?, author = ?, date = ?  WHERE id = ?')) {
        // bind statement
        $stm->bind_param(
            'ssisi',
            $title,
            $content,
            $author,
            $date,
            $id

        );
        $stm->execute();

        $stm->close();


        header('location: posts.php');
        set_message("Post ID" . $id . " has been updated.");
        die();

    } else {
        echo 'Could not prepare post update statement';
    }

}



if (isset($_GET['id'])) {
    // prepared statement

    if ($stm = $conn->prepare('SELECT * FROM posts WHERE id = ?')) {

        // bind statement
        $stm->bind_param(
            'i',
            $_GET['id']
        );
        $stm->execute();

        $result = $stm->get_result();
        $posts = $result->fetch_assoc(); //fetch user where parameter is true.

        if ($posts) {

            ?>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h1 class="display-2">Edit Post</h1>

                        <form method="post">
                            <!-- Title input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="message" id="title" name="title" class="form-control"
                                    value="<?php echo $posts['title']; ?>" />
                                <label class="form-label" for="title">Title</label>
                            </div>


                            <!-- Content input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <textarea name="content" id="content"><?php echo $posts['content']; ?></textarea>
                            </div>

                            <!-- Date Select -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="date" id="date" name="date" class="form-control"
                                    value="<?php echo $posts['date']; ?>" />
                                <label class="form-label" for="date">Date</label>
                            </div>


                            <!-- Submit button -->
                            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Edit Post</button>
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
        } else {

            echo "This Post was not found";

        }
        $stm->close();


    } else {
        echo 'Could not prepare statement';
    }
} else {
    echo "No post selected";
    die();
}

include "includes/footer.php";
?>