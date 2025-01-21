<?php

// Include the database connection file
include('database_connection.php');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $phone = $_POST['number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    // Hash the password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the insert query
    $query = "INSERT INTO users (name, phone, email, password, dob, address) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Bind the parameters
    $stmt->bind_param("ssssss", $name, $phone, $email, $password, $dob, $address);

    // Execute the query
    if ($stmt->execute()) {
        // Get the last inserted ID
        $userId = $stmt->insert_id;

        // Set the session variables
        $_SESSION['user_id'] = $userId;
        $_SESSION['name'] = $name;

        // Redirect to the login page
        header('Location: login.html');
        exit;
    } else {
        // Display an error message
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

?>