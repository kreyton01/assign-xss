<?php
session_start();

// connect to database
require_once('../app/config.php');
$conn = mysqli_connect($database_host, $database_user, $database_password, $database_name);

// check if user has submitted the form and CSRF token is valid
if (
    isset($_POST['username']) && isset($_POST['password']) &&
    isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']
) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // retrieve user from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    // check if user exists in the database
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];

        // verify password
        if (password_verify($password, $db_password)) {
            // login successful, save user session
            $_SESSION['username'] = $username;

            // redirect to home.php or secret.php if the username is "admin"
            if ($username === 'admin') {
                header("Location: secret.php");
            } else {
                header("Location: home.php");
            }
        } else {
            // login failed, display error message
            header('Location: index.php?error=Invalid username or password.');
        }
    } else {
        // login failed, display error message
        header('Location: index.php?error=Invalid username.');
    }
} else {
    // Invalid CSRF token or form submission, redirect to index.php
    header('Location: index.php?error=Invalid form submission.');
}
?>
