<?php
// set database connection parameters
$database_host = "localhost";
$database_user = "root";
$database_password = "";
$database_name = "studentdatabase";

// connect to the database
$conn = mysqli_connect($database_host, $database_user, $database_password, $database_name);

// check if the user is logged in as admin
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
    // redirect to login page or display error message
    header("Location: login.php");
    exit;
}

// get the ID parameter from the URL
$id = $_GET["id"];

// if the user has confirmed the delete action
if(isset($_POST["delete_confirm"])) {
    // delete the student record from the database
    $stmt = mysqli_prepare($conn, "DELETE FROM studentform WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // redirect to the main page
    header("Location: secret.php");
    exit();
}

// otherwise, show the confirmation prompt
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Student Record</title>
</head>
<body>
    <h2>Confirm Delete</h2>
    <p>Are you sure you want to delete this student record?</p>
    <form method="post">
        <input type="submit" name="delete_confirm" value="Yes">
        <button onclick="window.history.back(); return false;">No</button>
    </form>
</body>
</html>
