<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

include '../connection/connection.php';

// Check if the `id` parameter is provided
if (!isset($_GET['id'])) {
    die("No Order ID specified.");
}

$order_id = intval($_GET['id']);

// Fetch problem details
$query = "SELECT order_number, order_date, order_qty, hospital_department_id, delivery_status 
          FROM equipment_orders 
          WHERE order_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Order not found.");
}

$orders = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_status = $_POST['delivery_status'];

    $conn->begin_transaction(); 

    try {
        // Update delivery status
        $update_query = "UPDATE equipment_orders SET delivery_status = ? WHERE order_number = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $new_status, $order_id);

        if (!$update_stmt->execute()) {
            throw new Exception("Error updating delivery status: " . $conn->error);
        }

        // If status is "Completed", update inventory
        if ($new_status === "Completed") {
            // Fetch the equipment ID and quantity from the current order
            $equipment_id = $orders['hospital_department_id'];
            $order_qty = $orders['order_qty'];

            // Update the inventory in medicalequipment_list
            $inventory_update_query = "UPDATE medicalequipment_list 
                                       SET qty = qty + ? 
                                       WHERE equipment_id = ?";
            $inventory_stmt = $conn->prepare($inventory_update_query);
            $inventory_stmt->bind_param("ii", $order_qty, $equipment_id);

            if (!$inventory_stmt->execute()) {
                throw new Exception("Error updating inventory: " . $conn->error);
            }
        }

        $conn->commit(); // Commit the transaction
        header("Location: supply_orders.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback(); // Rollback the transaction on error
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main_theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Update Delivery Status</title>
    <style>
        .update-container {
            width: 80%;
            margin-left: 20px;
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
        }

        .update-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .update-container form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .update-container form select, 
        .update-container form button {
            width: 40%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
        }

        .update-container form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            width: 10%;
        }

        .update-container form button:hover {
            background-color: #45a049;
        }

        .back-link {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .update-container form .action-buttons {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-top: 10px;
        }

        .update-container form .action-buttons button {
            width: auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .update-container form .action-buttons button:hover {
            background-color: #45a049;
        }

        .update-container form .action-buttons .back-link {
            align-self: center;
            color: #007bff;
            font-size: 14px;
            text-decoration: none;
        }

        .update-container form .action-buttons .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!--------------------Side Menu------------ -->
        <?php include("../common/sidebar.php"); ?>

        <!-------------------Header------------------->
        <div class="main-content">
            <?php include("../common/navbar.php"); ?>

            <div class="update-container">
                <h2>Update Delivery Status: </h2>
                <p><strong>Order Number:</strong> <?php echo htmlspecialchars($orders['order_number']); ?></p>
                <p><strong>Order Date:</strong> <?php echo htmlspecialchars(date('d-m-Y', strtotime($orders['order_date']))); ?></p>
                <p><strong>Order Qty:</strong> <?php echo htmlspecialchars($orders['order_qty']); ?></p>
                
                <form method="POST">
                    <label for="delivery_status">Status:</label>
                    <select name="delivery_status" id="delivery_status">
                        <option value="Pending" <?php echo $orders['delivery_status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Order Placed" <?php echo $orders['delivery_status'] === 'Order Placed' ? 'selected' : ''; ?>>Order Placed</option>
                        <option value="Delivered" <?php echo $orders['delivery_status'] === 'Delivered' ? 'selected' : ''; ?>>Order Delivered</option>
                        <option value="Completed" <?php echo $orders['delivery_status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>

                    <div class="action-buttons">
                        <button type="submit">Update</button>
                        <a href="supply_orders.php" class="back-link">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
if (window.location.search.includes("update=success")) {
    alert("Delivery status updated successfully!");
}
</script>
