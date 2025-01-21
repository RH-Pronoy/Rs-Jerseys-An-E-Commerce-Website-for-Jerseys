<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['dob']) && isset($_POST['address'])) { // Changed 'number' to 'phone'
        $user_id = $_SESSION['user_id'];
        $name = $_POST['name'];
        $phone = $_POST['phone']; // Changed 'number' to 'phone'
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];

        $conn = new mysqli("localhost", "root", "", "rsjersey");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, email = ?, dob = ?, address = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $phone, $email, $dob, $address, $user_id); // Changed 'number' to 'phone'

        if ($stmt->execute()) {
            $_SESSION['user_name'] = $name;
            $_SESSION['user_phone'] = $phone; // Changed 'number' to 'phone'
            $_SESSION['user_address'] = $address;
            header("Location: profile.php"); // Redirect to profile after success
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "All form fields are required.";
    }
}
?>
