<?php


// Database configuration
$servername = "localhost"; // Replace with your MySQL server address
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "wbms"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email and password from the sign-in form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to check if the email and password exist
    $sql = "SELECT * FROM wbms WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if a matching record is found
    if (mysqli_num_rows($result) == 1) {
        // Redirect the user to the main page
        header("Location: index.php");
        exit();
    } else {
        // Display an error message
        echo "Incorrect email or password. Please try again.";
    }
}

?>



