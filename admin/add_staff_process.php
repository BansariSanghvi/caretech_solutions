<?php
include("connection/connection.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $hospital_id = $_POST['hospital']; // Correctly retrieve hospital_id

    // Prepare and execute the SQL query
    $sql = "INSERT INTO staff_records (fname, lname, email, role, department, staff_phone_no, hospital_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssss", $first_name, $last_name, $email, $role, $department, $phone, $hospital_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Staff member added successfully!";
        header("Location: staff_hub.php"); // Redirect to another page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

