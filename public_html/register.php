<?php
session_start();
// connect to database
require_once('../app/config.php');

// connect to the database
$conn = mysqli_connect($database_host, $database_user, $database_password, $database_name);

// check if user has submitted the form and CSRF token is valid
if (
    isset($_POST['username']) && isset($_POST['password']) &&
    isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']
) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists in the database
    $sql_check = "SELECT * FROM users WHERE username='$username'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Show error message and redirect to registration page
        echo "<script>showError('Error: Username already exists. Please choose a different username.');</script>";
    } elseif (strlen($password) < 8) {
        // Show error message and redirect to registration page
        echo "<script>showError('Error: Password must be at least 8 characters long. Please try again.');</script>";
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        // Show error message and redirect to registration page
        echo "<script>showError('Error: Username must contain only letters and numbers. Please try again.');</script>";
    } else {
        // Insert the username and hashed password into the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES ('$username','$hashed_password')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Get the generated ID
            $id = mysqli_insert_id($conn);
            // Registration successful, display success message and redirect to login page
            echo "<script>alert('User registration successful! Please login.');</script>";
            header("Location: ../public_html/index.php?success=User registration successful! Please login.");
            exit();
        } else {
            // Show error message and redirect to registration page
            echo "<script>showError('Error: Could not register user. Please try again.');</script>";
        }
    }
} else {
    // Invalid CSRF token or form submission, redirect to index.php
    header('Location: ../public_html/index.php?error=Invalid form submission.');
    exit();
}
?>
