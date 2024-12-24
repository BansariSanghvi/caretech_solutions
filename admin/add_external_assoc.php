<?php
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data 
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $location = $_POST["location"];


    // Prepare and execute the SQL query
    $sql = "INSERT INTO external_associations (medical_association_name, associations_email,associations_location, associations_phone, hospital_id) 
            VALUES (?, ?, ?, ?, 1)";  

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters 
    $stmt->bind_param("ssss", $name, $email, $location, $phone );

    // Execute the query
    if ($stmt->execute()) {
        echo " Association added successfully!";
        header("Location: medical_associationsList.php"); 
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
