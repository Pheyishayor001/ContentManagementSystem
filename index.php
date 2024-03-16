<?php
// connection to the database
include "includes/config.php";
include "includes/database.php";
include "includes/functions.php";

include "includes/header.php";

// If a session is set the log in page should not be accessible unless when the user is logged out. The dashboard is the home page.
if (isset($_SESSION['id'])) {
    header('location: dashboard.php');
    die();
}


if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // prepared statement
    if ($stm = $conn->prepare('SELECT * FROM user WHERE email = ? AND password = ? AND active = 1')) {
        // hash password for security reasons`
        $hashed_password = SHA1($password); //encoded on the DB as SHA1 decoded from the UI as SHA1.

        // bind statement
        $stm->bind_param(
            'ss',
            $email,
            $hashed_password
        );
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc(); //fetch user where parameter is true.

        if ($user) {
            // Store user's info in session
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            set_message("You have successfully logged in " . $_SESSION['username']);

            header('Location: dashboard.php');
            die();
        } else {
            // Write code for different error messages for different instances here.
            echo "This User does not exist";
        }
        $stm->close();

        // $conn->close();
    } else {
        // DEV PURPOSE
        echo 'Could not prepare statement';
    }

}
?>



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post">
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

                <!-- 2 column grid layout for inline styling -->

                <!-- WORK ON THE FORGOT PASSWORD LINK -->
                <!-- <div class="row mb-4">
                    <div class="col"> -->
                <!-- Simple link -->
                <!-- <a href="#!">Forgot password?</a>
                    </div>
                </div> -->

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
        </div>
    </div>
</div>


<?php
include "includes/footer.php";
?>