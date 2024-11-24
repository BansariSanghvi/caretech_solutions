<?php
include("connection/connection.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and validate
    $medicine_name = isset($_POST["medicine-name"]);
    $decription = isset($_POST["side-effects"]);
    $supplier_name = isset($_POST["supplier-name"]);
    $price = isset($_POST["price"]);

    // Prepare and execute the SQL query
    $sql = "INSERT INTO drugs_list (drugName, manufacturer, description, price) 
            VALUES (?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssd", $medicine_name, $supplier_name, $decription, $price);

    // Execute the query
    if ($stmt->execute()) {
        echo "Medicine added successfully!";
        header("Location: medicineList.php"); // Redirect to another page
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
