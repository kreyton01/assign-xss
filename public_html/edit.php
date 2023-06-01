<?php
// set database connection parameters
// Set database connection parameters
$database_host = "localhost";
$database_user = "root";
$database_password = "";
$database_name = "studentdatabase";

// Connect to the database
$conn = mysqli_connect($database_host, $database_user, $database_password, $database_name);

// Check if the user is logged in as admin
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
    // Redirect to login page or display error message
    header("Location: index.php");
    exit;
}

// Check if the form has been submitted
if(isset($_POST["submit"])) {
    // Get form data
    $id = $_POST["id"];
    $name = $_POST["name"];
    $matric_no = $_POST["matric_no"];
    $current_address = $_POST["current_address"];
    $email = $_POST["email"];
    $mobile_phone = $_POST["mobile_phone"];
    $home_phone = $_POST["home_phone"];

    // Update the data in the database
    $query = "UPDATE studentform SET name='$name', matric_no='$matric_no', current_address='$current_address', email='$email', mobile_phone='$mobile_phone', home_phone='$home_phone' WHERE id=$id";
    mysqli_query($conn, $query);

    // Redirect to data page
    header("Location: secret.php");
    exit;
}

// Get the ID parameter from the URL
$id = $_GET["id"];

// Fetch data for the selected ID from the database
$query = "SELECT * FROM studentform WHERE id=$id";
$result = mysqli_query($conn, $query);

// Check if the query returned any rows
if(mysqli_num_rows($result) > 0) {
    // Access the data from the row as needed
    $row = mysqli_fetch_assoc($result);

    // Display the form for editing the data
    echo "<form method='POST'>";
    echo "<input type='hidden' name='id' value='" . $row["id"] . "'/>";
    
    echo "Name: <input type='text' name='name' value='" . $row["name"] . "' size='40'/><br/>";
    
    echo "Matric No: <input type='text' name='matric_no' value='" . $row["matric_no"] . "' size='40'/><br/>";
    
    echo "Current Address: <input type='text' name='current_address' value='" . $row["current_address"] . "' size='60'/><br/>";
    
    echo "Email: <input type='email' name='email' value='" . $row["email"] . "' size='40'/><br/>";
    
    echo "Mobile Phone: <input type='tel' name='mobile_phone' value='" . $row["mobile_phone"] . "' size='40'/><br/>";
    
    echo "Home Phone: <input type='tel' name='home_phone' value='" . $row["home_phone"] . "' size='40'/><br/>";
    
    echo "<input type='submit' name='submit' value='Save Changes'/>";
        
    echo "</form>";
    
} else {
    // Handle the case where no row was returned
    echo "No data found for ID: $id";
}

// Close database connection
mysqli_close($conn);

?>
