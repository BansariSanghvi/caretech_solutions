<?php
session_start();
include '../connection/connection.php';

// Check user permission (e.g., admin or branch manager)
if ($_SESSION['role'] != 'admin') {
    header('Location: unauthorized.php');
    exit;
}

$order_id = $_POST['order_id'];
$new_status = $_POST['delivery_status']; 

// Update the order status
$updateOrderQuery = "UPDATE equipment_orders SET delivery_status = ? WHERE order_number = ?";
$stmt = $conn->prepare($updateOrderQuery);
$stmt->bind_param("si", $new_status, $order_id);

if ($stmt->execute()) {
    echo "Order status updated successfully.<br>";

    // If the order is marked as "Complete", update the inventory
    if ($new_status === 'Complete') {
        $inventoryUpdateQuery = "SELECT equipment_ID, order_qty FROM equipment_orders WHERE order_number = ?";
        $inventoryStmt = $conn->prepare($inventoryUpdateQuery);
        $inventoryStmt->bind_param("i", $order_id);
        $inventoryStmt->execute();
        $inventoryResult = $inventoryStmt->get_result();

        if ($inventoryResult->num_rows > 0) {
            $order = $inventoryResult->fetch_assoc();
            $equipment_ID = $order['equipment_ID'];
            $order_qty = $order['order_qty'];

            // Update the inventory
            $updateInventoryQuery = "UPDATE medicalEquipment_list SET qty = qty + ? WHERE equipment_ID = ?";
            $inventoryUpdateStmt = $conn->prepare($updateInventoryQuery);
            $inventoryUpdateStmt->bind_param("ii", $order_qty, $equipment_ID);

            if ($inventoryUpdateStmt->execute()) {
                echo "Inventory updated for equipment ID: $equipment_ID.<br>";

                // Mark the order as inventory updated (optional but recommended)
                $markAsUpdatedQuery = "UPDATE equipment_orders SET inventory_updated = TRUE WHERE order_number = ?";
                $markAsUpdatedStmt = $conn->prepare($markAsUpdatedQuery);
                $markAsUpdatedStmt->bind_param("i", $order_id);
                $markAsUpdatedStmt->execute();
            } else {
                echo "Failed to update inventory for equipment ID: $equipment_ID.<br>";
            }

            $inventoryUpdateStmt->close();
        }

        $inventoryStmt->close();
    }
} else {
    echo "Failed to update order status.<br>";
}

$stmt->close();
$conn->close();
?>
