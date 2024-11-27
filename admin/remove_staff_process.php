// Note to self: Come back to this. Doubt about Reason for Leave. 

<?php
include("connection/connection.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $id = $POST['staff_id'];
    $hospital_id = $_POST['hospital']; 

    // Prepare and execute the SQL query
    $sql = "DELETE FROM staff_records (fname, lname, , hospital_id) 
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

