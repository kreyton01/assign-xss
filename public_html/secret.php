
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
    header("Location: index.php");
    exit;
}

// fetch data from the "studentform" table
$sql = "SELECT * FROM studentform";
$result = mysqli_query($conn, $sql);

// display data in a table
echo "<table>";
echo "<tr><th>Name</th>
<th>Matric</th>
<th>Current Address</th>
<th>Email</th>
<th>Mobile Phone</th>
<th>Home Phone</th>
<th>Action</th>


</tr>";
while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["matric_no"] . "</td>";
    echo "<td>" . $row["current_address"] . "</td>";
    echo "<td>" . $row["email"] . "</td>";
    echo "<td>" . $row["mobile_phone"] . "</td>";
    echo "<td>" . $row["home_phone"] . "</td>";
   
    echo "<td><a href='edit.php?id=" . $row["id"] . "'>Edit</a> | <a href='delete.php?id=" . $row["id"] . "'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";

// close database connection
mysqli_close($conn);
?>
