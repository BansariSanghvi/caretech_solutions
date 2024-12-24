<?php
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data 
    $name = $_POST["name"];
    $email = $_POST["email"];


    // Prepare and execute the SQL query
    $sql = "DELETE FROM external_associations WHERE medical_association_name = ? AND associations_email = ?";
              

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters 
    $stmt->bind_param("ss", $name, $email);

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
