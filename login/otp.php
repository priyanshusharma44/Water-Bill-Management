<?php
session_start(); // Start the session

// Check if the OTP form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['first'], $_POST['second'], $_POST['third'], $_POST['fourth'])) {
    // Get the entered OTP
    $enteredFirst = $_POST['first'];
    $enteredSecond = $_POST['second'];
    $enteredThird = $_POST['third'];
    $enteredFourth = $_POST['fourth'];

    // Retrieve the stored OTP from the session
    if(isset($_SESSION['otp'])) {
        $storedOTP = $_SESSION['otp'];

        // Compare the entered OTP with the stored OTP
        if ($enteredFirst == $storedOTP[0] && $enteredSecond == $storedOTP[1] && $enteredThird == $storedOTP[2] && $enteredFourth == $storedOTP[3]) {
            // If OTP matches, redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            // If OTP does not match, display an error message
            $errorMessage = "Incorrect OTP. Please try again.";
        }
    } else {
        // If OTP is not set in session, display an error message
        $errorMessage = "OTP is not set. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <h2>OTP Verification</h2>
    <form action="otp.php" method="post">
        <input type="number" name="first"  required>
        <input type="number" name="second"  required>
        <input type="number" name="third"  required>
        <input type="number" name="fourth"  required><br>
        <button type="submit">Verify OTP</button>
    </form>
    <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>"; ?>
</body>
</html>
