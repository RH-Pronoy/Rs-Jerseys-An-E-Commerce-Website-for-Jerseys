<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "", "rsjersey");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, name,phone, password, address FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $number,$hashed_password, $address);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            // Set user session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_phone'] = $number;
            $_SESSION['user_address'] = $address;
            // Redirect to profile page
            header("Location: profile.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}

// Display error message if exists
if (isset($error_message)) {
    echo $error_message;
}
?>
