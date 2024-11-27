<?php
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data 
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $hospital_department_id = $_POST['hospital_department_id'];  
    $hospital_id = $_POST['hospital_id'];

    // Validate data 
    if (!is_numeric($hospital_department_id) || !is_numeric($hospital_id)) {
        echo "Invalid hospital or department ID.";
        exit();
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO staff_records (fname, lname, email, role, staff_phone_no, hospital_department_id, hospital_id, isActive) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 1)";  // Setting isActive to 1 by default

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters 
    $stmt->bind_param("ssssiii", $first_name, $last_name, $email, $role, $phone, $hospital_department_id, $hospital_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Staff member added successfully!";
        header("Location: staff_hub.php"); // Redirect to the staff hub page
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
