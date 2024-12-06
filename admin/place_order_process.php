<?php
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data 
    $equipment_ID = $_POST['equipment_ID'];
    $order_qty = $_POST['order_qty'];
    $hospital_department_id = $_POST['hospital_department_id'];
    $supplier_id = $_POST['supplier_id'];

    // Validate data
    if (!is_numeric($hospital_department_id) || !is_numeric($equipment_ID) || !is_numeric($supplier_id)) {
        echo "Invalid data. Please check your input.";
        exit();
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO equipment_orders (equipment_ID, order_qty, order_date, hospital_department_id, supplier_id) 
            VALUES (?, ?, CURRENT_DATE(), ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("iisi", $equipment_ID, $order_qty, $hospital_department_id, $supplier_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Order added successfully!";
        header("Location: supply_orders.php"); // Redirect to the orders page
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
