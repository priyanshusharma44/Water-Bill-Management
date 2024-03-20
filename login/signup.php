<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wbms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if name, email, and password are set in the $_POST array
    if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if email already exists
        $sql = "SELECT * FROM wbms WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Email already exists";
        } else {
            // Generate OTP
            $otp = rand(1000, 9999);

            // Insert user data into the database
            $sql = "INSERT INTO wbms (email, password, otp) VALUES ('$email', '$password', '$otp')";
            if ($conn->query($sql) === TRUE) {
                // Send OTP email
                sendOTP($email, $otp);
                // Redirect to OTP verification page
                header("Location: otp.php?email=$email");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Please fill in all required fields.";
    }
}

// Close connection
$conn->close();

// Function to send OTP email
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'serjoramos4444@gmail.com';
        $mail->Password = 'ymlgikngcfcnznel';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipient
        $mail->setFrom('serjoramos4444@gmail.com', 'Administration');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body = 'Your OTP is: ' . $otp;

        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>